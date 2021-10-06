<?php


namespace Module\Account\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\AccountGroup;

class TransactionLedgerReportService
{
    public function getCategoryWiseTransactionLedgerReportData(Request $request)
    {
        return AccountGroup::with(['accountControls' => function($q) use($request) {
            $q->with(['accountSubsidiaries' => function($qr) use($request) {
                $qr->with(['accounts' => function($qur) use($request) {
                    $from = $request->routeIs('report.trial-balance') ? '1580-01-01' : fdate($request->from ?? today());
                    $to = fdate($request->to ?? today());

                    $qur->withCount(['transactions as opening_balance' => function($quer) use($request, $from) {
                        $quer->select(DB::Raw('SUM(amount)'))
                            ->where('date', '<',  $from);
                    }])->withCount(['transactions as debit' => function($quer) use($request, $from, $to) {
                        $quer->select(DB::Raw('SUM(amount)'))
                            ->where('amount', '<',  0)
                            ->where('date', '>=',  $from)
                            ->where('date', '<=',  $to);
                    }])->withCount(['transactions as credit' => function($quer) use($request, $from, $to) {
                        $quer->select(DB::Raw('SUM(amount)'))
                            ->where('amount', '>',  0)
                            ->where('date', '>=',  $from)
                            ->where('date', '<=',  $to);
                    }]);
                }]);
            }]);
        }])->get();

    }
}
