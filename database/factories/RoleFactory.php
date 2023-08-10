<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_name' => $this->getRoleNameBasedOnId(),
            'role_permissions' => serialize($this->faker->randomElements(['permission1', 'permission2', 'permission3'], 2)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get role name based on the ID being created.
     *
     * @return string
     */
    public function getRoleNameBasedOnId()
    {
        $id = $this->faker->numberBetween(1, 3); // Assuming IDs are from 1 to 3

        switch ($id) {
            case 1:
                return 'superadmin';
            case 2:
                return 'admin';
            case 3:
                return 'employee';
            default:
                return 'unknown'; // Handle unexpected cases gracefully
        }
    }
}
