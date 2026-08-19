@extends('layout.app')

@section('title','Analytics')

@php
    $controlHeight = 'h-[52px]';
@endphp

@section('content')
    <!--card-->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-12 mb-4">
        <!-- POPULAR WORKSTATION -->
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-yellow-300 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </div>
                <div class="text-right ms-3">
                    <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">{{ $popularWorkstation ? $popularWorkstation->workstation->pc_code : 'N/A' }}</div>
                    <div class="mt-1 text-sm text-body">Popular Workstation</div>
                </div>
            </div>
        </div>
        <!-- TOTAL ACCESS EVENTS -->
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                    </svg>
                </div>
                <div class="text-right ms-3">
                    <div class="text-3xl font-semibold text-heading leading-none" id="total-access-events">{{ $totalEvents }}</div>
                    <div class="mt-1 text-sm text-body">Access Events</div>
                </div>
            </div>
        </div>
        <!-- TOTAL FAILED ACCESS EVENTS -->
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-[25px] h-[25px] text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <div class="text-right ms-3">
                    <div class="text-3xl font-semibold text-heading leading-none" id="total-failed-attempts">{{ $failedEvents }}</div>
                    <div class="mt-1 text-sm text-body">Failed Access Events</div>
                </div>
            </div>
        </div>

    </div>
    <!--table-->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-12 mb-2">
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <p class="text-base font-bold  text-black text-center uppercase">Top 10 Students</p>
        </div>
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <p class=" text-base font-bold  text-black text-center uppercase">Top 10 Courses</p>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-12 mb-4">
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="relative overflow-x-auto ">
                <table class="w-full text-left text-sm text-gray-700 ">
                    <thead class="bg-white uppercase text-black border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-5 py-5">#</th>
                            <th scope="col" class="px-5 py-5">Student Name</th>
                            <th scope="col" class="px-5 py-5 text-center">Access</th>
                        </tr>
                        <tbody>
                            @foreach($topStudents as $index => $student)
                                <tr class="border-b border-gray-200">
                                    <td class="px-5 py-5">{{ $index + 1 }}</td>
                                    <td class="px-5 py-5">{{ $student->student_name }}</td>
                                    <td class="px-5 py-5 text-center">{{ $student->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="relative overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-white uppercase text-black border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-5 py-5">#</th>
                            <th scope="col" class="px-5 py-2">Course Name</th>
                            <th scope="col" class="px-5 py-5 text-center">Access</th>
                        </tr>
                        <tbody>
                            @foreach($topCourses as $index => $course)
                                <tr class="border-b border-gray-200">
                                    <td class="px-5 py-5">{{ $index + 1 }}</td>
                                    <td class="px-5 py-2">{{ $course->course }}</td>
                                    <td class="px-5 py-5 text-center">{{ $course->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
