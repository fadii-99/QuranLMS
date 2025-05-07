{{-- resources/views/superadmin/payments.blade.php --}}
@extends('layouts.superadmin')

@section('title', 'Payments')

@section('content')
  <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4" data-aos="fade-down">
    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Payments</h1>
  </div>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-600 dark:to-gray-700" 
         data-aos="fade-up" data-aos-delay="100">
      <div class="flex items-center">
        <i class="fas fa-money-check-alt text-4xl text-red-500  mr-4"></i>
        <div>
          <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Pending Payments</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">3</p>
          <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Due this month</p>
        </div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-600 dark:to-gray-700" 
         data-aos="fade-up" data-aos-delay="200">
      <div class="flex items-center">
        <i class="fas fa-check-circle text-4xl text-green-500  mr-4"></i>
        <div>
          <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Processed Payments</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">10</p>
          <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">This month</p>
        </div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-600 dark:to-gray-700" 
         data-aos="fade-up" data-aos-delay="300">
      <div class="flex items-center">
        <i class="fas fa-wallet text-4xl text-primary  mr-4"></i>
        <div>
          <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Total Amount</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">PKR 1,550,000</p>
          <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Processed this year</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Payment Filters --}}
  <div class="flex items-center justify-between mb-6" data-aos="fade-up">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">Payment History</h2>
    <div class="flex space-x-2">
      <button class="px-4 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors text-sm font-medium">All</button>
      <button class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm font-medium">Pending</button>
      <button class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm font-medium">Processed</button>
    </div>
  </div>

  {{-- Payments Table --}}
  <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6" data-aos="fade-up">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
          <tr>
            <th class="px-6 py-3">Admin Name</th>
            <th class="px-6 py-3">Amount</th>
            <th class="px-6 py-3">Date</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
            $dummyPayments = [
              ['name' => 'Ahmed Khan', 'amount' => 'PKR 50,000', 'date' => 'May 15, 2025', 'status' => 'Pending'],
              ['name' => 'Fatima Ali', 'amount' => 'PKR 45,000', 'date' => 'May 20, 2025', 'status' => 'Pending'],
              ['name' => 'Yusuf Rahman', 'amount' => 'PKR 60,000', 'date' => 'May 25, 2025', 'status' => 'Pending'],
              ['name' => 'Aisha Siddiqa', 'amount' => 'PKR 55,000', 'date' => 'May 05, 2025', 'status' => 'Processed'],
              ['name' => 'Bilal Ahmed', 'amount' => 'PKR 70,000', 'date' => 'May 01, 2025', 'status' => 'Processed'],
            ];
          @endphp
          @forelse ($dummyPayments as $index => $payment)
            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-600/50' : 'bg-white dark:bg-gray-700' }} border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
              <td class="px-6 py-4 font-medium">{{ $payment['name'] }}</td>
              <td class="px-6 py-4">{{ $payment['amount'] }}</td>
              <td class="px-6 py-4">{{ $payment['date'] }}</td>
              <td class="px-6 py-4">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $payment['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100' : 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100' }}">
                  {{ $payment['status'] }}
                </span>
              </td>
              <td class="px-6 py-4">
                <a href="#" class="inline-block bg-primary text-white px-3 py-1 rounded-full hover:bg-primary-dark transition-colors text-xs font-medium">
                  {{ $payment['status'] === 'Pending' ? 'Process' : 'View' }}
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No payments found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection