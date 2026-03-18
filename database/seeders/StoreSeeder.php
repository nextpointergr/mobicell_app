<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::updateOrCreate(
            ['slug' => 'central'],
            [
                'name'    => 'Αγία Παρασκευή',
                'email'   => 'info@mobicell.gr',
                'phone'   => '+302106090399',
                'address' => 'Αγίου Ιωάννου 24Α, ΤΚ 15342',
                'active'  => true,
                'central' => true,
                'pylon_base_url' => 'http://78.108.37.153:8775',
                'pylon_apicode' =>'GFK100JGRVAOHTR',
                'pylon_databasealias' => 'sql_mobicell_ee',
                'pylon_username' =>'administrator',
                'pylon_password' => 'admin123!@#',
                'pylon_applicationname' => 'Hercules.MyPylonCommercial'
            ]
        );


        Setting::set('central_store_id', $store->id);
    }
}
