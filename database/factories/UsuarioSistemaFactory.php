<?php

namespace Database\Factories;

use App\Models\UsuarioSistema;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioSistemaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsuarioSistema::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'usu_nome' => $this->faker->name,
            'usu_username' => $this->faker->unique()->userName,
            'usu_documento' => '78173732051',
            'usu_email' => $this->faker->unique()->safeEmail,
            'usu_senha' => '123456',
            'per_id' => 1
        ];
    }
}
