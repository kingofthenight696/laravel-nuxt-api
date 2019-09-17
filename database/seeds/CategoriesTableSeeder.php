<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::userRole()->get(['id']);

        factory(Category::class, 10)->create()->each(function ($category) use ($users) {
            factory(Product::class, 25)->create([
                'category_id' => $category->id,
                'owner_id' => User::adminRole()->first()->id
            ])->each(function ($product) use ($users){
                factory(Image::class, 5)->create(['product_id' => $product->id]);
                factory(Comment::class, 25)->create(['product_id' => $product->id]);
            });
        });
    }
}
