<?php

namespace Module\Account\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\AccountSetup;

class AccountSetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $setup) {
            AccountSetup::query()->firstOrCreate($setup);
        }
    }

    private function data()
    {
        return [
            ['name' => 'Accounts Payable Suppliers', 'is_deletable' => 0],
            ['name' => 'Adjustment Expense', 'is_deletable' => 0],
            ['name' => 'Adjustment Revenue', 'is_deletable' => 0],
            ['name' => 'Bad Stock', 'is_deletable' => 0],
            ['name' => 'Capital', 'is_deletable' => 0],
            ['name' => 'Accounts Receivables Customers', 'is_deletable' => 0],
            ['name' => 'Cash In Bank', 'is_deletable' => 0],
            ['name' => 'Cash In Hand', 'is_deletable' => 0],
            ['name' => 'Current Income', 'is_deletable' => 0],
            ['name' => 'Current Stock', 'is_deletable' => 0],
            ['name' => 'Purchase', 'is_deletable' => 0],
            ['name' => 'Purchase Return', 'is_deletable' => 0],
            ['name' => 'Retained Earning', 'is_deletable' => 0],
            ['name' => 'RMA Stock', 'is_deletable' => 0],
            ['name' => 'Sales', 'is_deletable' => 0],
            ['name' => 'Sales Return', 'is_deletable' => 0],
            ['name' => 'Unadjusted Amount', 'is_deletable' => 0],
            ['name' => 'Cheque In Hand', 'is_deletable' => 0],
            ['name' => 'Accounts Receivables-RMA', 'is_deletable' => 0],
            ['name' => 'Accounts Payable-RMA', 'is_deletable' => 0],
            ['name' => 'Advance Cheque Issue', 'is_deletable' => 0],
            ['name' => 'Carrying Charge', 'is_deletable' => 0],
            ['name' => 'Godown Rent', 'is_deletable' => 0],
            ['name' => 'Unsettle Credit Card Balance', 'is_deletable' => 0],
            ['name' => 'Bank Interest', 'is_deletable' => 0],
            ['name' => 'Sales Commission', 'is_deletable' => 0],
            ['name' => 'Sales Adjustment', 'is_deletable' => 0],
        ];
    }
}
