<?php
namespace App\Http\Controllers;
use App\Models\Order;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

    public function index()
    {
        $orders=$this->orderRepository->getAllPaginated();
        $dashboardData = DB::table('Orders')
            ->selectRaw("
        SUM(total_amount) AS TotalAmount,
        SUM(CASE WHEN status='processing' THEN total_amount ELSE 0 END) AS TotalProcessingAmount,
        SUM(CASE WHEN status='delivered' THEN total_amount ELSE 0 END) AS TotalDeliveredAmount,
        SUM(CASE WHEN status='canceled' THEN total_amount ELSE 0 END) AS TotalCanceledAmount,
        COUNT(*) AS Total,
        SUM(CASE WHEN status='processing' THEN 1 ELSE 0 END) AS TotalProcessing,
        SUM(CASE WHEN status='delivered' THEN 1 ELSE 0 END) AS TotalDelivered,
        SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) AS TotalCanceled
    ")->first();
        $monthlyData =Order::selectRaw("
    MONTH(created_at) AS MonthNo,
    DATE_FORMAT(created_at, '%b') AS MonthName,
    SUM(	total_amount) AS TotalAmount,
    SUM(CASE WHEN status = 'processing' THEN 	total_amount ELSE 0 END) AS TotalProcessingAmount,
    SUM(CASE WHEN status = 'delivered' THEN 	total_amount ELSE 0 END) AS TotalDeliveredAmount,
    SUM(CASE WHEN status = 'canceled' THEN 	total_amount ELSE 0 END) AS TotalCanceledAmount
")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')")
            ->get();
        $AmountM = $monthlyData->pluck('TotalAmount')->implode(',');
        $ProcessingAmountM = $monthlyData->pluck('TotalProcessingAmount')->implode(',');
        $DeliveredAmountM = $monthlyData->pluck('TotalDeliveredAmount')->implode(',');
        $CanceledAmountM = $monthlyData->pluck('TotalCanceledAmount')->implode(',');
        $TotalAmount = $monthlyData->sum('TotalAmount');
        $TotalProcessingAmount = $monthlyData->sum('TotalProcessingAmount');
        $TotalDeliveredAmount = $monthlyData->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = $monthlyData->sum('TotalCanceledAmount');
        return view('admin.index',compact('orders','dashboardData','AmountM','ProcessingAmountM','DeliveredAmountM','CanceledAmountM','TotalAmount','TotalProcessingAmount','TotalDeliveredAmount','TotalCanceledAmount'));
    }
}
