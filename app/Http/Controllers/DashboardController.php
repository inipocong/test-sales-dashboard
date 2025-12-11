<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start_date');
        $end = $request->get('end_date');

        $query = Sale::query();

        if ($start && $end) {
            $query->whereBetween('sale_date', [$start, $end]);
        }
        
        $sales = $query->orderBy('sale_date')->get();

        $total = $sales->sum(fn($s) => $s->quantity * $s->price);

        $chartData = Sale::select(DB::raw('sale_date, SUM(quantity * price) as total'))
            ->when($start && $end, fn($q) => $q->whereBetween('sale_date', [$start, $end]))
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        $labels = $chartData->pluck('sale_date')->map(fn($d) => $d->format('Y-m-d'))->toArray();
        $totals = $chartData->pluck('total')->toArray();

        return view('dashboard.index', compact('sales','total','labels','totals','start','end'));
    }
}
