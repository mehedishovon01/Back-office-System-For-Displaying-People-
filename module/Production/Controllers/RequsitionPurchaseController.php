<?php

namespace Module\Production\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
use Google\Service\FirebaseRules\FunctionCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Product;
use Module\Production\Models\RequsitionPurchase;
use Module\Production\Models\RequsitionPurchaseDetails;
use Module\Production\Services\IndexDataServices;
use Module\Production\Services\RequisitionService;

class RequsitionPurchaseController extends Controller
{
    private $indexService;
    private $requisitionService;

    public function __construct()
    {
        $this->indexService = new IndexDataServices();
        $this->requisitionService = new RequisitionService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['companies']    = Company::userCompanies();
        $data['purchases']    = RequsitionPurchase::latest()->paginate(20);

        return view('requsition.purchase.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::userCompanies();
        // $factory = Factory::get();
        $data['products'] = $this->indexService->getProdforMaterials();

        return view('requsition.purchase.create', compact('companies'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_id'    => 'required',
            'item_id.*'     => 'required',
            'quantity.*'    => 'required'
        ]);

        // use transaction to safely store data
        DB::transaction(function () use ($request) {
            $purchases = RequsitionPurchase::create([
                'company_id'         => $request->company_id,
                'purchase_reference' => $request->reference,
                'is_approved'        => 0,
                'purchase_date'      => Carbon::parse($request->purchase_date)->format('Y-m-d'),
                'total'              => collect($request->required_qty)->sum(),
            ]);

            $this->requisitionService->saveRequisitionPurchseDetails($request, $purchases);
        });

        return redirect()->route('purchase.index')->with('message', 'Requisition Purchases Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequsitionPurchase  $requsitionPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(RequsitionPurchase $requsitionPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequsitionPurchase  $requsitionPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(RequsitionPurchase $requsitionPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequsitionPurchase  $requsitionPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequsitionPurchase $requsitionPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequsitionPurchase  $requsitionPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequsitionPurchase $requsitionPurchase)
    {
        //
    }

    public function purchaseApproveShow($id)
    {
        $data['products']  = Product::select('name', 'id', 'company_id')->get();
        $data['companies'] = Company::userCompanies();
        $data['purchase']  = RequsitionPurchase::where('id', $id)->with('purchase_details')->first();

        foreach ($data['purchase']->purchase_details as $key => $detail) {
            $product_id = $detail->product_id;
            $last_purchase = RequsitionPurchase::whereIsApproved(1)->orderByDesc('purchase_date')->whereHas('purchase_details', function($q) use ($product_id) {
                $q->where('product_id', $product_id);
            })->first();

            if ($last_purchase) {
                $data['last_purchases'][] = $last_purchase;
            } else {
                $data['last_purchases'][] = '';
            }
        }
        // return $data;

        return view('requsition.purchase.approve', $data);
    }

    public function purchaseApprove(Request $request, $id)
    {
        // return $request;
        // check validation
        $this->validate($request, [
            'company_id'    => 'required',
            'item_id.*'     => 'required',
            'quantity.*'    => 'required'
        ]);

        $purchase = RequsitionPurchase::find($id);
        DB::transaction(function () use ($request, $purchase) {
            $purchase->update([
                'form_number'          => $purchase->form_number ?? $this->requisitionService->purchase_number($purchase->company_id),
                'is_approved'          => 1,
                'company_id'          =>  $request->company_id,
                'purchase_date'        =>  Carbon::parse($request->purchase_date)->format('Y-m-d'),
                'purchase_reference'   =>  $request->reference,
                'total'                =>  collect($request->quantity)->sum()
            ]);
            $this->requisitionService->updatePurchaseDetails($purchase, $request);

            // delete purchase item from notification table
            // $purchase->task_notifications()->delete();
        });
        return redirect()->route('purchase.index')->with('message', 'Purchse Approved Successfully!');
    }

    public function purchaseApproveReceive($id){
        $purchase = RequsitionPurchase::find($id);
        $data = [];

        $data['receive_items'][] = [];
        $data['requisition_from_item'][] = [];
        $data['requisition_number'][] = [];

        $data['purchase'] = RequsitionPurchase::with('purchase_details')->find($purchase->id);
        return view('requsition.purchase.receive.create', $data);
    }


    public function grnIndex()
    {
        return view('requsition.purchase.grn');
    }
}
