{{-- resources/views/superadmin/recent_activity.blade.php --}}
@extends('layouts.superadmin')

@section('title', 'Recent Activity')

@section('content')
  <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4" data-aos="fade-down">
    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Recent Activity</h1>
  </div>

  {{-- Summary Card --}}
  <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 mb-10 hover:shadow-xl transition-transform duration-300 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-600 dark:to-gray-700" 
       data-aos="fade-up" data-aos-delay="100">
    <div class="flex items-center">
      <i class="fas fa-history text-4xl text-primary dark:text-white mr-4"></i>
      <div>
        <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Total Activities</p>
        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">25</p>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Last 30 days</p>
      </div>
    </div>
  </div>

  {{-- Activity Filters --}}
  <div class="flex items-center justify-between mb-6" data-aos="fade-up">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">Activity Log</h2>
    <div class="flex space-x-2">
      <button class="px-4 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors text-sm font-medium">All</button>
      <button class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm font-medium">Today</button>
      <button class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm font-medium">This Week</button>
    </div>
  </div>

  {{-- Activity Table --}}
  <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6" data-aos="fade-up">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
          <tr>
            <th class="px-6 py-3">Action</th>
            <th class="px-6 py-3">User</th>
            <th class="px-6 py-3">Date</th>
            <th class="px-6 py-3">Description</th>
          </tr>
        </thead>
        <tbody>
          @php
            $dummyLogs = [
              ['action' => 'Added new teacher', 'user' => 'Ahmed Khan', 'date' => 'May 07, 2025 10:00 AM', 'description' => 'Added teacher Bilal Noor to Al-Noor Academy'],
              ['action' => 'Approved course', 'user' => 'Fatima Ali', 'date' => 'May 07, 2025 08:30 AM', 'description' => 'Approved Tajweed Advanced course'],
              ['action' => 'New student registered', 'user' => 'System', 'date' => 'May 06, 2025 03:15 PM', 'description' => 'Maryam Zainab registered as student'],
              ['action' => 'Updated course', 'user' => 'Yusuf Rahman', 'date' => 'May 05, 2025 11:45 AM', 'description' => 'Updated Quran Tafsir course details'],
              ['action' => 'Processed payment', 'user' => 'Aisha Siddiqa', 'date' => 'May 04, 2025 09:20 AM', 'description' => 'Processed PKR 55,000 for admin'],
            ];
          @endphp
          @forelse ($dummyLogs as $index => $log)
            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-600/50' : 'bg-white dark:bg-gray-700' }} border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
              <td class="px-6 py-4 font-medium">{{ $log['action'] }}</td>
              <td class="px-6 py-4">{{ $log['user'] }}</td>
              <td class="px-6 py-4">{{ $log['date'] }}</td>
              <td class="px-6 py-4">{{ $log['description'] }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No recent activity</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection