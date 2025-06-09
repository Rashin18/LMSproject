<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    LogActivity,
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = [
            'start' => $request->input('start_date', now()->subDays(30)->format('Y-m-d')),
            'end' => $request->input('end_date', now()->format('Y-m-d'))
        ];

        $reports = [
            'system' => $this->getSystemReports($dateRange),
            'user' => $this->getUserReports($dateRange),
            'audit' => $this->getAuditLogs($dateRange),
            'filters' => $dateRange
        ];
        
        return view('superadmin.reports.index', compact('reports'));
    }

    protected function getSystemReports(array $dateRange)
    {
        return [
            'total_users' => User::count(),
            'active_today' => User::whereDate('updated_at', today())->count(),
            'active_period' => User::whereBetween('updated_at', [
                $dateRange['start'], 
                $dateRange['end']
            ])->count(),
            'new_this_week' => User::whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
            'storage_usage' => $this->getStorageUsage(),
        ];
    }

    protected function getUserReports(array $dateRange)
    {
        return [
            'by_role' => User::selectRaw('role, count(*) as count')
                ->groupBy('role')
                ->get()
                ->pluck('count', 'role'),
            'activity' => LogActivity::selectRaw('DATE(created_at) as date, count(*) as count')
                ->whereBetween('created_at', [
                    $dateRange['start'], 
                    $dateRange['end']
                ])
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];
    }

    protected function getAuditLogs(array $dateRange)
    {
        return LogActivity::with('user')
            ->whereBetween('created_at', [
                $dateRange['start'], 
                $dateRange['end']
            ])
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    protected function getStorageUsage()
{
    // Default values for unsupported environments
    $default = [
        'total' => 'N/A',
        'used' => 'N/A',
        'free' => 'N/A',
        'percentage' => 0
    ];

    // Only works for local disks on Unix-like systems
    if (config('filesystems.default') !== 'local' || !function_exists('disk_total_space')) {
        return $default;
    }

    try {
        $path = base_path(); // Or Storage::path('') for storage folder
        $total = disk_total_space($path);
        $free = disk_free_space($path);
        
        if ($total === false || $free === false) {
            return $default;
        }

        $used = $total - $free;
        
        return [
            'total' => round($total / (1024 ** 3), 2) . ' GB', // 1024^3 bytes = 1GB
            'used' => round($used / (1024 ** 3), 2) . ' GB',
            'free' => round($free / (1024 ** 3), 2) . ' GB',
            'percentage' => round(($used / $total) * 100, 2)
        ];
    } catch (\Exception $e) {
        return $default;
    }
}

    public function export(Request $request)
    {
        $type = $request->type ?? 'csv';
        $filters = [
            'start' => $request->input('start_date', now()->subDays(30)->format('Y-m-d')),
            'end' => $request->input('end_date', now()->format('Y-m-d'))
        ];

        $data = [
            'system' => $this->getSystemReports($filters),
            'user' => $this->getUserReports($filters),
            'audit' => $this->getAuditLogs($filters),
            'filters' => $filters
        ];

        if ($type === 'pdf') {
            return Pdf::loadView('superadmin.reports.export-pdf', compact('data'))
                    ->download('reports-'.now()->format('Y-m-d').'.pdf');
        }

        return Excel::download(new ReportsExport($data), 'reports-'.now()->format('Y-m-d').'.csv');
    }
}