<!DOCTYPE html>
<html lang="en">
<head>
    <title>Room Service - Log</title>

    <link href="/css/app.css" rel="stylesheet"/>

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Swagger UI</a></li>
            <li class="nav-item">
                <a class="nav-link" href="/log">Request Log</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Request Log</h1>
    @if (count($api_requests) > 0)

        <table class="table table-striped task-table">

            <!-- Table Headings -->
            <thead>
            <th>Endpoint</th>
            <th>Input</th>
            <th>Output</th>
            <th>Time</th>
            </thead>

            <!-- Table Body -->
            <tbody>
            @foreach ($api_requests as $api_request)
                <tr>
                    <!-- Task Name -->
                    <td class="table-text">
                        <div>{{ $api_request->endpoint }}</div>
                    </td>

                    <td>
                        <div>{{ $api_request->input }}</div>
                    </td>

                    <td>
                        <div>{{ $api_request->output }}</div>
                    </td>

                    <td>
                        <div>{{ $api_request->created_at }}</div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
</div>
</body>
</html>