<?php

use Illuminate\Database\Seeder;

class QuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x=0; $x <= 200; $x++) {
            $faker = Faker\Factory::create();
            $quiz = new \App\Quiz([
                'title' => $faker->text(140),
                'slug' => $faker->slug,
                'description' => $faker->text,
                'resultTitle' => $faker->text(140),
                'resultDescription' => $faker->text,
                'avatarPositionX' => rand(300, 500),
                'avatarPositionY' => rand(300, 500),
                'avatarWidth' => 250,
                'avatarHeight' => 250,
                'enabled' => true,
                'coverImage' => 'https://picsum.photos/1200/630/?random',
                'thumbImage' => 'https://picsum.photos/300/157/?random'
            ]);

            if ($quiz->save()) {
                for ($y=0; $y <= 10; $y++) {
                    $quizImage = new \App\QuizImage([
                        'quiz_id' => $quiz->id,
                        'imageUrl' => 'https://picsum.photos/1200/630/?random',
                        'imageSize' => 250000
                    ]);
                    $quizImage->save();
                }
            }
        }
    }
}
