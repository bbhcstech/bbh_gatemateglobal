@extends('admin.layout.app')

@section('title', 'Security Notifications')

@section('content')

<main class="container mt-3">

<h3 class="mb-4">
    🔔 Security Notifications
</h3>

{{-- FILTER TABS --}}
<ul class="nav nav-pills mb-3">
    <li class="nav-item">
        <a class="nav-link {{ request('type') == null ? 'active' : '' }}"
           href="{{ route('notifications.index') }}">
           All
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('type') == 'cab' ? 'active' : '' }}"
           href="{{ route('notifications.index', ['type' => 'cab']) }}">
           🚕 Cab
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('type') == 'visitor' ? 'active' : '' }}"
           href="{{ route('notifications.index', ['type' => 'visitor']) }}">
           👤 Visitor
        </a>
    </li>
</ul>

<div class="card shadow-sm">
<div class="card-body p-0">

<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr>
            <th>Type</th>
            <th>Title</th>
            <th>Message</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @forelse($notifications as $note)

        <tr class="{{ $note->is_read == 0 ? 'table-warning' : '' }}">

            {{-- TYPE BADGE --}}
            <td>
                @if($note->type === 'cab')
                    <span class="badge bg-warning text-dark">🚕 Cab</span>
                @elseif($note->type === 'visitor')
                    <span class="badge bg-info">👤 Visitor</span>
                @else
                    <span class="badge bg-secondary">General</span>
                @endif
            </td>

            <td class="fw-bold">
                {{ $note->title }}
            </td>

            <td>
                {{ $note->message }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse($note->created_at)->format('d M Y h:i A') }}
            </td>

            <td>
                @if($note->is_read == 0)
                    <form action="{{ route('notifications.read', $note->notification_id) }}"
                          method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning">
                            Mark Read
                        </button>
                    </form>
                @else
                    <span class="badge bg-success">Read</span>
                @endif
            </td>

        </tr>

    @empty
        <tr>
            <td colspan="5" class="text-center text-muted p-4">
                No notifications found
            </td>
        </tr>
    @endforelse

    </tbody>
</table>

</div>
</div>

</main>

@endsection
