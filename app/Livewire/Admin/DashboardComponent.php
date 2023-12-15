<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardComponent extends Component
{
    public $rankingPays;
    public $movementCash;
    public $salesWeek;

    public function mount()
    {   //obtener los tipos de pagos el conteo de estos y el porcentaje
        $this->rankingPays = DB::table('payments')
            ->join('type_pays', 'payments.type_pay_id', '=', 'type_pays.id')
            ->select('type_pays.name', DB::raw('sum(amount) as total'), DB::raw('count(*) * 100 / (select count(*) from payments) as porcentaje'))
            ->groupBy('type_pays.id')
            ->get();

        //obtener los movimientos de caja
        $this->movementCash = DB::table('payments')
            ->join('type_pays', 'payments.type_pay_id', '=', 'type_pays.id')
            ->select('payments.id','type_pays.name', 'payments.amount', 'payments.created_at', 'payments.type')
            ->orderBy('payments.created_at', 'desc')
            ->limit(5)
            ->get();

        //obtener las ventas de la semana
        $this->salesWeek = DB::table('sales')
            ->select(DB::raw('sum(total) as total'))
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();
    }

    public function render()
    {
        $chart_options = [
            'chart_title' => 'Ventas por día',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sale',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
        ];
        $chartRevenue = new LaravelChart($chart_options);
        return view('livewire.admin.dashboard-component', compact('chartRevenue'));
    }
}
