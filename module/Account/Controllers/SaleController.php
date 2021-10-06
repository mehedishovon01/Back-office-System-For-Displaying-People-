<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Sale ;

class SaleController extends Controller
{
    use CheckPermission;


    public function index()
    {
        $this->hasAccess("acc_sales.index");

        return view('sale.sales.index');
    }

    public function create()
    {
        $this->hasAccess("acc_sales.create");

        return view('sale.sales.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->hasAccess("acc_sales.create");

        return redirect()->route('acc_sales.index')->with('message', 'Sale Create Successful');
    }

    public function edit(Sale $sale)
    {
        $this->hasAccess("acc_sales.edit");


        return view('sale.sales.edit');
    }

    public function update(Request $request, Sale $sale): RedirectResponse
    {
        $this->hasAccess("acc_sales.edit");


        return redirect()->route('acc_sales.index')->with('message', 'Sale Update Successful');
    }


    public function destroy($id)
    {
        $this->hasAccess("acc_sales.delete");

        try {
            Sale ::destroy($id);

            return redirect()->route('acc_sales.index')->with('message', 'Sale Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }
}
