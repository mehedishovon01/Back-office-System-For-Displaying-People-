<?php

namespace Database\Seeders\Permission;

use Illuminate\Database\Seeder;
use Module\Permission\Models\Submodule;

class SubmoduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getSubmodules() ?? [] as $submodule)
        {
            Submodule::firstOrCreate([
                'name'      => $submodule['name']
            ], [
                'id'        => $submodule['id'],
                'module_id' => $submodule['module_id'],
            ]);
        }
    }

    private function getSubmodules()
    {
        return $submodules = [
            ['id' => '1','name' => 'Group Info','module_id' => '1','created_at' => '2019-12-25 20:45:50','updated_at' => '2019-12-25 23:03:11'],
            ['id' => '2','name' => 'Merchandising Setup','module_id' => '5','created_at' => '2019-12-25 20:46:45','updated_at' => '2020-02-12 06:00:57'],
            ['id' => '3','name' => 'Employee Info','module_id' => '3','created_at' => '2019-12-25 20:47:14','updated_at' => '2019-12-25 20:47:14'],
            ['id' => '4','name' => 'HR Setup','module_id' => '3','created_at' => '2019-12-25 20:47:50','updated_at' => '2019-12-25 20:47:50'],
            ['id' => '5','name' => 'Bonus','module_id' => '3','created_at' => '2019-12-25 20:48:33','updated_at' => '2019-12-25 20:48:33'],
            ['id' => '6','name' => 'Leave','module_id' => '3','created_at' => '2019-12-25 20:48:52','updated_at' => '2019-12-25 20:48:52'],
            ['id' => '7','name' => 'Short Leave','module_id' => '3','created_at' => '2019-12-25 20:49:22','updated_at' => '2019-12-25 20:49:22'],
            ['id' => '8','name' => 'Attendance','module_id' => '3','created_at' => '2019-12-25 20:49:43','updated_at' => '2019-12-25 20:49:43'],
            ['id' => '9','name' => 'Disbursement','module_id' => '3','created_at' => '2019-12-25 20:50:30','updated_at' => '2019-12-25 20:50:30'],
            ['id' => '10','name' => 'HR Loan','module_id' => '3','created_at' => '2019-12-25 20:51:36','updated_at' => '2019-12-25 20:51:36'],
            ['id' => '11','name' => 'Payroll','module_id' => '3','created_at' => '2019-12-25 20:52:06','updated_at' => '2019-12-25 20:52:06'],
            ['id' => '12','name' => 'Increment','module_id' => '3','created_at' => '2019-12-25 20:52:33','updated_at' => '2019-12-25 20:52:33'],
            ['id' => '13','name' => 'Late Management','module_id' => '3','created_at' => '2019-12-25 20:53:07','updated_at' => '2019-12-25 22:49:37'],
            ['id' => '14','name' => 'Item','module_id' => '4','created_at' => '2019-12-25 20:53:52','updated_at' => '2019-12-25 20:53:52'],
            ['id' => '15','name' => 'Purchase','module_id' => '4','created_at' => '2019-12-25 20:54:14','updated_at' => '2019-12-25 20:54:14'],
            ['id' => '16','name' => 'Requisition','module_id' => '4','created_at' => '2019-12-25 20:54:54','updated_at' => '2019-12-25 20:54:54'],
            ['id' => '17','name' => 'GS Report','module_id' => '4','created_at' => '2019-12-25 20:55:17','updated_at' => '2019-12-25 20:55:17'],
            ['id' => '18','name' => 'Access Panel','module_id' => '2','created_at' => '2020-01-02 04:22:07','updated_at' => '2020-01-02 04:22:07'],
            ['id' => '19','name' => 'Application','module_id' => '3','created_at' => '2020-01-22 02:23:02','updated_at' => '2020-01-22 02:23:02'],
            ['id' => '20','name' => 'Order','module_id' => '5','created_at' => '2020-02-07 05:09:17','updated_at' => '2020-02-07 05:09:17'],
            ['id' => '21','name' => 'Sample Dispatch','module_id' => '5','created_at' => '2020-03-07 22:36:24','updated_at' => '2020-03-07 22:36:24'],
            ['id' => '22','name' => 'Production Salary','module_id' => '3','created_at' => '2020-03-09 01:23:38','updated_at' => '2020-03-09 01:23:38'],
            ['id' => '23','name' => 'Daily Work Report','module_id' => '3','created_at' => '2020-04-13 06:42:20','updated_at' => '2020-04-13 06:42:20'],
            ['id' => '24','name' => 'Work Order','module_id' => '6','created_at' => '2020-05-13 21:16:55','updated_at' => '2020-05-13 21:16:55'],
            ['id' => '25','name' => 'Supplier PI','module_id' => '6','created_at' => '2020-05-13 21:19:14','updated_at' => '2020-05-13 21:19:14'],
            ['id' => '26','name' => 'Commercial Setup','module_id' => '7','created_at' => '2020-06-09 00:48:51','updated_at' => '2020-06-09 00:48:51'],
            ['id' => '27','name' => 'Export P.I','module_id' => '5','created_at' => '2020-06-09 00:50:43','updated_at' => '2020-11-12 03:02:06'],
            ['id' => '28','name' => 'SMS API','module_id' => '8','created_at' => '2020-07-06 22:04:36','updated_at' => '2020-07-06 22:04:36'],
            ['id' => '29','name' => 'Notice','module_id' => '8','created_at' => '2020-07-06 22:04:58','updated_at' => '2020-07-06 22:04:58'],
            ['id' => '30','name' => 'GRN','module_id' => '6','created_at' => '2020-10-07 00:30:12','updated_at' => '2020-10-07 00:30:12'],
            ['id' => '31','name' => 'PF','module_id' => '3','created_at' => '2020-10-20 03:44:28','updated_at' => '2020-10-20 03:44:28'],
            ['id' => '32','name' => 'Sales Id','module_id' => '5','created_at' => '2020-10-20 04:24:24','updated_at' => '2020-10-20 04:24:24'],
            ['id' => '33','name' => 'M Report','module_id' => '5','created_at' => '2020-10-20 04:24:35','updated_at' => '2020-10-20 04:24:35'],
            ['id' => '34','name' => 'MID','module_id' => '7','created_at' => '2020-10-20 04:24:46','updated_at' => '2020-10-20 04:24:46'],
            ['id' => '35','name' => 'Schedule','module_id' => '3','created_at' => '2020-11-12 23:34:33','updated_at' => '2020-11-12 23:34:33'],
            ['id' => '36','name' => 'BB LC','module_id' => '7','created_at' => '2020-12-07 01:27:11','updated_at' => '2020-12-07 01:27:11'],
            ['id' => '37','name' => 'MID Transfer','module_id' => '7','created_at' => '2021-01-03 22:12:09','updated_at' => '2021-01-03 22:12:09'],
            ['id' => '38','name' => 'Invoice','module_id' => '7','created_at' => '2021-01-10 01:38:12','updated_at' => '2021-01-10 01:38:12'],
            ['id' => '39','name' => 'Cash','module_id' => '9','created_at' => '2021-01-25 22:49:32','updated_at' => '2021-01-25 22:49:32'],
            ['id' => '40','name' => 'Overtime & Holiday Allowance','module_id' => '3','created_at' => '2021-02-02 00:13:04','updated_at' => '2021-02-02 00:13:04'],

            ['id' => '41','name' => 'Setup','module_id' => '10','created_at' => '2021-02-12 23:19:02','updated_at' => '2021-02-12 23:19:02'],
            ['id' => '42','name' => 'Voucher','module_id' => '10','created_at' => '2021-02-12 23:19:22','updated_at' => '2021-02-12 23:19:22'],
            ['id' => '43','name' => 'Fund Transfer','module_id' => '10','created_at' => '2021-02-12 23:19:32','updated_at' => '2021-02-12 23:19:32'],
            ['id' => '44','name' => 'Report','module_id' => '10','created_at' => '2021-02-12 23:19:49','updated_at' => '2021-02-12 23:19:49'],


            // employee permission
            ['id' => '45','name' => 'E. Profile','module_id' => '11','created_at' => '2021-02-13 16:18:01','updated_at' => '2021-02-13 16:18:01'],
            ['id' => '46','name' => 'E. Leave','module_id' => '11','created_at' => '2021-02-13 16:18:20','updated_at' => '2021-02-13 16:18:20'],
            ['id' => '47','name' => 'E. Hr Loan','module_id' => '11','created_at' => '2021-02-13 16:18:32','updated_at' => '2021-02-13 16:18:32'],
            ['id' => '48','name' => 'E. Out Work','module_id' => '11','created_at' => '2021-02-13 16:18:50','updated_at' => '2021-02-13 16:18:50'],
            ['id' => '49','name' => 'E. Payslip','module_id' => '11','created_at' => '2021-02-13 16:19:08','updated_at' => '2021-02-13 16:19:08'],
            ['id' => '50','name' => 'E. Notice','module_id' => '11','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '51','name' => 'Expense','module_id' => '3','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],

            ['id' => '52','name' => 'Transfer Yarn','module_id' => '12','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '53','name' => 'Programs','module_id' => '12','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '54','name' => 'Issues','module_id' => '12','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '55','name' => 'Issue Return','module_id' => '12','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '56','name' => 'E. Other Expense','module_id' => '11','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '57','name' => 'E. Daily Work','module_id' => '11','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '58','name' => 'Receive','module_id' => '12','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '59','name' => 'Reports','module_id' => '7','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '60','name' => 'Compliance','module_id' => '3','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '61','name' => 'E. Attendance','module_id' => '11','created_at' => '2021-02-13 16:19:21','updated_at' => '2021-02-13 16:19:21'],
            ['id' => '62','name' => 'EMP. Evaluation','module_id' => '3','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],

            // Production
            ['id' => '70001','name' => 'Production','module_id' => '70001','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],
            ['id' => '70002','name' => 'Manufactured','module_id' => '70001','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],
            ['id' => '70003','name' => 'Materials','module_id' => '70001','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],
            ['id' => '70004','name' => 'Factories','module_id' => '70001','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],
            ['id' => '70005','name' => 'Product-Reports','module_id' => '70001','created_at' => '2021-08-31 16:19:21','updated_at' => '2021-08-31 16:19:21'],

        
            array('id' => '80001','name' => 'POS Settings','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80002','name' => 'POS Access Panel','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80003','name' => 'POS User','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80004','name' => 'POS Group Info','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80005','name' => 'POS All Branches','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80006','name' => 'POS Reports','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80007','name' => 'POS Customer','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80008','name' => 'POS Product','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80009','name' => 'POS Sales','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07'),
            array('id' => '80010','name' => 'POS Purchase','module_id' => '80001','created_at' => '2021-09-13 11:13:07','updated_at' => '2021-09-13 11:13:07')
        ];
    }
}
