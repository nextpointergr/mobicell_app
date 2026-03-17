<?php

namespace Database\Seeders;

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
        Store::updateOrCreate(
            ['slug' => 'central'],
            [
                'name'    => 'Αγία Παρασκευή',
                'email'   => 'info@mobicell.gr',
                'phone'   => '+302106090399',
                'address' => 'Αγίου Ιωάννου 24Α, ΤΚ 15342',
                'active'  => true,
                'central' => true,
            ]
        );
    }
}
