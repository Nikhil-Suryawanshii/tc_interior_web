@extends('admin.dashboard')
@section('admin')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h4>Admin Logs - {{ now()->format('Y-m-d') }}</h4>
            </div>
            <div class="card-body">
                @if(!empty($logs))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>All</th>
                                        <th>Emergency</th>
                                        <th>Alert</th>
                                        <th>Critical</th>
                                        <th>Error</th>
                                        <th>Warning</th>
                                        <th>Notice</th>
                                        <th>Info</th>
                                        <th>Debug</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log['date'] }}</td>
                                        <td>{{ array_sum($log['counts']) }}</td>
                                        <td>{{ $log['counts']['emergency'] }}</td>
                                        <td>{{ $log['counts']['alert'] }}</td>
                                        <td>{{ $log['counts']['critical'] }}</td>
                                        <td>{{ $log['counts']['error'] }}</td>
                                        <td>{{ $log['counts']['warning'] }}</td>
                                        <td>{{ $log['counts']['notice'] }}</td>
                                        <td>{{ $log['counts']['info'] }}</td>
                                        <td>{{ $log['counts']['debug'] }}</td>
                                        <td>
                                            <a href="{{ route('logs.view', $log['file']) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('logs.download', $log['file']) }}" class="btn btn-sm btn-success">Download</a>
                                            <form action="{{ route('logs.delete', $log['file']) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this log?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                @else
                    <p>No logs available for today.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
