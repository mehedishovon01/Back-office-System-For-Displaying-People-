<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Module\Account\Models\Account;

use Module\Account\Models\AccountGroup;
use Module\Account\Models\AccountSubsidiary;
use Module\Account\Models\Transaction;
use Module\Account\Services\AccountLedgerReportService;
use Module\Account\Services\DataService;
use Module\Account\Services\JournalLedgerReportService;
use Module\Account\Services\SubsidiaryWiseLedgerReportService;
use Module\Account\Services\TransactionLedgerReportService;

class AccountReportController extends Controller
{
    use CheckPermission;

    private $dataService;
    private $reportService;
    private $journalLedger;
    private $subsidiaryLedger;
    private $transactionLedger;

    public function __construct()
    {
        $this->dataService = new DataService();
        $this->reportService = new AccountLedgerReportService();
        $this->journalLedger = new JournalLedgerReportService();
        $this->transactionLedger = new TransactionLedgerReportService();
        $this->subsidiaryLedger = new SubsidiaryWiseLedgerReportService();
    }

    public function accountLedgerReport(Request $request)
    {
        $this->hasAccess("account.account.ledger.reports");

        $data1 = $this->dataService->getAccountData(['accounts']);
        $data2 = $this->reportService->getLedger($request);
        $view = 'reports.account-ledger.' . ($request->print ? 'print' : 'index');

        return view($view, $data1, $data2);
    }

    public function transactionLedgerReport(Request $request)
    {
        // DB::enableQueryLog();
        $this->hasAccess("account.transaction.ledger.reports");

        $accountGroups = $this->transactionLedger->getCategoryWiseTransactionLedgerReportData($request);
        $view = 'reports.transaction-ledger.category-' . ($request->print ? 'print' : 'index');
        // dd(DB::getQueryLog());

        return view($view, compact('accountGroups'));
    }

    public function ledgerJournalReport(Request $request)
    {
        $this->hasAccess("account.ledger.journal.reports");

        $data = $this->dataService->getAccountData(['accounts']);
        $data2 = $this->journalLedger->getLedger($request);
        $view = 'reports.ledger-journal.' . ($request->print ? 'print' : 'index');

        return view($view, $data, $data2);
    }

    public function subsidiaryWiseLedgerReport(Request $request)
    {
        $this->hasAccess("account.subsidiary.ledger.reports");

        $data = $this->dataService->getAccountData(['accountSubsidiaries']);
        $data2 = $this->subsidiaryLedger->getLedger($request);
        $view = 'reports.subsidiary-wise-ledger.' . ($request->print ? 'print' : 'index');

        return view($view, $data, $data2);
    }

    public function chartOfAccountReport(Request $request)
    {
        $this->hasAccess("account.chart.of.account.reports");

        $data['accounts'] = Account::query()
            ->companies()
            ->orderBy('name')
            ->withCount(['transactions as balance' => function ($q) {
                return $q->companies()->select(DB::Raw('SUM(amount)'));
            }]);

        if ($request->print) {
            $data['accounts'] = $data['accounts']->get();
        } else {
            $data['accounts'] = $data['accounts']->paginate(30);
        }

        return view('reports.chart-of-account.' . ($request->print ? 'print' : 'index'), $data);
    }

    public function expenseAnalysisReport(Request $request)
    {
        $this->hasAccess("account.expense.analysis.reports");

        $data = $this->dataService->getAccountData(['accountControls', 'accountSubsidiaries']);
        $data['accountSubsidiaries'] = AccountSubsidiary::query()
            ->where('account_control_id', $request->account_control_id)
            ->select('id', 'name')
            ->get();

        $data['accounts'] = Account::query()
            ->when($request->account_subsidiary_id, function ($q) use ($request) {
                $q->where('account_subsidiary_id', $request->account_subsidiary_id);
            })
            ->when($request->account_control_id, function ($q) use ($request) {
                $q->where('account_control_id', $request->account_control_id);
            })
            ->select('id', 'name')
            ->get();

        $data['transactions'] = Transaction::query()
            ->whereHas('account', function ($q) use ($request) {
                $q->where('account_group_id', 5)
                    ->with('accountSubsidiary', 'accountControl')
                    ->where('balance_type', 'Debit')
                    ->when($request->account_subsidiary_id, function ($r) use ($request) {
                        $r->where('account_subsidiary_id', $request->account_subsidiary_id);
                    })
                    ->when($request->account_control_id, function ($r) use ($request) {
                        $r->where('account_control_id', $request->account_control_id);
                    })
                    ->when($request->account_id, function ($r) use ($request) {
                        $r->where('account_id', $request->account_id);
                    });
            })
            ->where('date', '>=' , $request->from ?? date('Y-m-d'))
            ->where('date', '<=' , $request->to ?? date('Y-m-d'))
            ->withCount(['account as account_subsidiary_id' => function ($q) {
                   $q->select(DB::raw('SUM(account_subsidiary_id)'));
            }])
            ->withCount(['account as account_control_id' => function ($q) {
                $q->select(DB::raw('SUM(account_control_id)'));
            }])
            ->orderBy('date');

        if ($request->print) {
            $data['transactions'] = $data['transactions']->get();
        } else {
            $data['transactions'] = $data['transactions']->paginate(30);
        }

        return view('reports.expense-analysis.' . ($request->print ? 'print' : 'index'), $data);
    }

    public function balanceSheetReport (Request $request)
    {
        $this->hasAccess("account.balance.sheet.reports");

        $data['accountGroups'] = AccountGroup::where('id', '<=', 3)
            ->with(['accounts' => function($q) use($request) {
                $q->withCount(['transactions as balance' => function($q) use($request) {
                    return $q
                        ->where('date', '<=', fdate($request->date ?? today()))
                        ->select(DB::Raw('SUM(amount)'));
                }]);
            }])->get();
        $view = 'reports.balance-sheet.' . ($request->print ? 'print' : 'index');

        return view($view, $data);
    }

    public function trialBalanceReport (Request $request)
    {
        $this->hasAccess("account.trial.balance.reports");

        $accountGroups = $this->transactionLedger->getCategoryWiseTransactionLedgerReportData($request);
        $view = 'reports.trial-balance.' . ($request->print ? 'print' : 'index');

        return view($view, compact('accountGroups'));
    }
}
