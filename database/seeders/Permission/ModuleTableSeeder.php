<?php

namespace Database\Seeders\Permission;

use Module\Permission\Models\Module;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getModules() ?? [] as $module)
        {
            Module::firstOrCreate([
                'id'        => $module['id'],
            ], [
                'name'  => $module['name'],
                'status'    => $module['status'],
            ]);
        }
    }

    private function getModules()
    {
        return [
            ['id' => '1',   'status' => '1', 'name' => 'Global Setting'],
            ['id' => '2',   'status' => '1', 'name' => 'User Access'],
            ['id' => '70001',  'status' => '1', 'name' => 'Production'],

            ['id' => '80001','name' => 'POS','created_at' => '2021-09-13 11:13:05','updated_at' => '2021-09-13 11:13:05','status' => '1']
        ];
    }
}
