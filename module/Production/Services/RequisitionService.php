<?php

namespace Module\Production\Services;

use App\Models\Company;
use Module\Production\Models\RequsitionPurchase;
use Module\Production\Models\RequsitionPurchaseDetails;

class RequisitionService
{
    public function saveRequisitionPurchseDetails($request, $purchase)
    {
        foreach ($request->product_id as $key => $item_id) {
            RequsitionPurchaseDetails::create([
                'requsition_purchases_id' => $purchase->id,
                'company_id'  => $request->company_id,
                'product_id'     => $request->product_id[$key],
                'quantity'    => $request->required_qty[$key],
            ]);
        }
    }

    public function updatePurchaseDetails($purchase, $request)
    {
        // dd($request);
        //  if old and new is equal
        if (count($purchase->purchase_details) == count($request->product_id)) {
            foreach ($purchase->purchase_details as $key => $detail) {
                $detail->update([
                    'company_id' => $request->company_id,
                    'product_id'    => $request->product_id[$key],
                    'quantity'   => $request->quantity[$key]    
                ]);
            }
        } elseif (count($request->product_id) > count($purchase->purchase_details)) {
            //  if new is greater than old
            foreach ($purchase->purchase_details as $key => $detail) {
                $detail->update([
                    'company_id' => $request->company_id,
                    'product_id'    => $request->product_id[$key],
                    'quantity'   => $request->quantity[$key]
                ]);
            }

            // create new added
            for ($i = count($purchase->purchase_details); $i < count($request->product_id); $i++) {
                RequsitionPurchaseDetails::create([
                    'purchase_id' => $purchase->id,
                    'company_id'  => $request->company_id,
                    'product_id'  => $request->product_id[$i],
                    'quantity'    => $request->quantity[$i]
                ]);
            }
        } else {
            foreach ($request->product_id as $key => $item) {
                $purchase->purchase_details[$key]->update([
                    'company_id' => $request->company_id,
                    'product_id' => $item,
                    'quantity'   => $request->quantity[$key],
                ]);
            }
            // delete old extra
            for ($i = count($request->product_id); $i < count($purchase->purchase_details); $i++) {
                $purchase->purchase_details[$i]->delete();
            }
        }
    }

    public function purchase_number($company_id)
    {
        $count_purchase_number = RequsitionPurchase::where('company_id', $company_id)->where('form_number', '>', 0)->count();
        $company_code          = Company::where('id', $company_id)->pluck('code')->first();
        return '2' . $company_code .  date('y') . (10001 + $count_purchase_number);
    }
}
