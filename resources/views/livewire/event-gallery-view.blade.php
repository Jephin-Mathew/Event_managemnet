<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Gallery — <span class="text-primary">{{ $event->title }}</span></h2>
        <a href="{{ route('gallery.upload', $event->id) }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-cloud-upload me-1"></i> Upload Photo
        </a>
    </div>

    @if($photos->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle-fill me-2"></i> No photos uploaded yet. Be the first to contribute!
        </div>
    @else
        <div class="row g-4">
            @foreach($photos as $photo)
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img
                            src="{{ asset('storage/' . $photo->filepath) }}"
                            class="card-img-top"
                            alt="Photo uploaded by {{ $photo->user->name }}"
                            style="object-fit: cover; height: 200px;"
                        >
                        <div class="card-body px-2 py-3">
                            <small class="text-muted d-block text-center">
                                by {{ $photo->user->name }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
