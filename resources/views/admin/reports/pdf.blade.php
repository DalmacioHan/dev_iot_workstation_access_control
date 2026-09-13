<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Georgia, 'Times New Roman', serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Main Data Table Styles */
        .main-content {
            margin-top: 0px;
        }
        
        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #1e293b;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            font-size: 10.5px;
        }

        table.data-table th:first-child, table.data-table td:first-child {
            width: 30px;
            text-align: center;
        }
        
        table.data-table th {
            background-color: #f8fafc;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            color: #475569;
        }
        
        table.data-table tr:nth-child(even) {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="report-title">Workstation Access Control Report</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    @if ($columns['student_name'])
                        <th>Name</th>
                    @endif
                    @if ($columns['course'])
                        <th>Course</th>
                    @endif
                    @if ($columns['workstation'])
                        <th>Workstation</th>
                    @endif
                    @if ($columns['date_time'])
                        <th>Date and Time</th>
                    @endif
                    @if ($columns['event'])
                        <th>Event</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $index => $log)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @if ($columns['student_name'])
                            <td>{{ $log->student_name }}</td>
                        @endif
                        @if ($columns['course'])
                            <td>{{ $log->course }}</td>
                        @endif
                        @if ($columns['workstation'])
                            <td>{{ $log->workstation }}</td>
                        @endif
                        @if ($columns['date_time'])
                            <td>{{ $log->occurred_at }}</td>
                        @endif
                        @if ($columns['event'])
                            <td>{{ $log->event_type }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>