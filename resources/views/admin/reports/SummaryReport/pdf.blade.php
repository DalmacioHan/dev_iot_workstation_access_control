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
            padding: 0;
            background: #ffffff;
        }
        .report-header {
            border-bottom: 2px solid #2563eb;
            margin-bottom: 14px;
            padding-bottom: 10px;
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
            font-size: 17px;
            margin: 4px 0;
        }
        .description {
            color: #64748b;
            font-size: 8.5px;
        }
        .summary {
            border-collapse: collapse;
            margin-bottom: 14px;
            width: 100%;
        }
        .summary td {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
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
            margin-top: 2px;
        }

        /* =========================================================
            ANALYTICS & HIGHLIGHTS
        ========================================================== */
        .analytics-wrapper {
            margin-bottom: 16px;
            page-break-inside: avoid;
            width: 100%;
        }
        .analytics-table {
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-left: -10px;
            margin-right: -10px;
            width: calc(100% + 20px);
        }
        .analytics-col {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 9px;
            vertical-align: top;
        }
        .col-left {
            width: 44%;
        }
        .col-right {
            width: 56%;
        }
        .section-title {
            color: #1e3a8a;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0 0 8px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
        }

        /* Donut Chart Layout */
        .donut-layout {
            width: 100%;
            border-collapse: collapse;
        }
        .donut-cell {
            text-align: center;
            vertical-align: middle;
            width: 110px;
        }
        .legend-cell {
            padding-left: 6px;
            vertical-align: middle;
        }
        .legend-table {
            border-collapse: collapse;
            width: 100%;
        }
        .legend-row td {
            font-size: 6.8px;
            padding: 2px 0;
            vertical-align: top;
        }
        .legend-dot-col {
            padding-right: 4px !important;
            padding-top: 2.5px !important;
            vertical-align: top !important;
            width: 8px;
        }
        .legend-dot {
            border-radius: 50%;
            display: block;
            height: 5.5px;
            width: 5.5px;
        }
        .legend-course-col {
            color: #334155;
            font-weight: 600;
            line-height: 1.25;
            padding-right: 4px !important;
            vertical-align: top !important;
        }
        .legend-course-text {
            display: inline;
            word-break: normal;
        }
        .legend-count-col {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            white-space: nowrap;
            vertical-align: top !important;
            padding-top: 1px !important;
        }

        /* Leaderboards Grid (2x2) */
        .lb-grid {
            border-collapse: separate;
            border-spacing: 6px 6px;
            margin: -6px;
            width: calc(100% + 12px);
        }
        .lb-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 6px 7px;
            vertical-align: top;
            width: 50%;
        }
        .lb-title {
            color: #0f172a;
            font-size: 7.2px;
            font-weight: 700;
            margin-bottom: 4px;
            padding-bottom: 3px;
            border-bottom: 1px solid #cbd5e1;
        }
        .lb-subtitle {
            color: #2563eb;
            font-size: 6.2px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .lb-list {
            border-collapse: collapse;
            width: 100%;
        }
        .lb-item td {
            font-size: 6.8px;
            padding: 2.5px 0;
            border-bottom: 1px dotted #e2e8f0;
        }
        .lb-item:last-child td {
            border-bottom: none;
        }
        .rank-badge {
            border-radius: 3px;
            display: inline-block;
            font-size: 6.5px;
            font-weight: 800;
            height: 12px;
            line-height: 12px;
            text-align: center;
            width: 12px;
            margin-right: 3px;
        }
        .rank-1 { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .rank-2 { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
        .rank-3 { background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa; }

        .name-cell {
            color: #1e293b;
            font-weight: 600;
            max-width: 95px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .val-pill {
            border-radius: 3px;
            font-size: 6.2px;
            font-weight: 700;
            padding: 1px 3px;
            text-align: right;
            white-space: nowrap;
        }
        .val-amber { background: #fffbeb; color: #b45309; }
        .val-emerald { background: #ecfdf5; color: #047857; }
        .val-blue { background: #eff6ff; color: #1d4ed8; }
        .val-purple { background: #faf5ff; color: #6b21a8; }

        /* Data Table */
        table.data-table {
            border-collapse: collapse;
            margin-top: 10px;
            width: 100%;
        }
        .data-table th {
            background: #1e3a8a;
            color: #fff;
            font-size: 7px;
            padding: 6px 5px;
            text-align: left;
            text-transform: uppercase;
        }
        .data-table td {
            border: 1px solid #e2e8f0;
            font-size: 7.5px;
            padding: 5px 5px;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) { background: #f8fafc; }
        .number { text-align: center; width: 25px; }
        .student { font-weight: 700; }
        .muted { color: #64748b; }
        .empty { padding: 14px !important; text-align: center; }
        .note {
            color: #64748b;
            font-size: 7.5px;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <div class="label">Student Summary Report</div>
        <h1>Workstation Access Summary</h1>
        <div class="description">
            Summarized student access activity and analytical overview for {{ $periodLabel }}.
        </div>
    </div>

    {{-- Top Metrics Overview --}}
    <table class="summary">
        <tr>
            <td>
                <span class="summary-label">Students Recorded</span>
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

    {{-- =========================================================
        ANALYTICS: COURSE DISTRIBUTION PIE & TOP 3 HIGHLIGHTS
    ========================================================== --}}
    @php
        $pieCounts = $chartCourseCounts ?? [];
        $pieLabels = $chartCourseLabels ?? [];
        $pieColors = $chartCourseColors ?? ['#1d4ed8', '#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#cbd5e1'];
        $piePercentages = $chartCoursePercentages ?? [];
        $pieTotal = array_sum($pieCounts);

        $size = 104;
        $cx = 52;
        $cy = 52;
        $outerR = 43;
        $innerR = 26;
        $svgPaths = [];

        if ($pieTotal > 0) {
            if (count($pieCounts) === 1) {
                $c = $pieColors[0];
                $svgPaths[] = "<circle cx='{$cx}' cy='{$cy}' r='{$outerR}' fill='{$c}' />"
                            . "<circle cx='{$cx}' cy='{$cy}' r='{$innerR}' fill='#ffffff' />";
            } else {
                $currentAngle = -M_PI / 2;
                foreach ($pieCounts as $i => $count) {
                    if ($count <= 0) continue;
                    $fraction = $count / $pieTotal;
                    $angleSpan = $fraction * 2 * M_PI;
                    $endAngle = $currentAngle + $angleSpan;
                    $color = $pieColors[$i % count($pieColors)];

                    $x1 = round($cx + $outerR * cos($currentAngle), 2);
                    $y1 = round($cy + $outerR * sin($currentAngle), 2);
                    $x2 = round($cx + $outerR * cos($endAngle), 2);
                    $y2 = round($cy + $outerR * sin($endAngle), 2);

                    $x3 = round($cx + $innerR * cos($endAngle), 2);
                    $y3 = round($cy + $innerR * sin($endAngle), 2);
                    $x4 = round($cx + $innerR * cos($currentAngle), 2);
                    $y4 = round($cy + $innerR * sin($currentAngle), 2);

                    $largeArc = ($angleSpan > M_PI) ? 1 : 0;
                    $d = "M {$x1} {$y1} A {$outerR} {$outerR} 0 {$largeArc} 1 {$x2} {$y2} L {$x3} {$y3} A {$innerR} {$innerR} 0 {$largeArc} 0 {$x4} {$y4} Z";
                    $svgPaths[] = "<path d='{$d}' fill='{$color}' stroke='#ffffff' stroke-width='1.2' />";
                    $currentAngle = $endAngle;
                }
            }
        }
    @endphp

    <div class="analytics-wrapper">
        <table class="analytics-table">
            <tr>
                {{-- LEFT COLUMN: Overall Course Distribution (Pie Graph) --}}
                <td class="analytics-col col-left">
                    <div class="section-title">Course Distribution (Overview)</div>

                    @if ($pieTotal > 0)
                        <table class="donut-layout">
                            <tr>
                                <td class="donut-cell">
                                    <svg viewBox="0 0 {{ $size }} {{ $size }}" width="{{ $size }}" height="{{ $size }}">
                                        {!! implode('', $svgPaths) !!}
                                        <text x="{{ $cx }}" y="{{ $cy - 2 }}" text-anchor="middle" font-size="11" font-weight="bold" fill="#0f172a">{{ number_format($pieTotal) }}</text>
                                        <text x="{{ $cx }}" y="{{ $cy + 7 }}" text-anchor="middle" font-size="5.5" fill="#64748b" text-transform="uppercase">Students</text>
                                    </svg>
                                </td>
                                <td class="legend-cell">
                                    <table class="legend-table">
                                        @foreach ($pieLabels as $idx => $label)
                                            @php
                                                $color = $pieColors[$idx % count($pieColors)] ?? '#3b82f6';
                                                $count = $pieCounts[$idx] ?? 0;
                                                $pct = $piePercentages[$idx] ?? 0;
                                            @endphp
                                            <tr class="legend-row">
                                                <td class="legend-dot-col">
                                                    <span class="legend-dot" style="background-color: {{ $color }};"></span>
                                                </td>
                                                <td class="legend-course-col">
                                                    <span class="legend-course-text">{{ $label }}</span>
                                                </td>
                                                <td class="legend-count-col">
                                                    {{ number_format($count) }} <span style="color: #94a3b8; font-weight: normal;">({{ $pct }}%)</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>
                    @else
                        <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 8px;">
                            No course distribution data available for this report.
                        </div>
                    @endif
                </td>

                {{-- RIGHT COLUMN: 4 Leaderboards (Top 3 Students & Top 3 Courses) --}}
                <td class="analytics-col col-right">
                    <div class="section-title">Top Performers & Activity Highlights</div>

                    <table class="lb-grid">
                        <tr>
                            {{-- Top 3 Students (Logins) --}}
                            <td class="lb-box">
                                <div class="lb-title">
                                    Top Students
                                    <span class="lb-subtitle">· Logins</span>
                                </div>
                                <table class="lb-list">
                                    @forelse ($topStudentsByLogins ?? [] as $i => $s)
                                        <tr class="lb-item">
                                            <td style="width: 14px;">
                                                <span class="rank-badge rank-{{ $i + 1 }}">#{{ $i + 1 }}</span>
                                            </td>
                                            <td class="name-cell" title="{{ $s->student_name }}">
                                                {{ $s->student_name ?: 'Unknown' }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span class="val-pill val-amber">{{ number_format($s->login_count) }} log</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="lb-item">
                                            <td colspan="3" style="color: #94a3b8; font-size: 6.5px; text-align: center; padding: 6px 0;">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </td>

                            {{-- Top 3 Students (Usage Time) --}}
                            <td class="lb-box">
                                <div class="lb-title">
                                    Top Students
                                    <span class="lb-subtitle" style="color: #059669;">· Usage Time</span>
                                </div>
                                <table class="lb-list">
                                    @forelse ($topStudentsByTime ?? [] as $i => $s)
                                        <tr class="lb-item">
                                            <td style="width: 14px;">
                                                <span class="rank-badge rank-{{ $i + 1 }}">#{{ $i + 1 }}</span>
                                            </td>
                                            <td class="name-cell" title="{{ $s->student_name }}">
                                                {{ $s->student_name ?: 'Unknown' }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span class="val-pill val-emerald">{{ $s->formatted_time }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="lb-item">
                                            <td colspan="3" style="color: #94a3b8; font-size: 6.5px; text-align: center; padding: 6px 0;">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </td>
                        </tr>

                        <tr>
                            {{-- Top 3 Courses (Logins) --}}
                            <td class="lb-box">
                                <div class="lb-title">
                                    Top Courses
                                    <span class="lb-subtitle">· Logins</span>
                                </div>
                                <table class="lb-list">
                                    @forelse ($topCoursesByLogins ?? [] as $i => $c)
                                        <tr class="lb-item">
                                            <td style="width: 14px;">
                                                <span class="rank-badge rank-{{ $i + 1 }}">#{{ $i + 1 }}</span>
                                            </td>
                                            <td class="name-cell" title="{{ $c->course }}">
                                                {{ $c->course }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span class="val-pill val-blue">{{ number_format($c->login_count) }} log</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="lb-item">
                                            <td colspan="3" style="color: #94a3b8; font-size: 6.5px; text-align: center; padding: 6px 0;">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </td>

                            {{-- Top 3 Courses (Usage Time) --}}
                            <td class="lb-box">
                                <div class="lb-title">
                                    Top Courses
                                    <span class="lb-subtitle" style="color: #7c3aed;">· Usage Time</span>
                                </div>
                                <table class="lb-list">
                                    @forelse ($topCoursesByTime ?? [] as $i => $c)
                                        <tr class="lb-item">
                                            <td style="width: 14px;">
                                                <span class="rank-badge rank-{{ $i + 1 }}">#{{ $i + 1 }}</span>
                                            </td>
                                            <td class="name-cell" title="{{ $c->course }}">
                                                {{ $c->course }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span class="val-pill val-purple">{{ $c->formatted_time }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="lb-item">
                                            <td colspan="3" style="color: #94a3b8; font-size: 6.5px; text-align: center; padding: 6px 0;">
                                                No records
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- =========================================================
        DETAILED STUDENT SUMMARY TABLE
    ========================================================== --}}
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
