<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Table;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.index');
    }

    public function getTables()
    {
        $tables = Table::all();
        $html = '';

        foreach ($tables as $table) {
            $html .= '<div class="col-md-2 mb-4">';
            $html .= 
            '<button class="btn btn-light">
                <img class="img-fluid" src="'.url('/img/table.png').'">
                <br>
                <span class="badge badge-success">'.$table->name.'</span>
            </button>';
            $html .= '</div>';
        }

        return $html;
    }
}
