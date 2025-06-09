<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Mode</title>
    <style>
        body { 
            font-family: 'Nunito', sans-serif;
            text-align: center;
            padding: 50px;
            background: #f8fafc;
            color: #636b6f;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
        }
        .title {
            font-size: 36px;
            margin-bottom: 30px;
            color: #2d3748;
        }
        .message {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .admin-panel {
            margin-top: 40px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="title">🚧 Maintenance Mode</div>
        <div class="message">
            We're currently performing scheduled maintenance. Please check back shortly.
        </div>

        @auth
            @if(auth()->user()->role === 'superadmin')
                <div class="admin-panel">
                    <p>You're seeing this because you're a superadmin.</p>
                    <form action="{{ route('superadmin.settings.toggle.maintenance') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Disable Maintenance Mode
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</body>
</html>