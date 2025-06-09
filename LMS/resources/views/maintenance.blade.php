<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Mode</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 50px; }
        body { font: 20px Helvetica, sans-serif; color: #333; }
        article { display: block; text-align: left; max-width: 650px; margin: 0 auto; }
    </style>
</head>
<body>
    <article>
        <h1>We'll be back soon!</h1>
        <div>
            <p>Sorry for the inconvenience but we're performing some maintenance at the moment.</p>
            <p>&mdash; The Team</p>
            
            @auth
                @if(Auth::user()->role === 'superadmin')
                    <div class="mt-4">
                        <form action="{{ route('superadmin.toggle.maintenance') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Disable Maintenance Mode</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </article>
</body>
</html>