<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $supplier = Supplier::latest()->first();

        Product::create([
            'nama' => 'test1',
            'deskripsi' => 'test1',
            'harga' => 1000,
            'is_active' => true,
            'stock' => 4,
            'supplier_id' => $supplier->id
        ]);
    }
}
