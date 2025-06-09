@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $material->title }}</h2>

    <video id="course-video" width="100%" height="auto" controls>
        <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('course-video');
    let reported = false;

    video.addEventListener('timeupdate', function () {
        const watchedPercent = (video.currentTime / video.duration) * 100;

        if (!reported || watchedPercent >= 95) {
            fetch("{{ route('student.materials.updateProgress', $material->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    progress: Math.min(100, Math.floor(watchedPercent))
                })
            });
            reported = true;
        }
    });
});
</script>
@endsection
