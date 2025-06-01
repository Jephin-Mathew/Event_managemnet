<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">My Events</h2>
        <a href="{{ route('events.create') }}" class="btn btn-success">
            + Create New Event
        </a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($events->isEmpty())
        <div class="text-center p-5 bg-light rounded shadow-sm">
            <h5 class="mb-3">You haven't created or been invited to any events yet.</h5>
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                Create Your First Event
            </a>
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Event For</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($event->event_type) }}</span>
                            </td>
                            <td>
                                @if($event->eventFor)
                                    {{ $event->eventFor->name }}
                                @else
                                    <span class="text-muted">Self</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('events.detail', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
