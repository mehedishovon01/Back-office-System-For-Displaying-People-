<?php

namespace Module\Account\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\AccountGroup;

class AccountGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $control) {
            AccountGroup::query()->firstOrCreate($control);
        }
    }

    private function data(): array
    {
        return [
            ['name' => 'Asset', 'balance_type' => 'Debit', 'is_deletable' => 0],
            ['name' => 'Liabilities', 'balance_type' => 'Credit', 'is_deletable' => 0],
            ['name' => 'Owners Equity', 'balance_type' => 'Credit', 'is_deletable' => 0],
            ['name' => 'Revenue', 'balance_type' => 'Credit', 'is_deletable' => 0],
            ['name' => 'Expenses', 'balance_type' => 'Debit', 'is_deletable' => 0],
            ['name' => 'Purchase', 'balance_type' => 'Debit', 'is_deletable' => 0],
            ['name' => 'Sales Return', 'balance_type' => 'Debit', 'is_deletable' => 0],
            ['name' => 'Purchase Return', 'balance_type' => 'Credit', 'is_deletable' => 0],
        ];
    }
}
