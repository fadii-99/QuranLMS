{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.teacher')

@section('title','Student Dashboard')

@section('content')
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
      Student Dashboard
    </h1>
    <span class="text-sm text-gray-500 dark:text-gray-400">
      Welcome back, {{ auth()->user()->name }}
    </span>
  </div>

  {{-- Overview Card --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    {{-- Note: Use $attendancePercentage . '%' if percentage is needed --}}
    @php
      $cards = [
        [
          'label' => 'My Attendance',
          'count' => $attendanceCount,
          'icon' => 'fas fa-clipboard-check',
          'bg'   => 'from-green-500 to-green-600'
        ]
      ];
    @endphp

    @foreach($cards as $c)
      <div class="group block rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition">
        <div class="h-2 bg-gradient-to-r {{ $c['bg'] }}"></div>
        <div class="bg-white dark:bg-gray-800 p-6 flex items-center space-x-4">
          <div class="p-3 rounded-full bg-gradient-to-br {{ $c['bg'] }} text-white">
            <i class="{{ $c['icon'] }} text-xl"></i>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">{{ $c['label'] }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $c['count'] }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Current Class Box --}}
  @php
    // This should come from backend controller/service
    $currentClass = (object)[
      'id' => 1,
      'title' => 'Introduction to Quran',
      'status' => 'Live',
      'subject' => 'Quran Recitation',
      'teacher' => (object)['name' => 'Sheikh Abdullah'],
      'start_time' => now(),
      'duration' => 45,
      'classroom' => 'Virtual Room 1'
    ];
  @endphp

  @if($currentClass)
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden mb-10 transition-all duration-300 hover:shadow-xl">
      {{-- Header Section with Enhanced Visual Hierarchy --}}
      <div class="bg-gradient-to-r from-primary/90 to-primary px-6 py-5 flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-white">
        Current Class
        </h2>
        <p class="text-white/90 mt-1 font-medium">
        {{ $currentClass->title }}
        </p>
      </div>
      <span class="px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm
        {{ $currentClass->status == 'ongoing'   ? 'bg-green-500/20 text-white border border-green-400'  : '' }}
        {{ $currentClass->status == 'upcoming'  ? 'bg-yellow-500/20 text-white border border-yellow-400' : '' }}
        {{ $currentClass->status == 'ended'     ? 'bg-red-500/20 text-white border border-red-400'     : '' }}"
      >
        {{ ucfirst($currentClass->status) }}
      </span>
      </div>

      {{-- Content Section with Better Information Architecture --}}
      <div class="px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
      <div class="space-y-4">
        {{-- Class Details with Icons --}}
        <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center space-x-3 text-gray-700 dark:text-gray-300">
          <i class="fas fa-book-open text-primary"></i>
          <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Subject</p>
          <p class="font-medium">{{ $currentClass->subject ?? '-' }}</p>
          </div>
        </div>
        <div class="flex items-center space-x-3 text-gray-700 dark:text-gray-300">
          <i class="fas fa-user-tie text-primary"></i>
          <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Teacher</p>
          <p class="font-medium">{{ $currentClass->teacher->name ?? '-' }}</p>
          </div>
        </div>
        <div class="flex items-center space-x-3 text-gray-700 dark:text-gray-300">
          <i class="fas fa-clock text-primary"></i>
          <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
          <p class="font-medium">{{ \Carbon\Carbon::parse($currentClass->start_time)->format('h:i A') }}</p>
          </div>
        </div>
        <div class="flex items-center space-x-3 text-gray-700 dark:text-gray-300">
          <i class="fas fa-hourglass-half text-primary"></i>
          <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
          <p class="font-medium">{{ $currentClass->duration ?? '-' }} mins</p>
          </div>
        </div>
        </div>
        
      </div>

      {{-- Action Button --}}
      <div class="sm:self-center">
        @if($currentClass->status === 'Live')
        <a href="" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-primary/50">
          <i class="fas fa-video mr-2"></i>
          Join Class
        </a>
        @else
        <div class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg font-medium">
          <i class="fas fa-clock mr-2"></i>
          <span>Class not live yet</span>
        </div>
        @endif
      </div>
      </div>
    </div>
  @else
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-8 text-center text-gray-500 dark:text-gray-400">
      No current class scheduled.
    </div>
  @endif

@endsection
