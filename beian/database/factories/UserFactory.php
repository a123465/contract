<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cnNames = [
            '王伟','李静','张强','刘洋','陈娜','杨磊','赵敏','黄涛','周杰','吴倩','孙力','胡杰','朱丽','高峰','林芳','田雨','韩梅','郑浩','冯芸','程鹏'
        ];

        $nicknameSuffix = ['旅行者','背包客','摄影师','吃货','驴友','探店君','慢生活'];

        $name = $this->faker->randomElement($cnNames);
        $nickname = $name . $this->faker->randomElement($nicknameSuffix);

        return [
            'username' => fake()->unique()->userName(),
            'name' => $name,
            'nickname' => $nickname,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
