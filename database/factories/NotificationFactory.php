<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cat_id' => $this->faker->numberBetween(1, 10), // Thay 10 bằng số lượng danh mục thực tế
            'noti_title' => $this->faker->sentence,
            'noti_content' => $this->faker->paragraph,
            'noti_date' => $this->faker->date,
            'noti_status' => $this->faker->randomElement([0, 1]),
            'noti_url' => $this->faker->url,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
