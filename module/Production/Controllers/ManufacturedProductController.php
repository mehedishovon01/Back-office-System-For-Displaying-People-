<?php

namespace Module\Production\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Module\Account\Models\Category;
use Module\Account\Models\Product;
use Module\Account\Models\Unit;
use Module\Production\Models\ManufacturedProduct;

class ManufacturedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['manufactured_prod'] = Product::where('type', 'manufactured')->get();
        // return $data;

        return view('manufactured.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $units      = Unit::orderBy('name')->pluck('name', 'id');

        return view('manufactured.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'selling_price' => $request->selling_price,
            'opening_quantity' => $request->opening_quantity,
            'type' => 'manufactured'
        ]);
        return redirect()->route('manufactured.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManufacturedProduct  $manufacturedProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ManufacturedProduct $manufacturedProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManufacturedProduct  $manufacturedProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($manufacturedProduct)
    {
        $data['categories'] = Category::pluck('name', 'id');
        $data['units']      = Unit::pluck('name', 'id');
        $data['manufacture_edit'] = ManufacturedProduct::find($manufacturedProduct);

        return view('manufactured.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManufacturedProduct  $manufacturedProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $manufacturedProduct)
    {
        $data = ManufacturedProduct::find($manufacturedProduct);
        $data->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'selling_price' => $request->selling_price,
            'opening_quantity' => $request->opening_quantity,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManufacturedProduct  $manufacturedProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($manufacturedProduct)
    {
        ManufacturedProduct::destroy($manufacturedProduct);
        
        return redirect()->back();
    }
}
