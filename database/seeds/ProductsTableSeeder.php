<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();



    	$faker = Faker\Factory::create();

    	$limit = 30;

    	for ($i = 1; $i < $limit; $i++) {

            $product                        = new App\Product;
            $product->sku                  = $faker->word;
            $product->name                  = $faker->word;
            $product->slug                  =$faker->word;
            $product->description           = $faker->sentence;
            $product->unit_price            = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL);
            $product->discount_price        = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL);
            $product->quantity_per_unit     = $faker->numberBetween($min = 1, $max = 30);
            $product->units_in_stock        = $faker->numberBetween($min = 1, $max = 100);
            $product->units_on_order        = $faker->numberBetween($min = 1, $max = 5);
            $product->reorder_level         = $faker->numberBetween($min = 1, $max = 30);
            $product->is_taxable            = $faker->boolean($chanceOfGettingTrue = 98);
            $product->is_available          = $faker->boolean($chanceOfGettingTrue = 98);
            $product->is_discountable       = $faker->boolean($chanceOfGettingTrue = 98);
            $product->is_active             = $faker->boolean($chanceOfGettingTrue = 98);
            $product->large_image_path      = $faker->imageUrl($width = 300, $height = 390);
            $product->thumbnail_image_path  = $faker->imageUrl($width = 300, $height = 390);
            $product->save();
    	}
    }
}
