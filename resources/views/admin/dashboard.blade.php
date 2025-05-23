@extends('layouts.admin')

@section('title','Admin Dashboard')

@section('content')
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
      Admin Dashboard
    </h1>
    <span class="text-sm text-gray-500 dark:text-gray-400">
      Welcome back, {{ auth()->user()->name }}
    </span>
  </div>

  {{-- Overview Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    @php
      $cards = [
        ['label'=>'Teachers', 'count'=>$teachers, 'icon'=>'fas fa-chalkboard-teacher','bg'=>'from-green-500 to-green-600'],
        ['label'=>'Students', 'count'=>$students, 'icon'=>'fas fa-user-graduate',      'bg'=>'from-yellow-500 to-yellow-600'],
        ['label'=>'Requests', 'count'=>$requests->count(),'icon'=>'fas fa-question-circle','bg'=>'from-red-500 to-red-600'],
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

  {{-- Pending Requests Table --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
        Pending Teacher Requests
      </h2>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700">
          <tr>
        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Teacher</th>
        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Request</th>
        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Date</th>
        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
        $dummyRequests = [
          ['name' => 'John Doe', 'type' => 'new_class', 'created_at' => now()->subDays(2)],
          ['name' => 'Jane Smith', 'type' => 'schedule_change', 'created_at' => now()->subDays(1)],
          ['name' => 'Mike Johnson', 'type' => 'leave_request', 'created_at' => now()->subHours(5)],
        ];
          @endphp

          @forelse($dummyRequests as $i => $r)
        <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-700' }}">
          <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
            {{ $r['name'] }}
          </td>
          <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
            {{ ucfirst(str_replace('_',' ',$r['type'])) }}
          </td>
          <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
            {{ $r['created_at']->diffForHumans() }}
          </td>
          <td class="px-6 py-4">
            <a href="#"
           class="px-3 py-1 bg-primary text-white rounded-lg hover:bg-primary/90 transition text-sm">
          View
            </a>
          </td>
        </tr>
          @empty
        <tr>
          <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
            No pending requests.
          </td>
        </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
