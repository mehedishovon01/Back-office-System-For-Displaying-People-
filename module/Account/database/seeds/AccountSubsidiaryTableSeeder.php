<?php

namespace Module\Account\database\seeds;

use Illuminate\Database\Seeder;
use Module\Account\Models\AccountSubsidiary;

class AccountSubsidiaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $control) {
            AccountSubsidiary::query()->firstOrCreate($control);
        }
    }

    private function data(): array
    {
        return [
            ['name' => 'Electricity Bill',          'account_group_id' => 5, 'account_control_id' => 13,    'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Telephone Bill',            'account_group_id' => 5, 'account_control_id' => 13,    'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Other Loans',               'account_group_id' => 1, 'account_control_id' => 3,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Trading Acc Payable',       'account_group_id' => 1, 'account_control_id' => 3,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Computer',                  'account_group_id' => 1, 'account_control_id' => 2,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Decoration',                'account_group_id' => 1, 'account_control_id' => 2,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Furniture and Fixture',     'account_group_id' => 1, 'account_control_id' => 2,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Trading Acc Receivables',   'account_group_id' => 1, 'account_control_id' => 1,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Stock',                     'account_group_id' => 1, 'account_control_id' => 1,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Cash in Bank',              'account_group_id' => 1, 'account_control_id' => 1,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Cash In Hand',              'account_group_id' => 1, 'account_control_id' => 1,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'SOFTWARE',                  'account_group_id' => 1, 'account_control_id' => 2,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],

            ['name' => 'None',                      'account_group_id' => 1, 'account_control_id' => 1,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 1, 'account_control_id' => 2,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 2, 'account_control_id' => 4,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 2, 'account_control_id' => 3,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],

            ['name' => 'None',                      'account_group_id' => 3, 'account_control_id' => 5,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 3, 'account_control_id' => 6,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],

            ['name' => 'None',                      'account_group_id' => 4, 'account_control_id' => 7,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 4, 'account_control_id' => 8,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 4, 'account_control_id' => 9,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 4, 'account_control_id' => 10,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],

            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 11,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 12,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 13,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 14,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 15,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 16,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 17,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 18,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 19,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 20,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 5, 'account_control_id' => 25,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],

            ['name' => 'None',                      'account_group_id' => 6, 'account_control_id' => 22,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 7, 'account_control_id' => 23,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'None',                      'account_group_id' => 8, 'account_control_id' => 24,     'is_deletable' => 0, 'created_by' => 1, 'updated_by' => 1],
        ];
    }
}
