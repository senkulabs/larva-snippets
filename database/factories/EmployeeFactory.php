<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            "Environmental Scientist",
            "Climate Policy Analyst",
            "Sustainability Manager",
            "Renewable Energy Engineer",
            "Carbon Analyst",
            "Environmental Consultant",
            "Sustainability Communications Specialist",
            "Climate Data Scientist",
            "Energy Efficiency Specialist",
            "Climate Change Advocate",
            "Green Finance Specialist",
            "Urban Planner",
            "Climate Adaptation Specialist",
            "Sustainable Agriculture Specialist",
            "Wildlife Conservationist"
        ];

        $offices = ["Tokyo", "Singapore", "China", "Edinburgh", "San Francisco", "Canada", "London"];

        return [
            'name' => $this->faker->name,
            'position' => $this->faker->randomElement($positions),
            'office' => $this->faker->randomElement($offices),
            'age' => $this->faker->numberBetween(18, 65),
            'start_date' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'salary' => $this->faker->numberBetween(50000, 150000),
        ];
    }
}
