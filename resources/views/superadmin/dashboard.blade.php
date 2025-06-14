{{-- resources/views/superadmin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')

@section('content')
  <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4" data-aos="fade-down">
    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Super Admin Dashboard</h1>
    <div class="flex items-center space-x-4">
      <span class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-600 px-3 py-1 rounded-full">Welcome, Super Admin</span>
    </div>
  </div>

  {{-- Overview Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    @php
      $cards = [
        ['label'=>'Admins', 'count'=>$totalAdmins , 'icon'=>'fas fa-users-cog ','bg'=>'from-green-500 to-green-600'],
        ['label'=>'Teachers', 'count'=>$totalTeachers,'icon'=>'fas fa-chalkboard-teacher ','bg'=>'from-red-500 to-red-600'],
        ['label'=>'Students', 'count'=>$totalStudents, 'icon'=>'fas fa-user-graduate ',      'bg'=>'from-yellow-500 to-yellow-600'],
        ['label'=>'Pending Payments',  'count'=>$pendingPayments,  'icon'=>'fas fa-money-check-alt ',             'bg'=>'from-blue-500 to-blue-600'],
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

  {{-- Pending Payments and Recent Activity --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    {{-- Pending Payments List --}}
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6" data-aos="fade-right">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 tracking-tight">Pending Admin Payments</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
          <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
            <tr>
              <th class="px-6 py-3">Admin Name</th>
              <th class="px-6 py-3">Amount</th>
              <th class="px-6 py-3">Due Date</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pendingPaymentsList as $index => $payment)
              <tr class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-600/50' : 'bg-white dark:bg-gray-700' }} border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <td class="px-6 py-4 font-medium">{{ $payment['name'] }}</td>
                <td class="px-6 py-4">{{ $payment['amount'] }}</td>
                <td class="px-6 py-4">{{ $payment['due_date'] }}</td>
                <td class="px-6 py-4">
                  <a href="#" class="inline-block bg-primary text-white px-3 py-1 rounded-full hover:bg-primary-dark transition-colors text-xs font-medium">Process</a>
                </td>
              </tr>
            @empty
                <tr>
                <td colspan="4" class="px-6 py-4">
                  <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                  <i class="fas fa-money-bill-wave text-4xl mb-2"></i>
                  <p class="font-medium">No pending payments</p>
                  <p class="text-sm">All payments are up to date</p>
                  </div>
                </td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Recent Activity Log --}}
    {{-- <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6" data-aos="fade-left">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 tracking-tight">Recent Activity</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
          <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
            <tr>
              <th class="px-6 py-3">Action</th>
              <th class="px-6 py-3">User</th>
              <th class="px-6 py-3">Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentActivity as $index => $log)
              <tr class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-600/50' : 'bg-white dark:bg-gray-700' }} border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <td class="px-6 py-4 font-medium">{{ $log['action'] }}</td>
                <td class="px-6 py-4">{{ $log['user'] }}</td>
                <td class="px-6 py-4">{{ $log['date'] }}</td>
              </tr>
            @empty
                <tr>
                <td colspan="3" class="px-6 py-4">
                  <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                  <i class="fas fa-history text-4xl mb-2"></i>
                  <p class="font-medium">No Recent Activity</p>
                  <p class="text-sm">Activity logs will appear here</p>
                  </div>
                </td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div> --}}

    {{-- Pending Requests Table --}}
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6" data-aos="fade-right">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 tracking-tight">
                latest Pending Requests
            </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-4">Sender</th>
                        <th class="px-6 py-4">Subject</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($requests as $item)
                        <tr class="border-t border-gray-200 dark:border-gray-600">
                            <td class="px-4 py-2 whitespace-nowrap w-1/6">{{ $item->user->academy_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap w-1/6">{{ $item->subject }}</td>
                            <td class="px-4 py-2 whitespace-nowrap w-1/6">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $item->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $item->status == 'completed' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $item->status == 'canceled' ? 'bg-red-200 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2 whitespace-nowrap w-1/6">
                                <a href="{{ route('superadmin.request.index', ['view_id' => $item->id]) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                                    Go to Message
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                                    </svg>
                                    <span class="text-gray-500 dark:text-gray-400 text-lg font-medium">No pending
                                        requests.</span>
                                    <span class="text-gray-400 dark:text-gray-500 text-sm">All teacher requests have been
                                        reviewed.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
   
@endsection