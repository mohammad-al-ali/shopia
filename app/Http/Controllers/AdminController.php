<?php
namespace App\Http\Controllers;
use App\Models\Order;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    protected OrderRepository $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }
    public function index()
    {
        // First, figure out which database we're using
        $dbType = app(\App\Services\DatabaseTypeService::class)->getDatabaseType();

        // Get paginated orders as usual
        $orders = $this->orderRepository->getAllPaginated();

        // Gather some overall stats about orders
        $dashboardData = DB::table('orders') // make sure your table name is lowercase
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
            ->first();

        // Now build monthly data, but it depends on the DB type
        if ($dbType === 'MySQL') {
            // MySQL has handy date functions, so use those
            $monthlyData = \App\Models\Order::selectRaw("
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
            // SQLite doesn’t have those functions, so use strftime instead
            $monthlyData = \App\Models\Order::selectRaw("
            CAST(strftime('%m', created_at) AS INTEGER) AS MonthNo,
            strftime('%b', created_at) AS MonthName,
            SUM(total_amount) AS TotalAmount,
            SUM(CASE WHEN status = 'processing' THEN total_amount ELSE 0 END) AS TotalProcessingAmount,
            SUM(CASE WHEN status = 'delivered' THEN total_amount ELSE 0 END) AS TotalDeliveredAmount,
            SUM(CASE WHEN status = 'canceled' THEN total_amount ELSE 0 END) AS TotalCanceledAmount
        ")
                ->whereRaw("strftime('%Y', created_at) = ?", [now()->year])
                ->groupByRaw("strftime('%Y', created_at), strftime('%m', created_at), strftime('%b', created_at)")
                ->get();

        } else {
            // If it’s something else, just return an empty collection for safety
            $monthlyData = collect();
        }

        // Prepare the monthly amounts for charts or whatever you need
        $AmountM = $monthlyData->pluck('TotalAmount')->implode(',');
        $ProcessingAmountM = $monthlyData->pluck('TotalProcessingAmount')->implode(',');
        $DeliveredAmountM = $monthlyData->pluck('TotalDeliveredAmount')->implode(',');
        $CanceledAmountM = $monthlyData->pluck('TotalCanceledAmount')->implode(',');

        // Also sum up the totals for the whole year
        $TotalAmount = $monthlyData->sum('TotalAmount');
        $TotalProcessingAmount = $monthlyData->sum('TotalProcessingAmount');
        $TotalDeliveredAmount = $monthlyData->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = $monthlyData->sum('TotalCanceledAmount');

        // Finally, pass everything to the view
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
