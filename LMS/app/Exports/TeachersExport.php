<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Teacher::with(['courses', 'department'])->get();
    }

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->name,
            $teacher->email,
            $teacher->teacher_id,
            $teacher->department->name ?? 'N/A',
            $teacher->courses->pluck('name')->implode(', '),
            $teacher->qualification,
            $teacher->status,
            $teacher->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Teacher ID',
            'Department',
            'Courses Assigned',
            'Qualification',
            'Status',
            'Join Date'
        ];
    }
}