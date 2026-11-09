<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>

        * {
            box-sizing: border-box;
        }


        body {
            font-family: Arial, Helvetica, sans-serif;

            color: #1e293b;

            margin: 0;

            padding: 0;

            background: #ffffff;
        }


        /* =========================================================
            MAIN CONTENT
        ========================================================== */

        .main-content {
            width: 100%;
        }


        /* =========================================================
            REPORT HEADER
        ========================================================== */

        .report-header {
            margin-bottom: 18px;

            padding-bottom: 14px;

            border-bottom: 2px solid #2563eb;
        }


        .report-label {
            margin-bottom: 4px;

            font-size: 8px;

            font-weight: 700;

            color: #2563eb;

            text-transform: uppercase;

            letter-spacing: 1.4px;
        }


        .report-title {
            margin: 0;

            font-size: 18px;

            font-weight: 700;

            color: #0f172a;

            line-height: 1.25;
        }


        .report-description {
            margin-top: 5px;

            max-width: 520px;

            font-size: 9px;

            line-height: 1.5;

            color: #64748b;
        }


        /* =========================================================
            REPORT SUMMARY
        ========================================================== */

        .report-summary {
            width: 100%;

            margin-bottom: 16px;

            border-collapse: separate;

            border-spacing: 6px 0;
        }


        .report-summary td {
            width: 33.333%;

            padding: 10px 12px;

            background-color: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 6px;
        }


        .summary-label {
            display: block;

            margin-bottom: 4px;

            font-size: 7.5px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .7px;

            color: #94a3b8;
        }


        .summary-value {
            display: block;

            font-size: 10px;

            font-weight: 700;

            color: #334155;
        }


        /* =========================================================
            DATA TABLE
        ========================================================== */

        table.data-table {
            width: 100%;

            border-collapse: collapse;

            table-layout: auto;
        }


        table.data-table thead {
            display: table-header-group;
        }


        table.data-table tr {
            page-break-inside: avoid;
        }


        table.data-table th {
            padding: 8px 7px;

            background-color: #1e3a8a;

            border: 1px solid #1e3a8a;

            color: #ffffff;

            font-size: 8px;

            font-weight: 700;

            text-align: left;

            text-transform: uppercase;

            letter-spacing: .5px;

            white-space: nowrap;
        }


        table.data-table td {
            padding: 7px;

            border: 1px solid #e2e8f0;

            color: #334155;

            font-size: 9px;

            line-height: 1.4;

            vertical-align: middle;
        }


        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }


        table.data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }


        /* =========================================================
            NUMBER COLUMN
        ========================================================== */

        table.data-table th:first-child,
        table.data-table td:first-child {
            width: 34px;

            text-align: center;
        }


        .row-number {
            font-weight: 700;

            color: #64748b;
        }


        /* =========================================================
            STUDENT
        ========================================================== */

        .student-name {
            font-weight: 700;

            color: #0f172a;
        }


        /* =========================================================
            COURSE
        ========================================================== */

        .course-text {
            font-size: 8.5px;

            font-weight: 600;

            color: #0f172a;
        }


        /* =========================================================
            WORKSTATION
        ========================================================== */

        .workstation {
            font-weight: 600;

            color: #334155;
        }


        /* =========================================================
            DATE
        ========================================================== */

        .date-time {
            white-space: nowrap;

            font-size: 8.5px;

            color: #475569;
        }


        /* =========================================================
            EVENT
        ========================================================== */

        .event-text {
            font-size: 8.5px;

            font-weight: 600;

            color: #334155;

            text-transform: capitalize;
        }


        /* =========================================================
            EMPTY STATE
        ========================================================== */

        .empty-row td {
            padding: 28px 10px !important;

            text-align: center !important;

            color: #94a3b8 !important;

            font-size: 9px !important;

            background-color: #ffffff !important;
        }


        /* =========================================================
            FOOT NOTE
        ========================================================== */

        .report-note {
            margin-top: 12px;

            padding-top: 9px;

            border-top: 1px solid #e2e8f0;

            font-size: 7.5px;

            color: #94a3b8;

            line-height: 1.5;
        }

    </style>

</head>


