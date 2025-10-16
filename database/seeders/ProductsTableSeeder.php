<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        // --- 2.1. Data kurasi (aman untuk demo & unik) ---
        $samples = [
            [
                'sku' => 'PRD-EMB-001',
                'barcode' => '8991000000001',
                'name' => 'Emas Batangan 1gr',
                'type' => 'batangan',
                'karat' => 24.00,
                'buy_price_per_gram'  => 950000.00,
                'sell_price_per_gram' => 1025000.00,
                'making_fee' => 0.00,
                'notes' => 'Cert LBMA',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-EMB-005',
                'barcode' => '8991000000005',
                'name' => 'Emas Batangan 5gr',
                'type' => 'batangan',
                'karat' => 24.00,
                'buy_price_per_gram'  => 940000.00,
                'sell_price_per_gram' => 1010000.00,
                'making_fee' => 0.00,
                'notes' => 'Cert LBMA',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-CINCIN-EMAS-01',
                'barcode' => '8992000000001',
                'name' => 'Cincin Emas Polos',
                'type' => 'perhiasan',
                'karat' => 18.00,
                'buy_price_per_gram'  => 900000.00,
                'sell_price_per_gram' => 1030000.00,
                'making_fee' => 150000.00,
                'notes' => 'Ukuran variatif',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-GELANG-EMAS-01',
                'barcode' => '8992000000002',
                'name' => 'Gelang Emas Rantai',
                'type' => 'perhiasan',
                'karat' => 22.00,
                'buy_price_per_gram'  => 930000.00,
                'sell_price_per_gram' => 1075000.00,
                'making_fee' => 220000.00,
                'notes' => 'Model klasik',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-ANTING-EMAS-01',
                'barcode' => '8992000000003',
                'name' => 'Anting Emas Bulat',
                'type' => 'perhiasan',
                'karat' => 14.00,
                'buy_price_per_gram'  => 820000.00,
                'sell_price_per_gram' => 950000.00,
                'making_fee' => 180000.00,
                'notes' => null,
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-AKSES-LAIN-01',
                'barcode' => '8993000000001',
                'name' => 'Aksesoris Kait Liontin',
                'type' => 'lain',
                'karat' => 10.00,
                'buy_price_per_gram'  => 750000.00,
                'sell_price_per_gram' => 880000.00,
                'making_fee' => 50000.00,
                'notes' => 'Spare part',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-EMB-010',
                'barcode' => '8991000000010',
                'name' => 'Emas Batangan 10gr',
                'type' => 'batangan',
                'karat' => 24.00,
                'buy_price_per_gram'  => 935000.00,
                'sell_price_per_gram' => 1005000.00,
                'making_fee' => 0.00,
                'notes' => 'Cert LBMA',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-KALUNG-EMAS-01',
                'barcode' => '8992000000004',
                'name' => 'Kalung Emas Rantai Box',
                'type' => 'perhiasan',
                'karat' => 18.00,
                'buy_price_per_gram'  => 905000.00,
                'sell_price_per_gram' => 1040000.00,
                'making_fee' => 250000.00,
                'notes' => 'Panjang 45cm',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-EMB-025',
                'barcode' => '8991000000025',
                'name' => 'Emas Batangan 25gr',
                'type' => 'batangan',
                'karat' => 24.00,
                'buy_price_per_gram'  => 930000.00,
                'sell_price_per_gram' => 995000.00,
                'making_fee' => 0.00,
                'notes' => null,
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-BROSS-EMAS-01',
                'barcode' => '8993000000002',
                'name' => 'Bros Emas Motif Bunga',
                'type' => 'lain',
                'karat' => 9.00,
                'buy_price_per_gram'  => 720000.00,
                'sell_price_per_gram' => 840000.00,
                'making_fee' => 90000.00,
                'notes' => 'Motif cantik',
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-EMB-050',
                'barcode' => '8991000000050',
                'name' => 'Emas Batangan 50gr',
                'type' => 'batangan',
                'karat' => 24.00,
                'buy_price_per_gram'  => 928000.00,
                'sell_price_per_gram' => 990000.00,
                'making_fee' => 0.00,
                'notes' => null,
                'image_path' => null,
            ],
            [
                'sku' => 'PRD-CINCIN-EMAS-02',
                'barcode' => '8992000000005',
                'name' => 'Cincin Emas Mata Zircon',
                'type' => 'perhiasan',
                'karat' => 18.00,
                'buy_price_per_gram'  => 910000.00,
                'sell_price_per_gram' => 1050000.00,
                'making_fee' => 200000.00,
                'notes' => 'Stone zircon',
                'image_path' => null,
            ],
        ];

        Product::query()->upsert(
            $samples,
            ['sku'], // unique key
            ['barcode', 'name', 'type', 'karat', 'buy_price_per_gram', 'sell_price_per_gram', 'making_fee', 'notes', 'image_path']
        );

        // --- 2.2. Bulk faker (opsional): tambah 50 item acak unik ---
        if (app()->environment(['local', 'development'])) {
            Product::factory()->count(50)->create();
        }
    }
}
