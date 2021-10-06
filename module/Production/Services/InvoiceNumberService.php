<?php


namespace Module\Production\Services;

use Module\Account\Models\InvoiceNo;

class InvoiceNumberService
{
    public function getMaterilasInvoiceNo($company_id): string
    {
        $nextId = optional(InvoiceNo::query()
            ->where('type', 'Raw-Materials')
            ->where('year', date('Y'))
            ->where('company_id', $company_id)
            ->first())->next_id;

        if ($nextId == null)
            $nextId = InvoiceNo::query()
                ->Create([
                    'type' => 'Raw-Materials',
                    'year' => date('Y'),
                    'company_id' => $company_id,
                    'next_id' => 1
                ])->next_id;

        return 'RM-'
            . date('Y')
            . '-'
            . $company_id
            . '-'
            . str_pad($nextId, 6, "0", STR_PAD_LEFT);
    }

    public function getSaleProductionInvoiceNo($company_id): string
    {
        $nextId = optional(InvoiceNo::query()
            ->where('type', 'Production-Sale')
            ->where('year', date('Y'))
            ->where('company_id', $company_id)
            ->first())->next_id;

        if ($nextId == null)
            $nextId = InvoiceNo::query()
                ->Create([
                    'type' => 'Production-Sale',
                    'year' => date('Y'),
                    'company_id' => $company_id,
                    'next_id' => 1
                ])->next_id;

        return 'PS-'
            . date('Y')
            . '-'
            . $company_id
            . '-'
            . str_pad($nextId, 6, "0", STR_PAD_LEFT);
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
}
