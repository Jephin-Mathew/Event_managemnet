<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Upload Photos — <span class="text-primary">{{ $event->title }}</span></h2>
        <a href="{{ route('gallery.view', $event->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-images me-1"></i> View Gallery
        </a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form wire:submit.prevent="uploadPhoto" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="photo" class="form-label">Choose a Photo <span class="text-danger">*</span></label>
                <input
                    type="file"
                    id="photo"
                    class="form-control @error('photo') is-invalid @enderror"
                    wire:model="photo"
                    accept="image/*"
                >
                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            @if ($photo)
                <div class="mb-3">
                    <p class="small text-muted">Preview:</p>
                    <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="max-height: 300px;">
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary" @if(!$photo) disabled @endif>
                    <i class="bi bi-upload me-1"></i> Upload
                </button>
                <a href="{{ route('events.detail', $event->id) }}" class="btn btn-link text-muted">← Back to Event</a>
            </div>
        </form>
    </div>
</div>
