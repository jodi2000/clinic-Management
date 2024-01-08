<html>
<head>
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            text-align: center;
            padding: 20px;
            margin: 0;
            background-color: #4CAF50;
            color: white;
        }

        form {
            text-align: center;
            margin: 20px 0;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-left: 5px;
        }

        form button[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        p.sort-links {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        p.sort-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #4CAF50;
        }

        p.sort-links a.active {
            color: #333;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Reports</h1>
    <form action="{{ route('reports.index') }}" method="GET">
        <label for="file_id">File ID:</label>
        <input type="text" name="file_id" id="file_id" value="{{ request('file_id') }}">
        <button type="submit">Filter</button>
    </form>

    <p class="sort-links">Sort by:
        <a href="{{ route('reports.index', ['sort_by' => 'time_in', 'sort_type' => 'asc', 'file_id' => request('file_id')]) }}"
            class="{{ $sortBy === 'time_in' && $sortType === 'asc' ? 'active' : '' }}">Time In Ascending</a> |
        <a href="{{ route('reports.index', ['sort_by' => 'time_in', 'sort_type' => 'desc', 'file_id' => request('file_id')]) }}"
            class="{{ $sortBy === 'time_in' && $sortType === 'desc' ? 'active' : '' }}">Time In Descending</a> |
        <a href="{{ route('reports.index', ['sort_by' => 'time_out', 'sort_type' => 'asc', 'file_id' => request('file_id')]) }}"
            class="{{ $sortBy === 'time_out' && $sortType === 'asc' ? 'active' : '' }}">Time Out Ascending</a> |
        <a href="{{ route('reports.index', ['sort_by' => 'time_out', 'sort_type' => 'desc', 'file_id' => request('file_id')]) }}"
            class="{{ $sortBy === 'time_out' && $sortType === 'desc' ? 'active' : '' }}">Time Out Descending</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>File ID</th>
                <th>File PATH</th>
                <th>File NAME</th>
                <th>File CREATED_AT</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>User ID</th>
                <th>User NAME</th>
                <th>Group ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->file->id }}</td>
                    <td>{{ $report->file->path }}</td>
                    <td>{{ $report->file->name }}</td>
                    <td>{{ $report->file->created_at }}</td>
                    <td>{{ $report->time_in }}</td>
                    <td>{{ $report->time_out }}</td>
                    <td>{{ $report->user_id }}</td>
                    <td>{{ $report->user->name }}</td>
                    <td>{{ $report->group_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>