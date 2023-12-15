<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardComponent extends Component
{
    public $rankingPays;
    public $movementCash;

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
            ->select('type_pays.name','payments.amount', 'payments.created_at','payments.type')
            ->orderBy('payments.created_at', 'desc')
            ->limit(10)
            ->get();
    }
    public function render()
    {
        return view('livewire.admin.dashboard-component');
    }
}
