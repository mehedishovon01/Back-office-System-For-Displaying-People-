<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Customer;

class CustomerController extends Controller
{
    use CheckPermission;


    public function index()
    {
        $this->hasAccess("acc_customers.index");

        $customers = Customer::query()->paginate(30);

        return view('sale.customers.index', compact('customers'));
    }

    public function create()
    {
        $this->hasAccess("acc_customers.create");

        return view('sale.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->hasAccess("acc_customers.create");

        Customer::query()->create($request->all());

        return redirect()->route('acc_customers.index')->with('message', 'Customer Create Successful');
    }

    public function edit($id)
    {
        $this->hasAccess("acc_customers.edit");

        $customer = Customer::query()->find($id);

        return view('sale.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->hasAccess("acc_customers.edit");

        Customer::query()->where('id', $id)->update($request->except('_token', '_method'));

        return redirect()->route('acc_customers.index')->with('message', 'Customer Update Successful');
    }


    public function destroy($id)
    {
        $this->hasAccess("acc_customers.delete");

        try {
            Customer::destroy($id);

            return redirect()->route('acc_customers.index')->with('message', 'Customer Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }
}
