@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact Messages</h2>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.messages') }}" class="row mb-4">
        <div class="col-md-6">
            <input type="text" name="search" placeholder="Search by name or email..." class="form-control" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="filter" class="form-control">
                <option value="">All</option>
                <option value="read" {{ request('filter') == 'read' ? 'selected' : '' }}>Read</option>
                <option value="unread" {{ request('filter') == 'unread' ? 'selected' : '' }}>Unread</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-success">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Message</th><th>Status</th><th>Date</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($messages as $msg)
            <tr class="{{ $msg->is_read ? 'table-light' : 'table-warning' }}">
                <td>{{ $msg->name }}</td>
                <td>{{ $msg->email }}</td>
                <td>{{ Str::limit($msg->message, 50) }}</td>
                <td>{{ $msg->is_read ? 'Read' : 'Unread' }}</td>
                <td>{{ $msg->created_at->format('d M Y') }}</td>
                <td>
                    @if(!$msg->is_read)
                        <a href="{{ route('admin.messages.read', $msg->id) }}" class="btn btn-sm btn-success">Mark as Read</a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No messages found.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $messages->links() }}
</div>
@endsection
