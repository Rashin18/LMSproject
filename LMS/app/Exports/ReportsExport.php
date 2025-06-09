<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data['audit'];
    }

    public function headings(): array
    {
        return [
            'Date',
            'User',
            'Action',
            'Details',
            'IP Address'
        ];
    }

    public function map($log): array
    {
        return [
            $log->created_at->format('Y-m-d H:i'),
            $log->user->name ?? 'System',
            $log->action,
            substr($log->details, 0, 50) . (strlen($log->details) > 50 ? '...' : ''),
            $log->ip_address
        ];
    }
}