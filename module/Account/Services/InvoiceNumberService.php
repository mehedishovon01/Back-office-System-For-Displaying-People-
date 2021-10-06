<?php


namespace Module\Account\Services;


use App\Models\Company;
use Module\Account\Models\InvoiceNo;
use Illuminate\Http\Request;

class InvoiceNumberService
{
    public function getVoucherInvoiceNo($company_id, $voucher_type): string
    {
        $nextId = optional(InvoiceNo::query()
            ->where('type', 'Voucher')
            ->where('year', date('Y'))
            ->where('company_id', $company_id)
            ->first())->next_id;

        if ($nextId == null)
            $nextId = InvoiceNo::query()
                ->Create([
                    'type' => 'Voucher',
                    'year' => date('Y'),
                    'company_id' => $company_id,
                    'next_id' => 1
                ])->next_id;

        if ($voucher_type == "Payment") {
            return 'P-'
                . date('Y')
                . '-'
                . date('m')
                . '-'
                . str_pad($nextId, 6, "0", STR_PAD_LEFT);
        } elseif ($voucher_type == "Receive") {
            return 'R-'
                . date('Y')
                . '-'
                . date('m')
                . '-'
                . str_pad($nextId, 6, "0", STR_PAD_LEFT);
        } elseif ($voucher_type == "Journal") {
            return 'J-'
                . date('Y')
                . '-'
                . date('m')
                . '-'
                . str_pad($nextId, 6, "0", STR_PAD_LEFT);
        } else {
            // Contra
            return 'C-'
                . date('Y')
                . '-'
                . date('m')
                . '-'
                . str_pad($nextId, 6, "0", STR_PAD_LEFT);
        }
    }

    public function setNextInvoiceNo($company_id, $type, $year)
    {
        $invoice_no = InvoiceNo::query()
            ->firstOrCreate([
                'type' => $type,
                'year' => $year,
                'company_id' => $company_id
            ]);

        $invoice_no->increment('next_id');
        $invoice_no->save();
    }

    public function getFundTransferInvoiceNo($company_id): string
    {
        $nextId = optional(InvoiceNo::query()
            ->where('type', 'Fund Transfer')
            ->where('year', date('Y'))
            ->where('company_id', $company_id)
            ->first())->next_id;

        if ($nextId == null)
            $nextId = InvoiceNo::query()
                ->Create([
                    'type' => 'Voucher',
                    'year' => date('Y'),
                    'company_id' => $company_id,
                    'next_id' => 1
                ])->next_id;

        return 'INV-FT-'
            . date('Y')
            . '-'
            . $this->getCompanyCode($company_id)
            . '-'
            . str_pad($nextId, 6, "0", STR_PAD_LEFT);
    }

    public function getVoucherDetailTransactionNo($key, $invoice_no)
    {
        $substr = substr($invoice_no, -6);

        return str_replace($substr, str_pad($key + 1, 2, '0', STR_PAD_LEFT) . '-' . $substr, $invoice_no);
    }

    // Get Purchase Details Transection
    public function getPurchaseDetailTransactionNo($key, $invoice_no)
    {
        $substr = substr($invoice_no, -6);

        return str_replace($substr, str_pad($key + 1, 2, '0', STR_PAD_LEFT) . '-' . $substr, $invoice_no);
    }

    private function getCompanyCode($company_id)
    {
        $company = Company::query()->find($company_id);

        return $company->code ?? ($company_id * 10);
    }





    public function getGFabricIssueRef(Request $request)
    {
        $year = fdate($request->date ?? now(), 'Y');


        $invoice_number = InvoiceNo::where('year', $year)->where('type', 'GFabric Issue Reference')->first();

        if (!$invoice_number) {

            $invoice_number = InvoiceNo::create([
                'year'          => $year,
                'type'          => 'GFabric Issue Reference',
                'next_id'       => 500000,
                'company_id'    => 1,  // fixed 1 for company not specific
            ]);
        }

        return  'Issue-' . date('y') . $invoice_number->next_id;
    }


    public function getGFabricReceiveRef(Request $request)
    {
        $year = fdate($request->grn_date ?? now(), 'Y');


        $invoice_number = InvoiceNo::where('year', $year)->where('type', 'Gray Fabric Receive Reference')->first();

        if (!$invoice_number) {

            $invoice_number = InvoiceNo::create([
                'year'          => $year,
                'type'          => 'Gray Fabric Receive Reference',
                'next_id'       => 500000,
                'company_id'    => 1,  // fixed 1 for company not specific
            ]);
        }

        return  'RCV-' . date('y') . $invoice_number->next_id;
    }


    public function getDyedFabricReceiveRef(Request $request)
    {
        $year = fdate($request->grn_date ?? now(), 'Y');


        $invoice_number = InvoiceNo::where('year', $year)->where('type', 'Dyed Fabric Receive Reference')->first();

        if (!$invoice_number) {

            $invoice_number = InvoiceNo::create([
                'year'          => $year,
                'type'          => 'Dyed Fabric Receive Reference',
                'next_id'       => 600000,
                'company_id'    => 1,  // fixed 1 for company not specific
            ]);
        }

        return  'RCV-' . date('y') . $invoice_number->next_id;
    }



    public function getCuttingFabricIssueRef($request)
    {
        $year = fdate($request->date ?? now(), 'Y');


        $invoice_number = InvoiceNo::where('year', $year)->where('type', 'Cutting Fabric Issue Reference')->first();

        if (!$invoice_number) {

            $invoice_number = InvoiceNo::create([
                'year'          => $year,
                'type'          => 'Cutting Fabric Issue Reference',
                'next_id'       => 700000,
                'company_id'    => 1
            ]);
        }

        return  'CTF-Issue-' . date('y') . $invoice_number->next_id;
    }



    public function getLooseFabricIssueRef($request)
    {
        $year = fdate($request->date ?? now(), 'Y');


        $invoice_number = InvoiceNo::where('year', $year)->where('type', 'Loose Fabric Issue Reference')->first();

        if (!$invoice_number) {
            $invoice_number = InvoiceNo::create([
                'year'          => $year,
                'type'          => 'Loose Fabric Issue Reference',
                'next_id'       => 700000,
                'company_id'    => 1
            ]);
        }

        return  'Issue-' . date('y') . $invoice_number->next_id;
    }

    public function getPurchaseInvoiceNo($company_id): string
    {
        $nextId = optional(InvoiceNo::query()
            ->where('type', 'Voucher')
            ->where('year', date('Y'))
            ->where('company_id', $company_id)
            ->first())->next_id;

        if ($nextId == null)
            $nextId = InvoiceNo::query()
                ->Create([
                    'type' => 'Voucher',
                    'year' => date('Y'),
                    'company_id' => $company_id,
                    'next_id' => 1
                ])->next_id;

        return 'INV-'
            . date('Y')
            . '-'
            . date('m')
            . '-'
            . str_pad($nextId, 6, "0", STR_PAD_LEFT);
    }
}
