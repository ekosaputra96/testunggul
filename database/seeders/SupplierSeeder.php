<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Supplier::create([
            'nama' => 'test',
            'deskripsi' => 'test description'
        ]);
        Supplier::create([
            'nama' => 'PT. Coba Aja',
            'deskripsi' => 'test1 description'
        ]);
    }
}
