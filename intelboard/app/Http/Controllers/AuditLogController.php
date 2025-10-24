<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs.
     */
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->table, fn($q) => $q->where('table_name', $request->table))
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('audits.index', compact('logs'));
    }

    /**
     * Display a specific audit log.
     */
    public function show(AuditLog $auditLog)
    {
        return view('audits.show', compact('auditLog'));
    }

    /**
     * Export audit logs
     */
    public function export(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->table, fn($q) => $q->where('table_name', $request->table))
            ->get();

        $csv = "ID,User,Action,Table,Record ID,IP,Created At\n";
        foreach ($logs as $log) {
            $csv .= "{$log->id},{$log->user->full_name},{$log->action},{$log->table_name},{$log->record_id},{$log->ip_address},{$log->created_at}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit-logs.csv"',
        ]);
    }
}
