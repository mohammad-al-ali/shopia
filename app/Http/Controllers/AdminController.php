<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class AdminController
 *
 * Handles the logic for the admin dashboard, including:
 * - Displaying all orders with pagination.
 * - Aggregating dashboard statistics (total orders, amounts by status, etc.).
 * - Building monthly data summaries depending on the database type.
 */
class AdminController extends Controller
{
    /**
     * The repository for managing order data.
     *
     * @var OrderRepository
     */
    protected OrderRepository $orderRepository;

    /**
     * AdminController constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display the admin dashboard with order statistics and monthly reports.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Determine which database type is currently in use,ether MySql ,or SQLite.
        $dbType = app(\App\Services\DatabaseTypeService::class)->getDatabaseType();

        // Retrieve paginated orders
        $orders = $this->orderRepository->getAllPaginated();

        // Gather overall statistics about orders
        $dashboardData = DB::table('orders')
            ->selectRaw("
                SUM(total_amount) AS TotalAmount,
                SUM(CASE WHEN status='processing' THEN total_amount ELSE 0 END) AS TotalProcessingAmount,
                SUM(CASE WHEN status='delivered' THEN total_amount ELSE 0 END) AS TotalDeliveredAmount,
                SUM(CASE WHEN status='canceled' THEN total_amount ELSE 0 END) AS TotalCanceledAmount,
                COUNT(*) AS Total,
                SUM(CASE WHEN status='processing' THEN 1 ELSE 0 END) AS TotalProcessing,
                SUM(CASE WHEN status='delivered' THEN 1 ELSE 0 END) AS TotalDelivered,
                SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) AS TotalCanceled
            ")
            ->first();if ($dbType === 'MySQL') {
        $monthlyData = Order::selectRaw("
        MONTH(created_at) AS MonthNo,
        DATE_FORMAT(created_at, '%b') AS MonthName,
        SUM(total_amount) AS TotalAmount,
        SUM(CASE WHEN status = 'processing' THEN total_amount ELSE 0 END) AS TotalProcessingAmount,
        SUM(CASE WHEN status = 'delivered' THEN total_amount ELSE 0 END) AS TotalDeliveredAmount,
        SUM(CASE WHEN status = 'canceled' THEN total_amount ELSE 0 END) AS TotalCanceledAmount
    ")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')")
            ->get();

    } elseif ($dbType === 'SQLite') {
        $monthlyData = Order::selectRaw("
        CAST(strftime('%m', created_at) AS INTEGER) AS MonthNo,
        SUM(total_amount) AS TotalAmount,
        SUM(CASE WHEN status = 'processing' THEN total_amount ELSE 0 END) AS TotalProcessingAmount,
        SUM(CASE WHEN status = 'delivered' THEN total_amount ELSE 0 END) AS TotalDeliveredAmount,
        SUM(CASE WHEN status = 'canceled' THEN total_amount ELSE 0 END) AS TotalCanceledAmount
    ")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("strftime('%Y', created_at), strftime('%m', created_at)")
            ->get()
            ->map(function ($row) {
                // تحويل رقم الشهر لاسم (Jan, Feb, ...)
                $row->MonthName = date('M', mktime(0, 0, 0, $row->MonthNo, 1));
                return $row;
            });

    } else {
        $monthlyData = collect();
    }
        // Prepare monthly amounts for chart rendering
        $AmountM = $monthlyData->pluck('TotalAmount');
        $ProcessingAmountM = $monthlyData->pluck('TotalProcessingAmount');
        $DeliveredAmountM = $monthlyData->pluck('TotalDeliveredAmount');
        $CanceledAmountM = $monthlyData->pluck('TotalCanceledAmount');

        // Calculate yearly totals
        $TotalAmount = $monthlyData->sum('TotalAmount');
        $TotalProcessingAmount = $monthlyData->sum('TotalProcessingAmount');
        $TotalDeliveredAmount = $monthlyData->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = $monthlyData->sum('TotalCanceledAmount');

        // Return the admin dashboard view with all required data
        return view('admin.index', compact(
            'orders',
            'dashboardData',
            'AmountM',
            'ProcessingAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalProcessingAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));
    }
}
