<?php

namespace Module\Account\Controllers;

use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Module\Account\Models\Account;
use Module\Account\Models\Transaction;
use Module\Account\Services\DataService;
use Module\Account\Services\IndexDataService;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use CheckPermission;

    private $dataService;
    private $indexService;

    public function __construct()
    {
        $this->dataService = new DataService();
        $this->indexService = new IndexDataService();
    }

    public function index()
    {
        $this->hasAccess("accounts.index");

        $data['accounts'] = $this->indexService->getAccountData();

        return view('setup.accounts.index', $data);
    }

    public function create()
    {
        $this->hasAccess("accounts.create");

        $data = $this->dataService->getAccountData(['accountGroups']);

        $data['accountControls'] = [];
        $data['accountSubsidiaries'] = [];

        return view('setup.accounts.create', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->hasAccess("accounts.create");

        $account = Account::query()->create($request->all());

        $account = $this->updateBalanceType($account);

        $this->updateOrCreateAccountTransaction($request, $account);

        return redirect()->route('accounts.index')->with('message', 'Account Create Successful');
    }

    public function edit(Account $account)
    {
        $this->hasAccess("accounts.edit");

        $data = $this->dataService->getAccountData(['accountGroups']);

        $data['accountControls'] = $this->dataService->accountControls($account->account_group_id);

        $data['accountSubsidiaries'] = $this->dataService->accountSubsidiaries($account->account_control_id);

        return view('setup.accounts.edit', compact('account'), $data);
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        $this->hasAccess("accounts.edit");

        $account->update($request->all());

        $account = $this->updateBalanceType($account);

        $this->updateOrCreateAccountTransaction($request, $account);

        return redirect()->route('accounts.index')->with('message', 'Account Update Successful');
    }

    private function updateOrCreateAccountTransaction($request, $account)
    {
        Transaction::updateOrCreate([
            'account_id'            => $account->id,
            'transactionable_type'  => 'Account Opening',
            'transactionable_id'    => $account->id,
            'description'           => 'Opening Balance',
        ], [
            'date'                  => fdate($account->created_at),
            'amount'                => $account->opening_balance,
            'balance_type'          => $account->balance_type,
            'invoice_no'            => '---',
        ]);
    }

    public function destroy($id)
    {
        $this->hasAccess("accounts.delete");

        try {
            Account::destroy($id);

            return redirect()->route('accounts.index')->with('message', 'Account Successfully Deleted!');
        } catch (\Exception $ex) {
            return redirect()->back()->withMessage($ex->getMessage());
        }
    }

    private function updateBalanceType($account)
    {
        $account->balance_type = $account->accountGroup->balance_type;
        $account->save();
        return $account;
    }
}
