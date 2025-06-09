@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">⚙️ Platform Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.settings.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="site_name" class="form-label">Site Name</label>
            <input type="text" name="site_name" id="site_name" class="form-control"
                   value="{{ old('site_name', $settings['site_name'] ?? '') }}">
        </div>

        <div class="form-check form-switch mb-3">
            <input type="hidden" name="maintenance_mode" value="0">
            <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode"
                value="1" {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode']) ? 'checked' : '' }}>

            <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
