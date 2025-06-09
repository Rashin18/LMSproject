@if($announcements->isNotEmpty())
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-megaphone"></i> Announcements</h5>
    </div>
    <div class="card-body">
        @foreach($announcements as $announcement)
        <div class="mb-3 pb-3 border-bottom">
            <h6 class="text-primary">{{ $announcement->title }}</h6>
            <p class="mb-2">{{ $announcement->message }}</p>
            <small class="text-muted d-block">
                <i class="bi bi-calendar"></i> 
                @if($announcement->start_at || $announcement->end_at)
                    Valid: {{ $announcement->start_at?->format('M d, Y') ?? 'Immediately' }}
                    @if($announcement->end_at)
                        - {{ $announcement->end_at->format('M d, Y') }}
                    @endif
                @else
                    No expiration
                @endif
                • Posted: {{ $announcement->created_at->format('M d, Y') }}
            </small>
        </div>
        @endforeach
    </div>
</div>
@endif