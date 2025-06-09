<?php

namespace Database\Seeders;
use App\Models\Batch;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Create batches
    $batch1 = Batch::create([
        'name' => '2023 Spring',
        'code' => 'SP23',
        'start_date' => '2023-01-15',
        'end_date' => '2023-05-30'
    ]);
    
    // Create subjects
    $math = Subject::create([
        'name' => 'Mathematics',
        'code' => 'MATH101',
        'course_id' => 1, // Assuming you have courses
        'teacher_id' => User::where('role', 'teacher')->first()->id
    ]);
}
}
