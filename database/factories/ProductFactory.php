<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // enum type
        $type = $this->faker->randomElement(['perhiasan', 'batangan', 'lain']);

        // karat: batangan cenderung 24, perhiasan variatif
        $karat = $type === 'batangan'
            ? 24.00
            : $this->faker->randomElement([8.00, 9.00, 10.00, 14.00, 18.00, 22.00]);

        // harga (arbitrary realistis, sesuaikan kebutuhan kamu)
        $buy = $this->faker->randomFloat(2, 700_000, 1_300_000);  // per gram
        $sell = $buy + $this->faker->randomFloat(2, 30_000, 150_000);
        $making = $type === 'perhiasan' ? $this->faker->randomFloat(2, 50_000, 300_000) : 0.0;

        // 12–13 digit barcode
        $barcode = (string)$this->faker->unique()->numberBetween(100000000000, 999999999999);

        return [
            'sku'                 => 'SKU-' . strtoupper($this->faker->unique()->bothify('??##??##')),
            'barcode'             => $barcode,
            'name'                => $type === 'batangan'
                ? 'Emas Batangan ' . $this->faker->randomElement([1, 5, 10, 25, 50, 100]) . 'gr'
                : $this->faker->words(3, true),
            'type'                => $type,
            'karat'               => $karat,
            'buy_price_per_gram'  => $buy,
            'sell_price_per_gram' => $sell,
            'making_fee'          => $making,
            'notes'               => $this->faker->boolean(40) ? $this->faker->sentence() : null,
            'image_path'          => null, // nanti kalau sudah upload, ganti pakai Storage path
        ];
    }
}
