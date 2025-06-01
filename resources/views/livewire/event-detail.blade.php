<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ $event->title }}</h2>
        <a href="{{ route('events.list') }}" class="btn btn-outline-secondary">← Back to Events</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">Date:</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</dd>

                    <dt class="col-sm-4">Time:</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</dd>

                    <dt class="col-sm-4">Type:</dt>
                    <dd class="col-sm-8">{{ $event->event_type }}</dd>

                    <dt class="col-sm-4">Event For:</dt>
                    <dd class="col-sm-8">{{ $event->eventFor ? $event->eventFor->name : 'Self' }}</dd>

                    <dt class="col-sm-4">Created By:</dt>
                    <dd class="col-sm-8">{{ $event->creator->name }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <h5>Event Guidelines</h5>
                <p class="text-muted mb-0">{{ $event->event_guidelines ?: 'No specific guidelines provided.' }}</p>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4" id="eventTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="invitations-tab" data-bs-toggle="tab" data-bs-target="#invitations" type="button" role="tab" aria-controls="invitations" aria-selected="true">
                Invitations ({{ $event->invitations->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('requisitions.list', $event->id) }}">
                 Requisitions ({{ $event->requisitionItems->count() }})
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('gallery.view', $event->id) }}">
                 Gallery ({{ $event->photos->count() }})
            </a>
        </li>
    </ul>

    <div class="tab-content" id="eventTabContent">

        <div class="tab-pane fade show active" id="invitations" role="tabpanel" aria-labelledby="invitations-tab">
            @if($event->invitations->isEmpty())
                <p class="text-muted">No invitations for this event yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Responded At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->invitations as $invitation)
                                <tr>
                                    <td>{{ $invitation->user->name }}</td>
                                    <td>
                                        @if($invitation->user_id === auth()->id() && $invitation->status === 'pending')
                                            <a href="{{ route('invitations.respond', $invitation->id) }}" class="badge bg-warning text-dark text-decoration-none">
                                                Respond
                                            </a>
                                        @elseif($invitation->status === 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($invitation->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $invitation->updated_at ? $invitation->updated_at->format('d M Y, h:i A') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
