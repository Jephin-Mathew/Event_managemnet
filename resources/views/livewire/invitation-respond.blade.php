<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"> Respond to Invitation</h2>
        <a href="{{ route('events.detail', $event->id) }}" class="btn btn-outline-secondary">← Back to Event</a>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"> Event Details</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li><strong>Title:</strong> {{ $event->title }}</li>
                <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</li>
                <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</li>
                <li><strong>Type:</strong> {{ $event->event_type }}</li>
                <li><strong>Event For:</strong> {{ $event->eventFor ? $event->eventFor->name : 'Self' }}</li>
                <li><strong>Guidelines:</strong> {{ $event->event_guidelines ?: 'No specific guidelines.' }}</li>
            </ul>
        </div>
    </div>

    @if($invitation->status === 'pending')
        <div class="text-center">
            <h5 class="mb-3">Would you like to attend this event?</h5>
            <div class="d-flex justify-content-center gap-3">
                <button wire:click="respond('accepted')" class="btn btn-success px-4"> Accept</button>
                <button wire:click="respond('rejected')" class="btn btn-danger px-4"> Reject</button>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            You have already <strong>{{ ucfirst($invitation->status) }}</strong> this invitation.
        </div>
        <div class="text-center">
            <a href="{{ route('events.detail', $event->id) }}" class="btn btn-primary mt-2">View Event Details</a>
        </div>
    @endif

</div>
