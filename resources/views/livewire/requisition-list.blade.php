<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Requisition List</h2>
        <a href="{{ route('events.detail', $event->id) }}" class="btn btn-outline-secondary">← Back to Event</a>
    </div>

    <h5 class="text-muted mb-4">Event: {{ $event->title }}</h5>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($items->isEmpty())
        <div class="alert alert-info">No requisition items added yet.</div>
    @else
        <ul class="list-group mb-5">
            @foreach ($items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-start flex-column flex-md-row @if(!$item->claimed_by) list-group-item-light @endif">
                    <div class="mb-2 mb-md-0">
                        <strong>{{ $item->name }}</strong>
                        @if ($item->description)
                            <div><small class="text-muted">{{ $item->description }}</small></div>
                        @endif
                        <div><small class="text-muted">Visibility: {{ ucfirst($item->visibility) }}</small></div>
                    </div>
                    <div class="text-end">
                        @if ($item->claimed_by)
                            <span class="badge bg-success">
    Claimed by {{ $item->claimer?->name ?? 'Unknown' }}
</span>

                        @else
                            <a href="{{ route('requisition.item.claim', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                 Claim Item
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($canAddItems)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Add New Item</h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addItem" autocomplete="off" novalidate>
                    <div class="mb-3">
                        <label for="newItemName" class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" id="newItemName" class="form-control @error('newItemName') is-invalid @enderror" wire:model.defer="newItemName" />
                        @error('newItemName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="newItemDescription" class="form-label">Description</label>
                        <textarea id="newItemDescription" rows="3" class="form-control @error('newItemDescription') is-invalid @enderror" wire:model.defer="newItemDescription"></textarea>
                        @error('newItemDescription')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="newItemVisibility" class="form-label">Visibility</label>
                        <select id="newItemVisibility" class="form-select @error('newItemVisibility') is-invalid @enderror" wire:model.defer="newItemVisibility">
                            <option value="private">Private (invited users only)</option>
                            <option value="public">Public (all users)</option>
                        </select>
                        @error('newItemVisibility')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            You are not authorized to add items to this requisition list.
        </div>
    @endif
</div>