<body>

    <div class="main-content">

        {{-- =====================================================
            REPORT HEADER
        ====================================================== --}}
        <div class="report-header">

            <div class="report-label">
                OLH Library Management
            </div>


            <h1 class="report-title">
                Device Access Control Report
            </h1>


            <div class="report-description">
                Generated access activity report containing student,
                workstation and event records based on the selected report
                configuration.
            </div>

        </div>


        {{-- =====================================================
            REPORT SUMMARY
        ====================================================== --}}
        <table class="report-summary">

            <tr>

                <td>

                    <span class="summary-label">
                        Total Records
                    </span>

                    <span class="summary-value">
                        {{ number_format($logs->count()) }}
                    </span>

                </td>


                <td>

                    <span class="summary-label">
                        Generated Date
                    </span>

                    <span class="summary-value">
                        {{ now()->format('M d, Y') }}
                    </span>

                </td>


                <td>

                    <span class="summary-label">
                        Generated Time
                    </span>

                    <span class="summary-value">
                        {{ now()->format('h:i A') }}
                    </span>

                </td>

            </tr>

        </table>


        {{-- =====================================================
            DATA TABLE
        ====================================================== --}}
        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        No.
                    </th>


                    @if ($columns['student_name'])

                        <th>
                            Student Name
                        </th>

                    @endif


                    @if ($columns['course'])

                        <th>
                            Course
                        </th>

                    @endif


                    @if ($columns['device'])

                        <th>
                            Workstation
                        </th>

                    @endif


                    @if ($columns['date_time'])

                        <th>
                            Date & Time
                        </th>

                    @endif


                    @if ($columns['event'])

                        <th>
                            Event
                        </th>

                    @endif

                </tr>

            </thead>


            <tbody>

                @forelse ($logs as $index => $log)

                    <tr>

                        {{-- Row Number --}}
                        <td class="row-number">
                            {{ $index + 1 }}
                        </td>


                        {{-- Student Name --}}
                        @if ($columns['student_name'])

                            <td>

                                <span class="student-name">
                                    {{ $log->student_name ?: 'Unknown Student' }}
                                </span>

                            </td>

                        @endif


                        {{-- Course --}}
                        @if ($columns['course'])

                            <td>

                                @if (!empty($log->course))

                                    <span class="course-text">
                                        {{ $log->course }}
                                    </span>

                                @else

                                    <span style="color: #94a3b8;">
                                        —
                                    </span>

                                @endif

                            </td>

                        @endif


                        {{-- Workstation --}}
                        @if ($columns['device'])

                            <td>

                                <span class="workstation">
                                    {{ $log->workstation_name ?: 'N/A' }}
                                </span>

                            </td>

                        @endif


                        {{-- Date and Time --}}
                        @if ($columns['date_time'])

                            <td>

                                <span class="date-time">

                                    @if ($log->occurred_at)

                                        {{
                                            \Carbon\Carbon::parse(
                                                $log->occurred_at
                                            )->format('M d, Y h:i A')
                                        }}

                                    @else

                                        —

                                    @endif

                                </span>

                            </td>

                        @endif


                        {{-- Event --}}
                        @if ($columns['event'])

                            <td>

                                @if (!empty($log->event_type))

                                    <span class="event-text">
                                        {{
                                            ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $log->event_type
                                                )
                                            )
                                        }}
                                    </span>

                                @else

                                    <span style="color: #94a3b8;">
                                        —
                                    </span>

                                @endif

                            </td>

                        @endif

                    </tr>

                @empty

                    <tr class="empty-row">

                        <td
                            colspan="{{
                                1 +
                                ($columns['student_name'] ? 1 : 0) +
                                ($columns['course'] ? 1 : 0) +
                                ($columns['device'] ? 1 : 0) +
                                ($columns['date_time'] ? 1 : 0) +
                                ($columns['event'] ? 1 : 0)
                            }}"
                        >
                            No access records were found for the selected filters.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- =====================================================
            REPORT NOTE
        ====================================================== --}}
        <div class="report-note">

            This document was generated automatically by the OLH Library
            Management System. Access records shown in this report reflect
            the filters and columns selected at the time of generation.

        </div>

    </div>

</body>

</html>
