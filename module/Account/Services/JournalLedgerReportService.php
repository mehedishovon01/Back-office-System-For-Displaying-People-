<?php


namespace Module\Account\Services;


use Illuminate\Http\Request;
use Module\Account\Models\Transaction;

class JournalLedgerReportService
{
    public function getLedger(Request $request)
    {

        $transactions = Transaction::query()
            ->with('transactionable')
            ->when($request->filled('account_id'), function($q) use($request) {
                $q->where('account_id', $request->account_id);
            })
            ->where('date', '>=', $request->from ?? '4520-01-01')
            ->where('date', '<=', fdate($request->to ?? today()))
            ->orderBy('date');

        $debit = clone $transactions;
        $credit = clone $transactions;

        $data['totalDebit'] = $debit->where('amount', '<', 0)->sum('amount');
        $data['totalCredit'] = $credit->where('amount', '>', 0)->sum('amount');

        $data['transactions'] = $request->print
            ? $transactions->get()
            : $transactions->paginate(30);

        return $data;
    }
}
