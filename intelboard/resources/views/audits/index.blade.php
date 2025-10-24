@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.audit_logs') ?? 'Audit Logs' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if ($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.user') ?? 'User' }}</th>
                                        <th>{{ __('messages.action') ?? 'Action' }}</th>
                                        <th>{{ __('messages.model') ?? 'Model' }}</th>
                                        <th>{{ __('messages.date') ?? 'Date' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->user->full_name ?? 'System' }}</td>
                                            <td>{{ $log->action }}</td>
                                            <td>{{ class_basename($log->model_type) }}</td>
                                            <td>{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">{{ __('messages.no_logs_found') ?? 'No logs found.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
