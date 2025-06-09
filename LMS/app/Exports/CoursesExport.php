<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CoursesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Course::with([
                'teacher:id,name',
                'batch:id,name',
                'students:id,name'
            ])->get();
    }
    
    public function map($course): array
    {
        return [
            $course->id,
            $course->title,
            $course->description,
            $course->teacher->name ?? 'Not Assigned',
            $course->batch->name ?? 'No Batch',
            $course->start_date->format('Y-m-d'),
            $course->end_date?->format('Y-m-d') ?? 'Ongoing',
            $course->students->count(),
            $course->created_at->format('Y-m-d'),
            $course->updated_at->format('Y-m-d'),
        ];
    }
    /**
     * Define the headings
     */
    public function headings(): array
    {
        return [
            'ID',
            'Course Title',
            'Description',
            'Teacher',
            'Batch',
            'Start Date',
            'End Date',
            'Enrolled Students',
            'Created At',
            'Updated At'
        ];
    }
}