{{-- resources/views/teacher/dashboard.blade.php --}}
@extends('layouts.teacher') {{-- or layouts.teacher if you have one --}}

@section('title','Teacher Dashboard')

@section('content')
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
      Teacher Dashboard
    </h1>
    <span class="text-sm text-gray-500 dark:text-gray-400">
      Welcome back, {{ auth()->user()->name }}
    </span>
  </div>

  {{-- Overview Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    @php
      $cards = [
        ['label'=>'My Students',      'count'=>$students->count(),      'icon'=>'fas fa-user-friends',      'bg'=>'from-indigo-500 to-indigo-600'],
        ['label'=>'Total Classes',    'count'=>$totalClasses,  'icon'=>'fas fa-calendar-alt',      'bg'=>'from-green-500 to-green-600'],
        ['label'=>"Today's Classes",  'count'=>$classesToday,  'icon'=>'fas fa-chalkboard',         'bg'=>'from-yellow-500 to-yellow-600'],
        ['label'=>'Recent Classes',   'count'=>$recentClasses->count(), 'icon'=>'fas fa-history','bg'=>'from-blue-500 to-blue-600'],
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

  {{-- Classes Table --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
        Recent Classes
      </h2>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700">
          <tr>
            <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Title</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Scheduled At</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Status</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentClasses as $i => $class)
            <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-700' }}">
              <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                {{ $class->title }}
              </td>
              <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                dddd
              </td>
              <td class="px-6 py-4">
                <span class="px-2 py-1 rounded-full text-xs font-medium
                  {{ $class->status == 'pending'   ? 'bg-yellow-200 text-yellow-800'  : '' }}
                  {{ $class->status == 'completed' ? 'bg-green-200 text-green-800'  : '' }}
                  {{ $class->status == 'canceled'  ? 'bg-red-200 text-red-800'      : '' }}
                ">
                  {{ ucfirst($class->status) }}
                </span>
              </td>
              <td class="px-6 py-4">
                <a href=""
                   class="px-3 py-1 bg-primary text-white rounded-lg hover:bg-primary/90 transition text-sm">
                  View
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                No recent classes.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
