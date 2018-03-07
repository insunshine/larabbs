<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //所有用户的ID数组
        $user_ids = User::all()->pluck('id')->toArray();

        //所有分类ID
        $category_ids = Category::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index)
                use ($user_ids, $category_ids, $faker)
            {
                //从用户ID数组中取出一个并赋值
                $topic->user_id = $faker->randomElement($user_ids);

                //从分类ID数组中取出一个并赋值
                $topic->category_id = $faker->randomElement($category_ids);
            });

        Topic::insert($topics->toArray());
    }

}

