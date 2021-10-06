<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Category;
use Module\Account\Models\Product;
use Module\Account\Models\Unit;

class ProductController extends Controller
{
    use CheckPermission;


    public function index()
    {
        $this->hasAccess("products.index");

        $products   = Product::where('name', '!=', null)->with('category', 'unit')->userLog()->latest()->get();

        return view('product.products.index', compact('products'));
    }

    public function create()
    {
        $this->hasAccess("products.create");

        $categories = Category::orderBy('name')->pluck('name', 'id');
        $units      = Unit::orderBy('name')->pluck('name', 'id');

        return view('product.products.create', compact('categories', 'units'));
    }
// : RedirectResponse
    public function store(Request $request)
    {
        // return $request;
        $this->hasAccess("products.create");

        $request->validate([
            'name'          => 'required',
            'category_id'   => 'required',
            'unit_id'       => 'required'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('message', 'Product Create Successful');
    }

    public function edit(Product $product)
    {
        $this->hasAccess("products.edit");

        $categories = Category::orderBy('name')->pluck('name', 'id');
        $units      = Unit::orderBy('name')->pluck('name', 'id');

        return view('product.products.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->hasAccess("products.edit");

        $request->validate([
            'name'          => 'required',
            'category_id'   => 'required',
            'unit_id'       => 'required'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('message', 'Product Update Successful');
    }


    public function destroy($id)
    {
        $this->hasAccess("products.delete");

        try {
            Product::destroy($id);

            return redirect()->route('products.index')->with('message', 'Product Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }
}
