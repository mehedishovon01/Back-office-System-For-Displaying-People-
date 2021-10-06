<?php

namespace Module\Account\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\AccountControl;

class AccountControlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $control) {
            AccountControl::query()->firstOrCreate($control);
        }
    }

    private function data(): array
    {
        return [
            ['name' => 'Current Asset',             'account_group_id' => 1, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Fixed Asset',               'account_group_id' => 1, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Short Term Liabilities',    'account_group_id' => 2, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Long Term liabilities',     'account_group_id' => 2, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Capital',                   'account_group_id' => 3, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Retained Earning',          'account_group_id' => 3, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Sales',                     'account_group_id' => 4, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Adjustment Revenue',        'account_group_id' => 4, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Other Revenue',             'account_group_id' => 4, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Service Revenue',           'account_group_id' => 4, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Entertainment Expense',     'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Adjustment Expense',        'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Utility Expenses',          'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'House Rent',                'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Conveyance Expenses',       'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Salary Expenses',           'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Remuneration',              'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Miscellaneous Expenses',    'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Interest Expenses',         'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Depreciation Expense',      'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Remuneration Expense',      'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Sales Commission',          'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Sales Adjustment',          'account_group_id' => 5, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Purchase',                  'account_group_id' => 6, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Sales Return',              'account_group_id' => 7, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Purchase Return',           'account_group_id' => 8, 'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
        ];
    }
}
