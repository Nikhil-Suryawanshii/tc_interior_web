@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container mt-4">
            <h3>Log [{{ $file }}]</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>File path:</strong> {{ storage_path('logs/' . $file) }}</p>
                    <p><strong>Size:</strong> {{ number_format($size / 1024, 2) }} KB</p>
                    <p><strong>Created at:</strong> {{ $created_at }}</p>
                    <p><strong>Updated at:</strong> {{ $updated_at }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('logs.download', $file) }}" class="btn btn-success">Download</a>
                    <form action="{{ route('logs.delete', $file) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="logTable">
                    <thead>
                        <tr>
                            <th>ENV</th>
                            <th>Level</th>
                            <th>Time</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logEntries as $entry)
                        <tr>
                            <td><span class="badge badge-primary">{{ $entry['env'] }}</span></td>
                            <td>
                                @if($entry['level'] == 'error')
                                    <span class="badge badge-danger">{{ $entry['level'] }}</span>
                                @elseif($entry['level'] == 'warning')
                                    <span class="badge badge-warning">{{ $entry['level'] }}</span>
                                @elseif($entry['level'] == 'info')
                                    <span class="badge badge-info">{{ $entry['level'] }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $entry['level'] }}</span>
                                @endif
                            </td>
                            <td>{{ $entry['datetime'] }}</td>
                            <td style="max-width: 500px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                            title="{{ $entry['message'] }}">
                            {{ $entry['message'] }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary toggle-stack"
                                        data-stack="{{ htmlspecialchars($entry['message'] ?? 'No stack trace available') }}">
                                    Stack
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No log entries found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listener for Stack buttons
        const toggleButtons = document.querySelectorAll('.toggle-stack');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const stackTrace = this.getAttribute('data-stack'); // Get the stack trace
                const currentRow = this.closest('tr'); // Get the current table row

                // Check if the appended row already exists
                if (currentRow.nextElementSibling && currentRow.nextElementSibling.classList.contains('stack-row')) {
                    currentRow.nextElementSibling.remove(); // Remove the row if it already exists
                } else {
                    // Create a new row for the stack trace
                    const stackRow = document.createElement('tr');
                    stackRow.classList.add('stack-row');
                    stackRow.innerHTML = `
                        <td colspan="5">
                            <pre class="stack-trace">${stackTrace}</pre>
                        </td>
                    `;
                    currentRow.after(stackRow); // Append the new row after the current row
                }
            });
        });
    });
</script>

<style>
    .stack-trace {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        white-space: pre-wrap;
        margin: 0;
        max-height: 300px; /* Set the maximum height */
        overflow-y: auto; /* Enable vertical scrolling */
        color: #d9534f; /* Bootstrap red color for text */
        font-family: monospace; /* Use a monospace font for better readability */
    }
</style>
@endsection
