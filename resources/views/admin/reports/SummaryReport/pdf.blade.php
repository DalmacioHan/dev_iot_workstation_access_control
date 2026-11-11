<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { box-sizing: border-box; }
        body {
            color: #1e293b;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }
        .report-header {
            border-bottom: 2px solid #2563eb;
            margin-bottom: 16px;
            padding-bottom: 12px;
        }
        .label {
            color: #2563eb;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        h1 {
            color: #0f172a;
            font-size: 18px;
            margin: 5px 0;
        }
        .description {
            color: #64748b;
            font-size: 9px;
        }
        .summary {
            border-collapse: collapse;
            margin-bottom: 14px;
            width: 100%;
        }
        .summary td {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px;
        }
        .summary-label {
            color: #64748b;
            display: block;
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .summary-value {
            color: #0f172a;
            display: block;
            font-size: 10px;
            font-weight: 700;
            margin-top: 3px;
        }
        table.data-table {
            border-collapse: collapse;
            width: 100%;
        }
        .data-table th {
            background: #1e3a8a;
            color: #fff;
            font-size: 7px;
            padding: 7px 5px;
            text-align: left;
            text-transform: uppercase;
        }
        .data-table td {
            border: 1px solid #e2e8f0;
            font-size: 8px;
            padding: 6px 5px;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) { background: #f8fafc; }
        .number { text-align: center; width: 25px; }
        .student { font-weight: 700; }
        .muted { color: #64748b; }
        .empty { padding: 14px !important; text-align: center; }
        .note {
            color: #64748b;
            font-size: 8px;
            margin-top: 14px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <div class="label">Student Summary Report</div>
        <h1>Workstation Access Summary</h1>
        <div class="description">
            Summarized student access activity for {{ $periodLabel }}.
        </div>
    </div>

    <table class="summary">
        <tr>
            <td>
                <span class="summary-label">Students</span>
                <span class="summary-value">{{ number_format($students->count()) }}</span>
            </td>
            <td>
                <span class="summary-label">Date Range</span>
                <span class="summary-value">{{ $periodLabel }}</span>
            </td>
            <td>
                <span class="summary-label">Generated</span>
                <span class="summary-value">{{ $generatedAt->format('M d, Y h:i A') }}</span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="number">No.</th>
                <th>Student</th>
                <th>Student ID</th>
                <th>Course</th>
                <th>Allowed</th>
                <th>Sessions</th>
                <th>Workstations</th>
                <th>First Access</th>
                <th>Last Access</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $index => $student)
                <tr>
                    <td class="number">{{ $index + 1 }}</td>
                    <td class="student">{{ $student->student_name ?: 'Unknown Student' }}</td>
                    <td>{{ $student->student_external_id }}</td>
                    <td>{{ $student->course ?: '—' }}</td>
                    <td>{{ number_format($student->allowed_accesses) }}</td>
                    <td>{{ number_format($student->total_sessions) }}</td>
                    <td>{{ number_format($student->workstations_used) }}</td>
                    <td class="muted">
                        {{ $student->first_access ? \Carbon\Carbon::parse($student->first_access)->format('M d, Y h:i A') : '—' }}
                    </td>
                    <td class="muted">
                        {{ $student->last_access ? \Carbon\Carbon::parse($student->last_access)->format('M d, Y h:i A') : '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="10">No student access records were found for the selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="note">
        This document was generated automatically by the Workstation Access Control System.
    </div>
</body>
</html>
