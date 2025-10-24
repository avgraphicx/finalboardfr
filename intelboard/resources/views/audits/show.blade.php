@extends('layouts.master')

@section('content')
    <a href="{{ route('audits.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
    <div class="card mt-3">
        <div class="card-body">
            <h5>{{ __('messages.audit_log_details') ?? 'Audit Log Details' }}</h5>
            <p><strong>{{ __('messages.user') ?? 'User' }}:</strong> {{ $auditLog->user->full_name ?? 'System' }}</p>
            <p><strong>{{ __('messages.action') ?? 'Action' }}:</strong> {{ $auditLog->action }}</p>
            <p><strong>{{ __('messages.model') ?? 'Model' }}:</strong> {{ class_basename($auditLog->model_type) }}</p>
            <p><strong>{{ __('messages.date') ?? 'Date' }}:</strong> {{ $auditLog->created_at?->format('Y-m-d H:i:s') }}
            </p>
        </div>
    </div>
@endsection
