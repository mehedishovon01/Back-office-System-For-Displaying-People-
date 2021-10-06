<?php

namespace Module\Production\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Traits\CheckPermission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Module\Production\Models\Factory;

class FactoryController extends Controller
{
    use CheckPermission;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->hasAccess("factories.index");
        if(auth()->user()->id == 1){
            $company = Company::latest()->get();
        }else{
            $company = Company::where('id', auth()->user()->company_id)->latest()->get();
        }
        // return $company;
        
        return view('factory.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Factory::query()->create([
            'company_id' => $request->company_id,
            'name' => $request->name,
        ]);

        return redirect()->route('factories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function show(Factory $factory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->id == 1){
            $company = Company::latest()->get();
        }else{
            $company = Company::where('id', auth()->user()->company_id)->latest()->get();
        }
        $factory = Factory::find($id);
  
        return view('factory.edit', compact('factory', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factory $factory)
    {
        $factory->update([
            'company_id' => $request->company_id,
            'name' => $request->name,
        ]);
        return redirect()->route('factories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factory = Factory::find($id);
        $factory->delete();

        return back()->with('message', 'Factories Successfully Deleted!');
    }

    public function test(){
        // $data = Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign('products_fk_category_id_foreign');
        //     $table->dropColumn('fk_category_id');
        // });
        // $data = Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign('products_fk_brand_id_foreign');
        //     $table->dropColumn('fk_brand_id');
        // });
        $data = Schema::table('products', function (Blueprint $table) {
            $table->string('product_cost')->nullable()->change();
        });

        return "Done";
    }
}
