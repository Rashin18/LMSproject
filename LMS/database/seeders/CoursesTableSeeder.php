<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // In the seeder
public function run()
{
    Course::factory()->count(10)->create(['is_active' => true]);
}
}
