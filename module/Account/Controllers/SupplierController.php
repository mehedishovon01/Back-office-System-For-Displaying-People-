<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Supplier;

class SupplierController extends Controller
{
    use CheckPermission;


    public function index()
    {
        $this->hasAccess("acc_suppliers.index");

        $suppliers = Supplier::query()->paginate(30);

        return view('purchase.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $this->hasAccess("acc_suppliers.create");

        return view('purchase.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->hasAccess("acc_suppliers.create");

        Supplier::query()->create($request->all());

        return redirect()->route('acc_suppliers.index')->with('message', 'Supplier Create Successful');
    }

    public function edit($id)
    {
        $this->hasAccess("acc_suppliers.edit");

        $supplier = Supplier::query()->find($id);

        return view('purchase.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->hasAccess("acc_suppliers.edit");

        Supplier::query()->where('id', $id)->update($request->except('_token', '_method'));

        return redirect()->route('acc_suppliers.index')->with('message', 'Supplier Update Successful');
    }


    public function destroy($id)
    {
        $this->hasAccess("acc_suppliers.delete");

        try {
            Supplier::destroy($id);

            return redirect()->route('acc_suppliers.index')->with('message', 'Supplier Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }
}
