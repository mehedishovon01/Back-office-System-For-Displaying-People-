<?php


namespace Module\Account\Services;


use Illuminate\Http\Request;
use Module\Account\Models\Transaction;

class AccountLedgerReportService
{
    public function getLedger(Request $request): array
    {
        $data['balance'] = Transaction::query()
            ->where('account_id', $request->account_id)
            ->where('date', '<',  fdate($request->from ?? today()))
            ->sum('amount');


        $data['transactions'] = Transaction::query()
            ->with('transactionable')
            ->where('account_id', $request->account_id)
            ->when($request->from, function ($q) use ($request) {
                $q->where('date', '>=', $request->from);
            })
            ->when($request->to, function ($q) use ($request) {
                $q->where('date', '<=', $request->to);
            })
            ->orderBy('date');

        $data['transactions'] = $request->print
            ? $data['transactions']->get()
            : $data['transactions']->paginate(30);

        return $data;
    }
}
