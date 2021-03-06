<?php

namespace Module\Account\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(Schema::hasTable('account_setups')) {
            $this->call([
                AccountSetupTableSeeder::class,
                AccountGroupTableSeeder::class,
                AccountSubsidiaryTableSeeder::class,
                AccountTableSeeder::class,
            ]);
        }

    }
}
