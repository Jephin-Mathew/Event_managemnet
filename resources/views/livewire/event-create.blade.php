<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Event</h2>
        <a href="{{ route('events.list') }}" class="btn btn-outline-secondary">← Back to Events</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow-sm p-4 rounded">
        <form wire:submit.prevent="createEvent" autocomplete="off" novalidate>
            <div class="mb-3">
                <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" wire:model.defer="title" />
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" id="date" class="form-control @error('date') is-invalid @enderror" wire:model.defer="date" />
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-label">Time <span class="text-danger">*</span></label>
                    <input type="time" id="time" class="form-control @error('time') is-invalid @enderror" wire:model.defer="time" />
                    @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
<select id="event_type" class="form-select @error('event_type') is-invalid @enderror" wire:model="event_type">
    <option value="">-- Select Event Type --</option>
    @foreach ($eventTypes as $type)
        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
    @endforeach
</select>



                @error('event_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="event_for" class="form-label">Event For <span class="text-danger">*</span></label>
                <select id="event_for" class="form-select @error('event_for') is-invalid @enderror" wire:model.defer="event_for">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('event_for') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4 p-3 bg-light rounded border">
                <label class="form-label mb-2">Invite Other Users (optional)</label>
                <div class="row">
                    @foreach ($users as $user)
                        @if ($user->id !== $event_for)
                            <div class="col-md-6">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}" wire:model="invited_user_ids">
                                    <label class="form-check-label">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @error('invited_user_ids') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="event_guidelines" class="form-label">Event Guidelines / Conditions</label>
                <textarea id="event_guidelines" rows="4" class="form-control @error('event_guidelines') is-invalid @enderror" wire:model.defer="event_guidelines" placeholder="e.g. Dress code, theme, costumes..."></textarea>
                @error('event_guidelines') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create Event</button>
                <a href="{{ route('events.list') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
