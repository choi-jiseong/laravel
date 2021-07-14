<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $users = null;
    protected $posts = null;

    public function __construct()
    {
        parent::__construct();
        $this->users = User::all();
        $this->posts = Post::all();
    }
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'content' => $this->faker->sentence(),
            'user_id' => $this->users->random()->id,  //기존에 있는 유저중 랜덤으로 부른다
            // 'user_id' => User::factory()->create()->id,  //새로운 fake 유저를 만든다
        ];
    }
}
