<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Menu;

class CashierController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('cashier.index')->with([
            'categories' => $categories
        ]);
    }

    public function getTables()
    {
        $tables = Table::all();
        $html = '';

        foreach ($tables as $table) {
            $html .= '<div class="col-md-2 mb-4">';
            $html .= 
            '<button class="btn btn-light btn-table" data-id="'.$table->id.'" data-name="'.$table->name.'">
                <img class="img-fluid" src="'.url('/img/table.png').'">
                <br>
                <span class="badge badge-success">'.$table->name.'</span>
            </button>';
            $html .= '</div>';
        }

        return $html;
    }

    public function getMenuByCategory($category_id)
    {
        $menus = Menu::where('category_id', $category_id)->get();
        $html = '';

        foreach ($menus as $menu) {
            $html .= 
            '<div class="col-md-3 text-center">
                <a class="btn btn-outline-secondary btn-menu" data-id="'.$menu->id.'">
                    <img class="img-fluid" src="'.url('/menu_images/'.$menu->image).'">
                    <br>
                    '.$menu->name.'
                    <br>
                    $'.number_format($menu->price).'
                </a>
            </div>';
        }
        
        return $html;
    }

    public function orderFood(Request $request)
    {
        return $request->menu_id;
    }
}
