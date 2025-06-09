<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::with(['batch', 'courses'])->get();
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->email,
            $student->student_id,
            $student->batch->name ?? 'N/A',
            $student->courses->pluck('name')->implode(', '),
            $student->status,
            $student->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Student ID',
            'Batch',
            'Courses',
            'Status',
            'Join Date'
        ];
    }
}