<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->user()->user_type === 'C') {
            return redirect()->route('customer.orders.index');
        }

        $hoje = \Carbon\Carbon::now();


        $kpis = [
            'total_revenue' => Order::where('status', 'closed')->sum('total_price'),
            'monthly_revenue' => Order::where('status', 'closed')
                ->whereMonth('date', $hoje->month)
                ->whereYear('date', $hoje->year)
                ->sum('total_price'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];


        $chartMonths = [];
        $chartRevenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $mes = \Carbon\Carbon::now()->subMonths($i);
            $chartMonths[] = $mes->translatedFormat('M Y');

            $receitaMes = Order::where('status', 'closed')
                ->whereMonth('date', $mes->month)
                ->whereYear('date', $mes->year)
                ->sum('total_price');

            $chartRevenue[] = round($receitaMes, 2);
        }


        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'closed' => Order::where('status', 'closed')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];


        $recentPendingOrders = Order::with('customer.user')
            ->whereIn('status', ['pending', 'paid'])
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();


        $topCustomers = Order::whereIn('orders.status', ['closed', 'paid'])
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('users', 'customers.id', '=', 'users.id')
            ->select('users.name', 'users.email', \Illuminate\Support\Facades\DB::raw('SUM(orders.total_price) as total_spent'))
            ->groupBy('customers.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact('kpis', 'chartMonths', 'chartRevenue', 'orderStats', 'recentPendingOrders', 'topCustomers'));
    }
}