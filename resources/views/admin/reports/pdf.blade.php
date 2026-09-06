<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Control Report</title>
    <style>
        @page {
            margin: 14mm 10mm 14mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1e293b;
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        .header {
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 12px;
        }

        .brand {
            color: #1d4ed8;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        h1 {
            margin: 5px 0 3px;
            color: #0f172a;
            font-size: 22px;
        }

        .subtitle {
            color: #64748b;
            font-size: 10px;
        }

        .meta {
            width: 100%;
            margin: 16px 0;
            border-collapse: collapse;
        }

        .meta td {
            width: 25%;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            vertical-align: top;
        }

        .meta-label {
            display: block;
            margin-bottom: 3px;
            color: #64748b;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .meta-value {
            color: #0f172a;
            font-size: 9px;
        }

        .summary {
            margin: 0 0 10px;
            color: #475569;
            font-size: 9px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report thead {
            display: table-header-group;
        }

        .report th {
            padding: 6px 5px;
            border: 1px solid #1d4ed8;
            background: #1d4ed8;
            color: #ffffff;
            font-size: 6px;
            letter-spacing: .6px;
            text-align: left;
            text-transform: uppercase;
        }

        .report td {
            padding: 5px;
            border: 1px solid #cbd5e1;
            color: #334155;
            overflow-wrap: break-word;
            vertical-align: top;
        }

        .report tbody tr:nth-child(even) td {
            background: #f1f5f9;
        }

        .report .id {
            width: 5%;
        }

        .report .date {
            width: 15%;
        }

        .report .course {
            width: 19%;
        }

        .report .workstation {
            width: 14%;
        }

        .report .event {
            width: 14%;
        }

        .report .result {
            width: 12%;
        }

        .report .reason {
            width: 21%;
        }

        .empty {
            padding: 18px !important;
            color: #64748b !important;
            text-align: center;
        }

        .footer {
            position: fixed;
            right: 0;
            bottom: -8mm;
            left: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
            color: #64748b;
            font-size: 7px;
            text-align: center;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="brand">Access Control Division</div>
        <h1>Workstation Access Report</h1>
        <div class="subtitle">Detailed audit record of workstation access activity</div>
    </header>

    <table class="meta">
        <tr>
            <td>
                <span class="meta-label">Generated</span>
                <span class="meta-value">{{ $generatedAt->format('F d, Y h:i A') }}</span>
            </td>
            <td>
                <span class="meta-label">Records</span>
                <span class="meta-value">{{ number_format($logs->count()) }}</span>
            </td>
            <td>
                <span class="meta-label">Date From</span>
                <span class="meta-value">{{ $filters['date_from'] ?? 'All dates' }}</span>
            </td>
            <td>
                <span class="meta-label">Date To</span>
                <span class="meta-value">{{ $filters['date_to'] ?? 'All dates' }}</span>
            </td>
        </tr>
    </table>

    <p class="summary">
        Applied filters:
        Course: {{ $filters['course'] ?? 'All' }} |
        Workstation: {{ $filters['workstation'] ?? 'All' }} |
        Event: {{ $filters['event'] ?? 'All' }} |
        Result: {{ $filters['result'] ?? 'All' }} |
        Reason: {{ $filters['reason'] ?? 'All' }}
    </p>

    <table class="report">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="date">Date &amp; Time</th>
                <th class="course">Course</th>
                <th class="workstation">Workstation</th>
                <th class="event">Event</th>
                <th class="result">Result</th>
                <th class="reason">Reason</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->occurred_at }}</td>
                    <td>{{ $log->course ?: '-' }}</td>
                    <td>{{ $log->workstation ?: '-' }}</td>
                    <td>{{ $log->event_type ?: '-' }}</td>
                    <td>{{ $log->result ?: '-' }}</td>
                    <td>{{ $log->reason ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">No access logs matched the selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Confidential access control record &nbsp;|&nbsp; Generated {{ $generatedAt->format('Y-m-d H:i') }} &nbsp;|&nbsp; Page <span class="page-number"></span>
    </div>
</body>
</html>
