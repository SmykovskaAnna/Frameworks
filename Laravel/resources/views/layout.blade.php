
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
        }

        h1, h2 {
            color: #333;
        }

        nav {
            margin-bottom: 25px;
        }

        nav a {
            margin-right: 15px;
            color: #007bff;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eee;
        }

        input, textarea, select {
            display: block;
            width: 100%;
            max-width: 500px;
            padding: 8px;
            margin: 8px 0 15px;
        }

        button, .btn {
            padding: 8px 14px;
            cursor: pointer;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <h1>Museum Management System</h1>

    <nav>
        <a href="{{ route('exhibits.index') }}">Exhibits</a>
        <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
        <a href="{{ route('visitors.index') }}">Visitors</a>
        <a href="{{ route('tickets.index') }}">Tickets</a>
        <a href="{{ route('exhibition-exhibits.index') }}">Exhibition Exhibits</a>
    </nav>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</body>
</html>
