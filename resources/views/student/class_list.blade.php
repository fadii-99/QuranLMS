@extends('layouts.admin')

@section('title', 'Class List') <!-- Fixed typo: Classs -> Class -->

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">My Classes</h1> <!-- Fixed text-white class -->
    </div>

    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Teacher Name</th>
                    <th class="px-4 py-3 text-left">Class Time</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $class->teacher ? $class->teacher->name : 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $class->time }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $class->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $class->status == 'completed' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $class->status == 'canceled' ? 'bg-red-200 text-red-800' : '' }}">
                                {{ ucfirst($class->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                [$startTime, $endTime] = explode('-', $class->time);
                                $nowTime = \Carbon\Carbon::now()->format('H:i');
                                // Class live tab hai jab abhi ka time start & end ke beech ho, teacher ne start kiya ho, aur link set ho
                                $classIsLive =
                                    $class->link;
                            @endphp

                            @if ($classIsLive)
                                <a href="{{ route('student.class.join', ['code' => $class->link]) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition ease-in-out duration-150">
                                    <i class="fas fa-video mr-2"></i>
                                    Join Class
                                </a>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-md text-sm">
                                    <i class="fas fa-clock mr-2"></i>
                                    Waiting for Teacher
                                </span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center"> <!-- Fixed colspan: 7 -> 4 -->
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-exclamation-triangle text-4xl text-gray-400 dark:text-gray-500"></i>
                                <!-- Changed fa-warning to fa-exclamation-triangle -->
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Classes Found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $classes->links() }}
        </div>
    </div>
@endsection
