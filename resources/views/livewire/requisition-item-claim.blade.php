<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"> Claim Item</h2>
        <a href="{{ route('requisitions.list', $item->event_id) }}" class="btn btn-outline-secondary">← Back to Requisition List</a>
    </div>
    <h5 class="text-muted mb-4">Item: {{ $item->name }}</h5>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">📋 Item Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $item->description ?: 'No description provided.' }}</p>
            <p><strong>Visibility:</strong> {{ ucfirst($item->visibility) }}</p>
            <p>
                <strong>Status:</strong>
                @if($item->claimed_by)
                    <span class="badge bg-success">Claimed by {{ $item->claimer?->name ?? 'Unknown' }}</span>
                @else
                    <span class="badge bg-secondary">Unclaimed</span>
                @endif
            </p>
        </div>
    </div>

    @if(!$item->claimed_by || ($item->is_gift || $item->is_optional))
        <div class="text-center">
            <button
                wire:click="claim"
                class="btn btn-primary px-4"
                @if($item->claimed_by && !($item->is_gift || $item->is_optional)) disabled @endif
            >
                 Claim This Item
            </button>
        </div>
    @else
        <div class="alert alert-info text-center">
            This item has already been claimed and cannot be claimed again.
        </div>
    @endif

</div>
