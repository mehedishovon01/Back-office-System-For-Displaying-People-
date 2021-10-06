<?php

namespace Module\Account\Controllers;

use App\Models\Company;
use App\Traits\CheckPermission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Customer;
use Module\Account\Models\Product;
use Module\Account\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Module\Account\Models\PurchaseDetail;
use Module\Account\Services\AccountTransactionService;
use Module\Account\Services\InvoiceNumberService;

class PurchaseController extends Controller
{
    use CheckPermission;

    private $invoiceNumberService;
    private $transactionService;

    public function __construct()
    {
        $this->invoiceNumberService = new InvoiceNumberService();
        $this->transactionService = new AccountTransactionService();
    }

    public function index()
    {
        $this->hasAccess("acc_purchases.index");
        $purchase = Purchase::latest()->get();

        return view('purchase.purchases.index', compact('purchase'));
    }

    public function create()
    {
        $this->hasAccess("acc_purchases.create");
        $products = Product::select('id','name', 'purchase_price')->get();
        $customer = Customer::select('id','name')->get();
        $company = Company::select('id','name')->get();
        // return $company;
        return view('purchase.purchases.create', compact('products', 'customer', 'company'));
    }

    public function store(Request $request)
    {
        // DB::enableQueryLog();
        $this->hasAccess("acc_purchases.create");
        try{
            DB::beginTransaction();

            $purchase = Purchase::query()->create([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'company_id' => $request->company_id,
                'discount_amount' => $request->discount_amount,
                'previous_due' => $request->previous_due,
                'payable_amount' => $request->payable_amount
            ]);

            $purchase->update([
                'invoice_no' => $this->invoiceNumberService->getPurchaseInvoiceNo($purchase->company_id),
            ]);
            $this->invoiceNumberService->setNextInvoiceNo($purchase->company_id, 'Voucher', date('Y'));

            foreach ($request->product_id as $key => $product_id) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->purchase_price[$key]
                ]);
            }
            $this->hitTransection($purchase);
            DB::commit();
            // dd(DB::getQueryLog());
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
        return redirect()->route('acc_purchases.index')->with('message', 'Purchase Create Successful');
    }

    private function hitTransection($purchase)
    {
        foreach ($purchase->details as $key => $detail) {
            $detail->update([
                'transaction_no' => $this->invoiceNumberService->getPurchaseDetailTransactionNo($key, $purchase->invoice_no)
            ]);
            // dd($detail);
            $this->transactionService->storePurchaseTransaction($detail, $detail->amount, $detail->transaction_no, $purchase->date);
        }
    }

    public function show($purchase)
    {
        $purchase = Purchase::find($purchase);
        
        $this->hasAccess("acc_purchases.show");

        return view('purchase.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $this->hasAccess("acc_purchases.edit");


        return view('purchase.purchases.edit');
    }

    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        $this->hasAccess("acc_purchases.edit");


        return redirect()->route('acc_purchases.index')->with('message', 'Purchase Update Successful');
    }


    public function destroy($id)
    {
        $this->hasAccess("acc_purchases.delete");

        try {
            Purchase ::destroy($id);

            return redirect()->route('acc_purchases.index')->with('message', 'Purchase Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }
}
