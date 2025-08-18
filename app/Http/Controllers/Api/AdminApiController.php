<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllPaginated(7);

        // إحصائيات عامة
        $dashboardData = DB::table('orders')
            ->selectRaw("
                SUM(total_amount) AS totalAmount,
                SUM(CASE WHEN status='processing' THEN total_amount ELSE 0 END) AS totalProcessingAmount,
                SUM(CASE WHEN status='delivered' THEN total_amount ELSE 0 END) AS totalDeliveredAmount,
                SUM(CASE WHEN status='canceled' THEN total_amount ELSE 0 END) AS totalCanceledAmount,
                COUNT(*) AS totalOrders,
                SUM(CASE WHEN status='processing' THEN 1 ELSE 0 END) AS totalProcessing,
                SUM(CASE WHEN status='delivered' THEN 1 ELSE 0 END) AS totalDelivered,
                SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) AS totalCanceled
            ")
            ->first();

        // إحصائيات شهرية
        $monthlyData = Order::selectRaw("
                strftime('%m', created_at) AS monthNo,
                strftime('%m', created_at) AS monthName,
                SUM(total_amount) AS totalAmount,
                SUM(CASE WHEN status = 'processing' THEN total_amount ELSE 0 END) AS totalProcessingAmount,
                SUM(CASE WHEN status = 'delivered' THEN total_amount ELSE 0 END) AS totalDeliveredAmount,
                SUM(CASE WHEN status = 'canceled' THEN total_amount ELSE 0 END) AS totalCanceledAmount
            ")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("strftime('%Y', created_at), strftime('%m', created_at)")
            ->get();

        // ترتيب النتيجة بصيغة API موحدة
        return ApiResponse::apiResponse([
            'orders' => $orders,
            'dashboard' => $dashboardData,
            'monthly' => $monthlyData,
        ], 'Admin dashboard stats', 200);
    }
}
