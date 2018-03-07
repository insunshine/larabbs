<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = app(Faker\Generator::class);

        $avatars = [
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
            'http://larabbs.test/uploads/images/avatar/201803/02/1_1519973888_BTWnCrqgb2.png',
        ];

        //生成数据集合
        $users = factory(\App\Models\User::class)
                            ->times(10)
                            ->make()
                            ->each(function ($user, $index)
                                use($avatars, $faker)
                            {
                                $user->avatar = $faker->randomElement($avatars);
                            }
        );
        \App\Models\User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = \App\Models\User::find(1);
        $user->name = 'FreeLoop';
        $user->email = '292228108@qq.com';
        $user->save();
    }
}
