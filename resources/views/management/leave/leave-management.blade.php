@extends('layouts.dashboard-layout')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('title', 'Leave Management')

@section('content')

@if(session('success') )
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const successMessage = "{{ session('success') }}";
        const errorMessage = "{{ session('error') }}";

        if (successMessage) {
            showNotification(successMessage, 'success');
        }
        if (errorMessage) {
            showNotification(errorMessage, 'error');
        }
    });

    async function showNotification(message) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');

        // Set the message
        notificationMessage.textContent = message;
        if (type === 'success') {
            notification.style.backgroundColor = '#4CAF50'; // Green for success
        } else if (type === 'error') {
            notification.style.backgroundColor = '#F44336'; // Red for error
        }
        // Slide the notification down
        setTimeout(() => {
        // Slide the notification down
        notification.style.top = '20px';

        // Hide the notification after an additional 3 seconds
        setTimeout(() => {
            notification.style.top = '-100px';
        }, 3000);
    }, 5000);

        // Optionally send the message to the backend
        try {
            const response = await fetch("{{ route('notify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ message }),
            });

            if (!response.ok) {
                console.error('Failed to send notification:', response.statusText);
            }
        } catch (error) {
            console.error('Error sending notification:', error);
        }
    }
    </script>
            @endif
@if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul>
                    {{session('error')}}
                </ul>
            </div>
        @endif





            <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-hidden="true" data-bs-keyboard="false">
                <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                
                  <div class="modal-dialog modal-dialog-left " style="padding: 0;">
                    <div class="rounded-3xl" style="padding-top: 60px;" id="editAttendanceContent">
                      <!-- Close Button -->
                      <!-- Dynamically loaded content will be injected here -->
                      <div class="text-center py-4">
                        <p>Loading...</p>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="flex flex-col items-start justify-start w-full">
                
                <div class="w-full ">
                  <div class="flex items-center justify-between w-full">
                    <div class="flex ">
                    <p class="md:text-6xl text-4xl font-bold text-black nunito-">Leaves</p>
                    </div>
                    <div class="flex items-center space-x-4">
                
        
                
                    <!-- Add record Button -->
                
                    <button 
                    class="flex items-center justify-center nunito- space-x-2 px-8 py-2 text-white md:text-2xl text-xl bg-gradient-to-r from-[#184E77] to-[#52B69A] rounded-xl shadow-sm hover:from-[#1B5A8A] hover:to-[#60C3A8]"
                    onclick="openAddModal()">
                    <p class="text-3xl"><i class="ri-add-fill"></i></p>
                    <span>Add Leave</span>
                    </button>
                
                    
                    </div>
                
                  </div>
                </div>
                <nav class="flex py-3" aria-label="Breadcrumb">
                  <ol class="inline-flex items-center space-x-1 md:space-x-3 nunito-">
                    <li class="inline-flex items-center">
                      <a href="#" class="inline-flex items-center text-3xl font-medium text-[#00000080] hover:text-blue-600">
                      Leave
                      </a>
                    </li>
                    <li>
                      <div class="flex items-center">
                        <p class="text-[#00000080] text-3xl"><i class="ri-arrow-right-wide-line"></i></p>
                        <a href="#" class="ml-1 font-medium text-[#00000080] text-3xl hover:text-blue-600">Employee Leaves</a>
                      </div>
                    </li>
                  </ol>
                </nav>
                
                <div class="w-full flex justify-end items-end pt-2 pb-2">
                  <button id="print-table" class="flex items-center justify-center space-x-2 px-6 py-2 text-[#184E77] border-2 border-[#184E77] text-2xl bg-white rounded-xl shadow-sm hover:from-[#1B5A8A] hover:to-[#60C3A8]">
                        <span>Generate Report</span>
                    </button>
                  </div>
                
                  <div class="w-full flex justify-between items-center  space-x-8 md:space-x-0 py-2">
                
                <!-- Search Bar on the Left -->
                <div class="w-[300px]">
                  <input
                  id="custom-search-input"
                    type="text"
                    placeholder="Search..."
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#184E77] focus:border-[#184E77]"
                  />
                
                </div>
         
                <!-- Calendar Input on the Right -->
                <div class="relative w-[300px] nunito-">
           <!-- Approval Status Filter -->
  <div class="w-full flex justify-end items-center mb-3 ">
    <div class="relative flex justify-end  w-[300px] nunito- z-10">
<select
id="approvalStatusFilter"
class="w-1/2  px-4 py-2  text-black border-2 border-[#184E77] rounded-xl shadow-sm"
>
<option value="">Select Status </option>
<option value="Approved">Approved</option>
<option value="Pending">Pending</option>
<option value="Rejected">Rejected</option>
</select>
</div>
 </div>
                    
                  <button
                    id="calendarButton"
                    class="flex items-center justify-between w-full px-4 py-2 text-left text-black border-2 border-[#184E77] rounded-xl shadow-sm hover:bg-[#f0f8ff]"
                  >
                    <div class="flex items-center space-x-4">
                      <span class="iconify text-[#184E77]" data-icon="mdi:calendar-outline" style="font-size: 20px;"></span>
                      <div>
                        <span class="text-sm text-[#184E77]">Select a day</span>
                        <p id="selectedDate" class="text-lg font-bold">13.03.2021</p>
                      </div>
                    </div>
                    <span class="iconify text-black" data-icon="mdi:chevron-down"></span>
                  </button>
                
                  <!-- Hidden Calendar Input -->
                  <input
                    id="calendarInput"
                    type="text"
                    class="absolute z-10 opacity-0 pointer-events-none"
                  />
                  <button
                  id="resetCalendarButton"
                  class="px-4 py-2 text-white bg-red-600 rounded-xl shadow-sm hover:bg-red-700 mt-2"
                >
                  Reset
                </button>
                </div>
                
                </div>
                
                
                
                                <table class="w-full nunito- border-separate" style="border-spacing: 0 12px; width: 100%;" id="attendance-table">
                  <thead class="w-full">
                    <tr class="text-left">
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966] rounded-l-xl">Employee</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">Leave Type</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">From Date</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">To Date</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">Duration</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">Leave Balance</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">Status</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966]">Documents</th>
                      <th class="text-xl text-black px-4 py-2 bg-[#D9D9D966] rounded-r-xl">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($leaves as $leave)
                  <tr class="hover:shadow-popup hover:rounded-xl hover:scale-101 hover:bg-white transition duration-300 hover:border-r-4 hover:border-b-4 hover:border-gray-500">
                  <td class="text-xl text-black px-4 py-2 text-left align-middle bg-[#D9D9D966] rounded-l-xl">
                  {{ $leave->employee_name }} 
                  </td>
                  <td class="text-xl text-black px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                  {{ $leave->leave_type }}
                  </td>
                  <td class="text-xl text-black px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                   {{ $leave->start_date }}
                  </td>
                  <td class="text-xl text-black px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                  {{ $leave->end_date }}
                  </td>
                  <td class="text-xl text-black px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                  {{ $leave->duration }}
                  </td>
                  
                  <td class="text-sm text-black px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                    @php
                      $balances = $leave->employee->getLeaveBalances();
                    @endphp
                    <div class="space-y-1">
                      <div class="text-xs">
                        <span class="font-medium">Annual:</span> 
                        <span class="{{ $balances['annual_leaves_remaining'] < 5 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                          {{ $balances['annual_leaves_remaining'] }}
                        </span> remaining
                      </div>
                      <div class="text-xs">
                        <span class="font-medium">Short:</span> 
                        <span class="{{ $balances['short_leaves_remaining'] < 5 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                          {{ $balances['short_leaves_remaining'] }}
                        </span> remaining
                      </div>
                      <div class="text-xs">
                        <span class="font-medium">Monthly:</span> 
                        <span class="{{ $balances['monthly_leaves_remaining'] == 0 ? 'text-red-600 font-bold' : 'text-yellow-600' }}">
                          {{ $balances['monthly_leaves_remaining'] }}
                        </span> remaining
                      </div>
                    </div>
                  </td>
                  
                  <td class="text-xl text-[#3569C3] px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                
                    
                    @if (strtolower($leave->status ) === 'approved')
                  
                  <p class="text-[#47B439] border-2 border-[#47B439] bg-[#47B43933] rounded-xl px-2 py-1 shadow-sm">
                      Approved 
                  </p>
                  @elseif (strtolower($leave->status ) === 'pending')
                  <p class="text-[#FFBF00] border-2 border-[#FFBF00] bg-[#FFBF0033] rounded-xl px-2 py-1 shadow-sm">
                      Pending
                  </p>
                  @elseif (strtolower($leave->status) === 'rejected')
                  <p class="text-[#FF0000] border-2 border-[#FF0000] bg-[#FF000033] rounded-xl px-2 py-1 shadow-sm">
                      Rejected
                  </p>
                  @endif
                      </td>
                  <td class="text-xl text-[#3569C3] px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                  @if(!empty($leave->supporting_documents) && is_string($leave->supporting_documents))
                    @php
                      $documents = json_decode($leave->supporting_documents, true);
                    @endphp
                    @if(is_array($documents))
                      <ul>
                        @foreach ($documents as $document)
                          @if(is_string($document))
                            <li>
                              @php
                                $fileName = basename($document);
                              @endphp
                              <a href="{{ asset('storage/' . $document) }}" target="_blank" class="text-blue-500 underline document-link">
                                {{ $fileName }}
                              </a>
                            </li>
                          @endif
                        @endforeach
                      </ul>
                    @else
                      <p class="text-gray-500">Invalid documents data</p>
                    @endif
                  @else
                    <p class="text-gray-500">No documents uploaded</p>
                  @endif
                </td>
                <td class="text-xl text-[#3569C3] px-4 py-2 text-left align-middle bg-[#D9D9D966]">
                
                <!-- dropdown start-->
                
                <div class="relative inline-block text-center">
                        <!-- Toggle Button -->
                        <button id="dropdownButton"  class="dropdown-trigger p-2 rounded hover:bg-gray-300">
                        <span class="iconify" data-icon="qlementine-icons:menu-dots-16" style="width: 16px; height: 16px;"></span>
                    </button>
                
                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu" 
                             class="absolute top-0 right-3 mt-12 w-30 bg-white border border-gray-100 rounded-xl shadow-lg hidden z-10">
                            <ul class=" text-gray-700">
                                <li><a href="#" class="block px-2 py-2 hover:bg-gray-100" onclick="openViewModal({
                        employeeName: '{{ $leave->employee_name }}',
                        employeeId: '{{ $leave->employment_ID }}',
                        leaveType: '{{ $leave->leave_type }}',
                        approvedBy: '{{ $leave->approved_person }}',
                        dataFrom: '{{ $leave->start_date }}',
                        dataTo: '{{ $leave->end_date }}',
                        status: '{{ $leave->status}}',
                        description: '{{ $leave->description }}',
                        supportingDoc: '{{ $leave->supporting_documents }}',
                
                    })">
                            View</a></li>
                                <li class="cursor-pointer" ><a onclick="openEditModal({{ $leave->id }})"  class="block px-2 py-2 hover:bg-gray-100">Edit</a></li>
                                <li class="bg-red">
                                  
                                <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" class="m-0 p-0">
                @csrf
                            @method('DELETE')
                            <button type="submit" 
                    class="block px-2 py-2 w-full rounded-xl bg-red-600 text-white hover:bg-red-700">
                    Delete
                </button>
                            </form></li>
                            </ul>
                        </div>
                    </div>
                
                <!--dropdown end-->
                
                
                
                
                
                  </td>
                </tr>
                @endforeach
                  </tbody>
                </table>
                
                
                
                </div>
                
                <!-- Employee Leave Balances Overview Section -->
                <div class="w-full mb-6 mt-8">
                  <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex justify-between items-center mb-4">
                      <div class="flex items-center gap-3">
                        <h3 class="text-2xl font-bold text-black">Employee Leave Balances Overview</h3>
                        <button onclick="toggleBalancesTable()" class="px-3 py-1 text-sm bg-[#184E77] text-white rounded-lg hover:bg-[#1B5A8A] transition duration-200">
                          <span id="toggle-text">Show</span>
                        </button>
                      </div>
                      <div class="flex gap-4 text-sm">
                        @php
                          $totalEmployees = $employees->count();
                          $criticalAnnual = $employees->filter(function($emp) { return $emp['annual_remaining'] < 5; })->count();
                          $criticalShort = $employees->filter(function($emp) { return $emp['short_remaining'] < 5; })->count();
                          $noMonthlyLeaves = $employees->filter(function($emp) { return $emp['monthly_leaves_remaining'] == 0; })->count();
                        @endphp
                        <div class="bg-red-100 px-3 py-1 rounded-full">
                          <span class="text-red-600 font-medium">{{ $criticalAnnual }} employees with <5 annual leaves</span>
                        </div>
                        <div class="bg-orange-100 px-3 py-1 rounded-full">
                          <span class="text-orange-600 font-medium">{{ $criticalShort }} employees with <5 short leaves</span>
                        </div>
                        <div class="bg-yellow-100 px-3 py-1 rounded-full">
                          <span class="text-yellow-600 font-medium">{{ $noMonthlyLeaves }} employees with no monthly leaves</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Live Filter Statistics -->
                    <div id="filter-stats" class="mb-4 p-3 bg-blue-50 rounded-lg hidden">
                      <div class="flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-blue-800">Filter Results</h4>
                        <div id="filter-count" class="text-sm font-medium text-blue-600"></div>
                      </div>
                      <div class="grid grid-cols-4 gap-4 mt-2 text-sm">
                        <div class="text-center">
                          <div id="filtered-critical-annual" class="text-lg font-bold text-red-600">0</div>
                          <div class="text-red-500">Critical Annual</div>
                        </div>
                        <div class="text-center">
                          <div id="filtered-critical-short" class="text-lg font-bold text-orange-600">0</div>
                          <div class="text-orange-500">Critical Short</div>
                        </div>
                        <div class="text-center">
                          <div id="filtered-no-monthly" class="text-lg font-bold text-yellow-600">0</div>
                          <div class="text-yellow-500">No Monthly</div>
                        </div>
                        <div class="text-center">
                          <div id="filtered-good-balance" class="text-lg font-bold text-green-600">0</div>
                          <div class="text-green-500">Good Balance</div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                      <!-- Quick Filter Buttons -->
                      <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quick Filters</label>
                        <div class="flex flex-wrap gap-2">
                          <button onclick="applyQuickFilter('critical-annual')" class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition duration-200">
                            Critical Annual Leaves
                          </button>
                          <button onclick="applyQuickFilter('critical-short')" class="px-3 py-1 text-sm bg-orange-100 text-orange-700 rounded-full hover:bg-orange-200 transition duration-200">
                            Critical Short Leaves
                          </button>
                          <button onclick="applyQuickFilter('no-monthly')" class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full hover:bg-yellow-200 transition duration-200">
                            No Monthly Leaves
                          </button>
                          <button onclick="applyQuickFilter('good-balance')" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition duration-200">
                            Good Balance
                          </button>
                          <button onclick="applyQuickFilter('all')" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200">
                            Show All
                          </button>
                        </div>
                      </div>
                      
                      <div class="flex flex-wrap gap-4 items-center">
                        <!-- Search Filter -->
                        <div class="flex-1 min-w-[200px]">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Search Employee</label>
                          <input
                            type="text"
                            id="balance-search-input"
                            placeholder="Search by name or ID..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#184E77] focus:border-[#184E77]"
                          />
                        </div>
                        
                        <!-- Department Filter -->
                        <div class="min-w-[150px]">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                          <select id="balance-department-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#184E77] focus:border-[#184E77]">
                            <option value="">All Departments</option>
                            @php
                              $departments = $employees->pluck('department')->unique()->filter();
                            @endphp
                            @foreach($departments as $department)
                              <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                          </select>
                        </div>
                        
                        <!-- Leave Status Filter -->
                        <div class="min-w-[150px]">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Leave Status</label>
                          <select id="balance-status-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#184E77] focus:border-[#184E77]">
                            <option value="">All Status</option>
                            <option value="critical-annual">Critical Annual (<5)</option>
                            <option value="critical-short">Critical Short (<5)</option>
                            <option value="no-monthly">No Monthly Leaves</option>
                            <option value="good-balance">Good Balance</option>
                          </select>
                        </div>
                        
                        <!-- Sort Options -->
                        <div class="min-w-[150px]">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                          <select id="balance-sort-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#184E77] focus:border-[#184E77]">
                            <option value="name">Name (A-Z)</option>
                            <option value="annual-desc">Annual Leaves (High to Low)</option>
                            <option value="annual-asc">Annual Leaves (Low to High)</option>
                            <option value="short-desc">Short Leaves (High to Low)</option>
                            <option value="short-asc">Short Leaves (Low to High)</option>
                          </select>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2">
                          <button onclick="clearBalanceFilters()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                            Clear Filters
                          </button>
                        </div>
                      </div>
                    </div>
                    <div id="balances-table-container" class="overflow-x-auto" style="display: none;">
                      <table class="min-w-full border-separate" style="border-spacing: 0 8px;">
                        <thead>
                          <tr class="text-sm font-medium text-gray-700">
                            <th class="px-4 py-2 text-left bg-gray-100 rounded-l-lg">Employee</th>
                            <th class="px-4 py-2 text-center bg-gray-100">Annual Leaves</th>
                            <th class="px-4 py-2 text-center bg-gray-100">Short Leaves</th>
                            <th class="px-4 py-2 text-center bg-gray-100">Monthly Leaves</th>
                            <th class="px-4 py-2 text-center bg-gray-100">Half Leaves (Monthly)</th>
                            <th class="px-4 py-2 text-center bg-gray-100 rounded-r-lg">Short Leaves (Monthly)</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($employees as $employee)
                          <tr class="hover:shadow-md transition duration-200" data-department="{{ $employee['department'] ?? '' }}">
                            <td class="px-4 py-3 bg-white rounded-l-lg border-l border-t border-b border-gray-200">
                              <div class="font-medium text-gray-900">{{ $employee['name'] }}</div>
                              <div class="text-sm text-gray-500">ID: {{ $employee['employee_id'] }}</div>
                            </td>
                            <td class="px-4 py-3 text-center bg-white border-t border-b border-gray-200">
                              <div class="flex flex-col items-center">
                                <div class="text-lg font-semibold {{ $employee['annual_remaining'] < 5 ? 'text-red-600' : 'text-green-600' }}">
                                  {{ $employee['annual_remaining'] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $employee['annual_used'] }}/{{ $employee['annual_balance'] }} used</div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ ($employee['annual_used'] / $employee['annual_balance']) * 100 }}%"></div>
                                </div>
                              </div>
                            </td>
                            <td class="px-4 py-3 text-center bg-white border-t border-b border-gray-200">
                              <div class="flex flex-col items-center">
                                <div class="text-lg font-semibold {{ $employee['short_remaining'] < 5 ? 'text-red-600' : 'text-green-600' }}">
                                  {{ $employee['short_remaining'] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $employee['short_used'] }}/{{ $employee['short_balance'] }} used</div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ ($employee['short_used'] / $employee['short_balance']) * 100 }}%"></div>
                                </div>
                              </div>
                            </td>
                            <td class="px-4 py-3 text-center bg-white border-t border-b border-gray-200">
                              <div class="flex flex-col items-center">
                                <div class="text-lg font-semibold {{ $employee['monthly_leaves_remaining'] == 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                  {{ $employee['monthly_leaves_remaining'] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $employee['monthly_leaves_used'] }}/2 used</div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-yellow-600 h-1.5 rounded-full" style="width: {{ ($employee['monthly_leaves_used'] / 2) * 100 }}%"></div>
                                </div>
                              </div>
                            </td>
                            <td class="px-4 py-3 text-center bg-white border-t border-b border-gray-200">
                              <div class="flex flex-col items-center">
                                <div class="text-lg font-semibold {{ $employee['monthly_half_leaves_remaining'] == 0 ? 'text-red-600' : 'text-purple-600' }}">
                                  {{ $employee['monthly_half_leaves_remaining'] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $employee['monthly_half_leaves_used'] }}/1 used</div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ ($employee['monthly_half_leaves_used'] / 1) * 100 }}%"></div>
                                </div>
                              </div>
                            </td>
                            <td class="px-4 py-3 text-center bg-white rounded-r-lg border-r border-t border-b border-gray-200">
                              <div class="flex flex-col items-center">
                                <div class="text-lg font-semibold {{ $employee['monthly_short_leaves_remaining'] == 0 ? 'text-red-600' : 'text-indigo-600' }}">
                                  {{ $employee['monthly_short_leaves_remaining'] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $employee['monthly_short_leaves_used'] }}/3 used</div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ ($employee['monthly_short_leaves_used'] / 3) * 100 }}%"></div>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                <!--View record form start-->
                <div id="view-attendance-modal-container" class=" fixed inset-0 bg-black bg-opacity-50 w-full opacity-0 transition-opacity duration-300 flex justify-center items-center hidden z-50">
                
                <div class="w-full flex justify-center items-center rounded-3xl">
                  <!-- Close Button -->
                  <div id="modal-container" class="w-1/3 flex flex-col justify-start items-center relative bg-white nunito- p-2 rounded-3xl bg-gradient-to-r from-[#184E77] to-[#52B69A]">
                    <button onclick="closeAddNewModal()" id="close-button" class="absolute top-4 right-4 text-black font-medium rounded-full text-xl p-4 inline-flex items-center">
                        <span class="iconify" data-icon="ic:baseline-close" style="width: 16px; height: 16px;"></span>
                    </button>
                    <div class="w-full flex flex-col justify-start items-center bg-white p-8 rounded-3xl space-y-8">
                      <div class="flex flex-col justify-center items-center space-y-4">
                        <p class="text-5xl text-black font-bold">Leave</p>
                        <p class="text-3xl text-[#00000080]">Enter the Information about Leaves </p>
                      </div>
                        <div class="w-full flex mx-auto pb-8 pt-8 px-16">
                            <div class="w-1/2 flex flex-col space-y-8">
                                <!-- Employee ID -->
                            <p class="text-xl font-bold text-black">Employee Name :</p>
                            <p class="text-xl font-bold text-black">Employee ID :</p>
                            <p class="text-xl font-bold text-black">Leave Type :</p>
                            <p class="text-xl font-bold text-black">Approved By :</p>
                            <p class="text-xl font-bold text-black">Data From :</p>
                            <p class="text-xl font-bold text-black">Data To :</p>
                            <p class="text-xl font-bold text-black">Status :</p>
                            <p class="text-xl font-bold text-black">Description : </p>
                            <p class="text-xl font-bold text-black">Supporting Doc :</p>
                            </div>
                            <div class="w-1/2 flex flex-col space-y-8">
                            <p class="text-xl font-bold text-black modal-employee-name"></p>
                            <p class="text-xl font-bold text-black modal-employee-id"></p>
                            <p class="text-xl font-bold text-black modal-leave-type"></p>
                            <p class="text-xl font-bold text-black modal-approved-by"></p>
                            <p class="text-xl font-bold text-black modal-data-from"></p>
                            <p class="text-xl font-bold text-black modal-data-to"></p>
                            <p class="text-xl font-bold text-black modal-status"></p>
                            <p class="text-xl font-bold text-black modal-description"></p>
                            <p class="text-xl font-bold text-black modal-supporting-doc"></p>
                            </div>
                          
                        </div>
                        <!-- Submit Button -->
                        <div class="w-full text-center px-16">
                          <button
                            onclick="closeAddNewModal()"
                            class="w-full bg-gradient-to-r from-[#184E77] to-[#52B69A] text-xl text-white font-bold py-4 px-4 rounded-xl hover:from-blue-600 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                          >
                          Done
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <!--View record form end-->

<script>

let selectedAddFiles = new DataTransfer();
function openAddModal() {
    const modal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
    modal.show();

    const modalContent = document.getElementById('editAttendanceContent');
    modalContent.innerHTML = '<div class="text-center "><p>Loading...</p></div>';

    selectedAddFiles = new DataTransfer();
    // Fetch content from the server
    fetch(`${window.location.origin}/dashboard/leaves/leave/create`)
      .then(response => response.text())
      .then(html => {
        modalContent.innerHTML = html;

         // Reinitialize any necessary scripts or event listeners
         setTimeout(() => {
                // Ensure file input works after content is loaded
                const docFilesInput = document.getElementById('doc-files');
                if (docFilesInput) {
                    docFilesInput.addEventListener('change', function () {
                        console.log('File input changed');
                        handleAddFileSelection(this);
                    });
                }
                // Wire up status handler for injected create form
                const statusEl = modalContent.querySelector('#status');
                if (statusEl && typeof window.handleStatusChange === 'function') {
                  statusEl.addEventListener('change', window.handleStatusChange);
                  window.handleStatusChange();
                }
                // Wire up category handler for injected create form
                const categoryEl = modalContent.querySelector('#leave_category');
                if (categoryEl && typeof window.handleCategoryChange === 'function') {
                  categoryEl.addEventListener('change', window.handleCategoryChange);
                  window.handleCategoryChange();
                }
            }, 100);
      })
      .catch(error => {
        modalContent.innerHTML = '<div class="text-center py-4 text-danger"><p>Error loading content. Please try again later.</p></div>';
        console.error('Error:', error);
      });
  }

  // Global variables for file management
let existingFilesList = [];
let selectedFiles = new DataTransfer();

// Initialize existing files when modal opens
function initializeExistingFiles(existingFilesJson) {
    try {
        existingFilesList = JSON.parse(existingFilesJson || '[]');
        refreshFileList();
    } catch (error) {
        console.error('Error initializing existing files:', error);
    }
}

// Refresh the complete file list display
function refreshFileList() {
    const fileListDisplay = document.getElementById('file-list-items');
    fileListDisplay.innerHTML = '';

    // Display existing files
    existingFilesList.forEach(filePath => {
        const fileName = filePath.split('/').pop();
        addFileToDisplay(fileName, filePath, true);
    });

    // Display newly selected files
    Array.from(selectedFiles.files).forEach(file => {
        addFileToDisplay(file.name, null, false);
    });

    // Update hidden inputs
    updateHiddenInputs();
}

// Add individual file to display
function addFileToDisplay(fileName, filePath, isExisting) {
    const fileListDisplay = document.getElementById('file-list-items');
    const listItem = document.createElement('li');
    listItem.className = 'flex items-center space-x-2 mb-2';
    
    listItem.innerHTML = isExisting ? 
        `<span class="text-2xl">
            <i class="ri-file-pdf-2-fill"></i>
        </span>
        <a href="/storage/${filePath}" target="_blank" class="text-blue-500 underline">${fileName}</a>
        <span onclick="removeFile('${filePath}', true)" class="text-red-500 cursor-pointer ml-2">✖</span>` :
        `<span class="text-2xl">
            <i class="ri-file-pdf-2-fill"></i>
        </span>
        <span class="text-blue-500">${fileName}</span>
        <span onclick="removeFile('${fileName}', false)" class="text-red-500 cursor-pointer ml-2">✖</span>`;
    
    fileListDisplay.appendChild(listItem);
}

// Handle new file selection
function handleFileSelection(input) {
    const files = Array.from(input.files);
    
    files.forEach(file => {
        // Check for duplicates
        const isDuplicateNew = Array.from(selectedFiles.files)
            .some(existing => existing.name === file.name);
        const isDuplicateExisting = existingFilesList
            .some(existing => existing.includes(file.name));

        if (isDuplicateNew || isDuplicateExisting) {
            alert(`File "${file.name}" is already selected.`);
            return;
        }

        selectedFiles.items.add(file);
    });

    refreshFileList();
    input.value = ''; // Clear the input for future selections
}

// Remove file (both existing and new)
function removeFile(identifier, isExisting) {
    if (isExisting) {
        existingFilesList = existingFilesList.filter(path => path !== identifier);
    } else {
        const newDataTransfer = new DataTransfer();
        Array.from(selectedFiles.files).forEach(file => {
            if (file.name !== identifier) {
                newDataTransfer.items.add(file);
            }
        });
        selectedFiles = newDataTransfer;
    }
    
    refreshFileList();
}

// Update all hidden inputs
function updateHiddenInputs() {
    // Update existing files input
    const existingFilesInput = document.getElementById('existing-files');
    existingFilesInput.value = JSON.stringify(existingFilesList);

    // Update new files input
    const hiddenFilesInput = document.getElementById('hidden-files');
    hiddenFilesInput.files = selectedFiles.files;
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('doc-files');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            handleFileSelection(this);
        });
    }

    const existingFilesData = document.getElementById('existing-files-data');
    if (existingFilesData) {
        initializeExistingFiles(existingFilesData.value);
    }
});
  function openEditModal(leaveId) {
    const modal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
    modal.show();

    const modalContent = document.getElementById('editAttendanceContent');
    modalContent.innerHTML = '<div class="text-center "><p>Loading...</p></div>';

    selectedFiles = new DataTransfer();
    existingFilesList = [];

    // Fetch content from the server
    fetch(`${window.location.origin}/dashboard/leaves/${leaveId}/edit`)
      .then(response => response.text())
      .then(html => {
        modalContent.innerHTML = html;

        setTimeout(() => {
                // Ensure file input works after content is loaded
                const docFilesInput = document.getElementById('doc-files');
                if (docFilesInput) {
                    docFilesInput.addEventListener('change', function() {
                        handleFileSelection(this);
                    });
                }
                const existingFilesData = document.getElementById('existing-files-data');
                if (existingFilesData) {
                    initializeExistingFiles(existingFilesData.value);
                }
                // Wire up status handler for injected edit form
                const statusEl = modalContent.querySelector('#status');
                if (statusEl && typeof window.handleStatusChange === 'function') {
                  statusEl.addEventListener('change', window.handleStatusChange);
                  window.handleStatusChange();
                }
                // Wire up category handler for injected edit form
                const categoryEl = modalContent.querySelector('#leave_category');
                if (categoryEl && typeof window.handleCategoryChange === 'function') {
                  categoryEl.addEventListener('change', window.handleCategoryChange);
                  window.handleCategoryChange();
                }
            }, 100);
      })
      .catch(error => {
        modalContent.innerHTML = '<div class="text-center py-4 text-danger"><p>Error loading content. Please try again later.</p></div>';
        console.error('Error:', error);
      });
  }

  function openViewModal(data) {
    // Populate modal fields with the passed data
    document.querySelector('#view-attendance-modal-container .modal-employee-name').textContent = data.employeeName;
    document.querySelector('#view-attendance-modal-container .modal-employee-id').textContent = data.employeeId;
    document.querySelector('#view-attendance-modal-container .modal-leave-type').textContent = data.leaveType;
    document.querySelector('#view-attendance-modal-container .modal-approved-by').textContent = data.approvedBy;
    document.querySelector('#view-attendance-modal-container .modal-data-from').textContent = data.dataFrom;
    document.querySelector('#view-attendance-modal-container .modal-data-to').textContent = data.dataTo;
    document.querySelector('#view-attendance-modal-container .modal-status').textContent = data.status;
    document.querySelector('#view-attendance-modal-container .modal-description').textContent = data.description;
    
    const supportingDocContainer = document.querySelector('#view-attendance-modal-container .modal-supporting-doc');
    supportingDocContainer.innerHTML = ''; // Clear previous content
    
    try {
        const documents = JSON.parse(data.supportingDoc);
        if (Array.isArray(documents) && documents.length > 0) {
            const docList = document.createElement('ul');
            docList.className = 'space-y-2';
            
            documents.forEach(doc => {
                if (typeof doc === 'string') {
                    const li = document.createElement('li');
                    const link = document.createElement('a');
                    link.href = `/storage/${doc}`;
                    link.target = '_blank';
                    link.className = 'text-blue-500 hover:text-blue-700 underline';
                    link.textContent = doc.split('/').pop(); // Get filename from path
                    li.appendChild(link);
                    docList.appendChild(li);
                }
            });
            
            supportingDocContainer.appendChild(docList);
        } else {
            supportingDocContainer.textContent = 'No documents available';
        }
    } catch (e) {
        supportingDocContainer.textContent = 'No documents available';
    }

    // Show the modal
    const modal = document.getElementById('view-attendance-modal-container');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0', 'scale-95');
    }, 10);
}


   function toggleDropdown(button) {
    const dropdown = button.nextElementSibling; // Find the next sibling element (dropdown menu)
    dropdown.classList.toggle('hidden'); // Toggle the 'hidden' class
}

  function toggleGradientText() {
    const textElement = document.getElementById('payrollText');
    if (textElement.classList.contains('text-black')) {
      // Apply gradient
      textElement.classList.remove('text-black');
      textElement.classList.add('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    } else {
      // Revert to black
      textElement.classList.add('text-black');
      textElement.classList.remove('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    }
  }
  
  function toggleMenu(menuId) {
    const menu = document.getElementById(menuId);
    menu.classList.toggle('hidden');
  }
    // Initialize clickable gradient text once
    if (!window.__lmTextElementsInit) {
            // Duplicate textElements initializations removed; guarded earlier with __lmTextElementsInit
            window.__lmTextElementsInit = true;
    }

    // Global status change handler for dynamically injected create/edit forms
    window.handleStatusChange = function () {
        const container = document.getElementById('editAttendanceContent') || document;
        const statusEl = container.querySelector('#status') || document.getElementById('status');
        const approvedByField = container.querySelector('#approved_by_field') || document.getElementById('approved_by_field');
        const approvedPersonInput = container.querySelector('#approved_person') || document.getElementById('approved_person');

        if (!statusEl || !approvedByField || !approvedPersonInput) return;

        const val = (statusEl.value || '').toLowerCase();
        if (val === 'approved' || val === 'rejected') {
            approvedByField.style.display = 'block';
            approvedPersonInput.required = true;
        } else {
            approvedByField.style.display = 'none';
            approvedPersonInput.required = false;
            approvedPersonInput.value = '';
        }
    };

    // Global category change handler for dynamically injected create/edit forms
    window.handleCategoryChange = function () {
        const container = document.getElementById('editAttendanceContent') || document;
        const categoryEl = container.querySelector('#leave_category') || document.getElementById('leave_category');
        const halfDayOptions = container.querySelector('#half_day_options') || document.getElementById('half_day_options');
        const shortLeaveOptions = container.querySelector('#short_leave_options') || document.getElementById('short_leave_options');
        const timeInputs = container.querySelector('#time_inputs') || document.getElementById('time_inputs');
        const placeholder = container.querySelector('#category_type_placeholder') || document.getElementById('category_type_placeholder');
        const halfDaySelect = container.querySelector('#half_day_type') || document.getElementById('half_day_type');
        const shortLeaveSelect = container.querySelector('#short_leave_type') || document.getElementById('short_leave_type');

        if (!categoryEl) return;

        const category = categoryEl.value;

        // Hide all conditional fields
        if (halfDayOptions) halfDayOptions.classList.add('hidden');
        if (shortLeaveOptions) shortLeaveOptions.classList.add('hidden');
        if (timeInputs) timeInputs.classList.add('hidden');

        // Show placeholder by default
        if (placeholder) placeholder.style.display = 'block';

        // Reset required flags
        if (halfDaySelect) halfDaySelect.required = false;
        if (shortLeaveSelect) shortLeaveSelect.required = false;

        if (category === 'half_day') {
            if (halfDayOptions) halfDayOptions.classList.remove('hidden');
            if (timeInputs) timeInputs.classList.remove('hidden');
            if (placeholder) placeholder.style.display = 'none';
            if (halfDaySelect) halfDaySelect.required = true;
        } else if (category === 'short_leave') {
            if (shortLeaveOptions) shortLeaveOptions.classList.remove('hidden');
            if (timeInputs) timeInputs.classList.remove('hidden');
            if (placeholder) placeholder.style.display = 'none';
            if (shortLeaveSelect) shortLeaveSelect.required = true;
        }

        // Call calculateNoPayAmount if it exists
        if (typeof window.calculateNoPayAmount === 'function') {
            window.calculateNoPayAmount();
        }
    };
// Initialize Flatpickr$(document).ready(function () {
    // Initialize DataTable

    $(document).ready(function () {
      // Initialize DataTable
    var table = $('#attendance-table').DataTable({
      dom: '<"top"f>rt<"bottom"p><"clear">', // Custom layout: search box on top, pagination on bottom
    paging: true,
    pageLength: 10, 
    pagingType: 'simple', 
    searching: true,
        buttons: [
            {
                extend: 'print',
                text: 'Print Table',
                title: 'Leave Report', // Optional title
                exportOptions: {
                    columns: ':visible', // Export all visible columns
                }
            }
        ],
        language: {
        paginate: {
            previous: '<span class="custom-prev-button"><i class="ri-arrow-left-s-line"></i> Prev</span>',
            next: '<span class="custom-next-button">Next <i class="ri-arrow-right-s-line"></i></span>',
        },
    },
    columnDefs: [
        { 
            targets: 0, 
            className: 'employee-column' 
        },
        { 
            targets: 1, 
            className: 'leave-type-column' 
        },
        { 
            targets: 2, 
            className: 'date-from-column' 
        },
        { 
            targets: 3, 
            className: 'date-to-column' 
        },
        { 
            targets: 4, 
            className: 'duration-column' 
        },
        { 
            targets: 5, 
            className: 'leave-balance-column' 
        },
        { 
            targets: 6, 
            className: 'approval-column' 
        },
        { 
            targets: 7, 
            className: 'documents-column' 
        },
        { 
            targets: 8, 
            className: 'actions-column' 
        }
    ]
    });

    // Attach Print functionality to the custom button
    $('#print-table').on('click', function () {
        table.button('.buttons-print').trigger(); // Trigger the print button
    });

// Attach a keyup event listener to the custom search input element
$('#custom-search-input').on('keyup', function () {
    const searchTerm = $(this).val(); // Get the value of the search input
    table.search(searchTerm).draw(); // Trigger the DataTable search with the entered term
});


  // Approval Status Filter
  $('#approvalStatusFilter').on('change', function () {
    const status = $(this).val();
    table.columns(6).search(status).draw(); // Status is now in the 7th column (index 6)
  });

$('#resetCalendarButton').on('click', function () {
    selectedDate.textContent = '13.03.2021'; // Reset displayed date
    calendarInput._flatpickr.clear(); // Clear Flatpickr input
    table.columns(2).search('').draw(); // Clear DataTable date filter (From Date column)
  });
//pagination controls
table.on('draw', function () {
    const pagination = $('.dataTables_paginate');
    const pageInfo = table.page.info();

    // Clear existing pagination
    pagination.html('');

    // Build custom pagination
    let customPagination = `
        <div class="flex items-center justify-end w-full space-x-4 mt-8">
            <button class="flex items-center px-2 py-1 text-gray-500 hover:text-black focus:outline-none ${
                pageInfo.page === 0 ? 'cursor-not-allowed text-gray-400' : ''
            }" data-action="prev" ${pageInfo.page === 0 ? 'disabled' : ''}>
                <i class="ri-arrow-left-s-line"></i>
                <span class="ml-1">Prev</span>
            </button>
            <div class="flex items-center space-x-2">
    `;

    for (let i = 0; i < pageInfo.pages; i++) {
        customPagination += `
            <button class="flex items-center justify-center w-8 h-8 ${
                i === pageInfo.page
                    ? 'font-bold text-black bg-[#52B69A80] rounded-full focus:outline-none'
                    : 'text-black rounded-full hover:bg-gray-200 focus:outline-none'
            }" data-page="${i}">
                ${i + 1}
            </button>
        `;
    }

    customPagination += `
            </div>
            <button class="flex items-center px-2 py-1 text-gray-500 hover:text-black focus:outline-none ${
                pageInfo.page + 1 === pageInfo.pages
                    ? 'cursor-not-allowed text-gray-400'
                    : ''
            }" data-action="next" ${
        pageInfo.page + 1 === pageInfo.pages ? 'disabled' : ''
    }>
                <span class="mr-1">Next</span>
                <i class="ri-arrow-right-s-line"></i>
            </button>
        </div>
    `;

    pagination.html(customPagination);
});

// Handle custom pagination button clicks
$(document).on('click', '.dataTables_paginate button', function () {
    const action = $(this).data('action');
    const page = $(this).data('page');

    if (action === 'prev') {
        table.page('previous').draw('page');
    } else if (action === 'next') {
        table.page('next').draw('page');
    } else if (page !== undefined) {
        table.page(page).draw('page');
    }
});
//pagination controls end




    // Initialize Flatpickr for Date Selection
    const calendarInput = document.getElementById("calendarInput");
    const selectedDate = document.getElementById("selectedDate");
    const calendarButton = document.getElementById("calendarButton");

    flatpickr(calendarInput, {
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr) {
            selectedDate.textContent = dateStr;
            // Filter DataTable by selected date in From Date column
            table.columns(2).search(dateStr).draw();
        },
    });

    calendarButton.addEventListener("click", () => {
        calendarInput._flatpickr.open();
    });

    table.draw('page');
});



function openAddNewModal() {
  const modal = document.getElementById('view-attendance-modal-container');
  modal.classList.remove('hidden'); // Make visible
  setTimeout(() => {
    modal.classList.remove('opacity-0', 'scale-95'); // Apply transition effects
  }, 10);
}

function closeAddNewModal() {
  const modal = document.getElementById('view-attendance-modal-container');
  modal.classList.add('opacity-0', 'scale-95'); // Apply transition effects
  setTimeout(() => {
    modal.classList.add('hidden'); // Hide modal after transition
  }, 300); // Match the transition duration
}


function handleAddFileSelection(input) {
    const fileList = document.getElementById('file-list-items');
    const hiddenFilesInput = document.getElementById('hidden-files');
    if (!fileList || !hiddenFilesInput) {
        console.error('Required DOM elements not found.');
        return;
    }

    const files = Array.from(input.files);

    // Add newly selected files to the DataTransfer object
    files.forEach(file => {
        selectedAddFiles.items.add(file);
    });

    // Update the displayed list
    refreshAddFileList();

    // Update the hidden input's files
    hiddenFilesInput.files = selectedAddFiles.files;

    // Clear the original file input so the same file can be reselected if needed
    input.value = '';
}

function refreshAddFileList() {
    const fileListDisplay = document.getElementById('file-list-items');
    if (!fileListDisplay) {
        console.error('File list display element not found.');
        return;
    }

    // Clear the list before re-rendering
    fileListDisplay.innerHTML = '';

    // Display all files in `selectedAddFiles`
    Array.from(selectedAddFiles.files).forEach(file => {
        addFileToDisplayAdd(file.name, null);
    });
}

function addFileToDisplayAdd(fileName, filePath) {
    const fileListDisplay = document.getElementById('file-list-items');
    if (!fileListDisplay) {
        console.error('File list display element not found.');
        return;
    }

    const listItem = document.createElement('li');
    listItem.className = 'flex items-center space-x-2 mb-2';

    listItem.innerHTML = filePath
        ? `<span class="text-2xl">
            <i class="ri-file-pdf-2-fill"></i>
        </span>
        <a href="/storage/${filePath}" target="_blank" class="text-blue-500 underline">${fileName}</a>
        <span onclick="removeFileAdd('${filePath}', true)" class="text-red-500 cursor-pointer ml-2">✖</span>`
        : `<span class="text-2xl">
            <i class="ri-file-pdf-2-fill"></i>
        </span>
        <span class="text-blue-500">${fileName}</span>
        <span onclick="removeFileAdd('${fileName}', false)" class="text-red-500 cursor-pointer ml-2">✖</span>`;

    fileListDisplay.appendChild(listItem);
}

// The removeFile function to remove files from selectedAddFiles
function removeFileAdd(fileIdentifier, isFilePath) {
    let updatedFiles;

    if (isFilePath) {
        // If it's a file path, remove the file from DataTransfer using the file path
        updatedFiles = Array.from(selectedAddFiles.files).filter(file => file.name !== fileIdentifier);
    } else {
        // If it's the file name, remove by name
        updatedFiles = Array.from(selectedAddFiles.files).filter(file => file.name !== fileIdentifier);
    }

    // Reset the DataTransfer object with updated files
    selectedAddFiles = new DataTransfer();
    updatedFiles.forEach(file => selectedAddFiles.items.add(file));

    // Update the displayed file list
    refreshAddFileList();

    // Update the hidden input's files to reflect the changes
    const hiddenFilesInput = document.getElementById('hidden-files');
    if (hiddenFilesInput) {
        hiddenFilesInput.files = selectedAddFiles.files;
    }
}


// Select all dropdown triggers
const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');

// Event listener for dropdown buttons
dropdownTriggers.forEach(button => {
    button.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent the click from propagating to the window

        const dropdownMenu = button.nextElementSibling; // The dropdown menu after the button

        // Close all other dropdowns
        document.querySelectorAll('#dropdown-menu').forEach(menu => {
            if (menu !== dropdownMenu) {
                menu.classList.add('hidden');
            }
        });

        // Toggle the current dropdown menu
        dropdownMenu.classList.toggle('hidden');
    });
});

// Close dropdowns when clicking anywhere outside
window.addEventListener('click', () => {
  
    document.querySelectorAll('#dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
});


//document hover modal

// Document hover tooltip functionality
document.addEventListener('DOMContentLoaded', () => {
    const documentLinks = document.querySelectorAll('.document-link');
    
    documentLinks.forEach(link => {
        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.classList.add('document-tooltip');
        tooltip.style.display = 'none';
        tooltip.style.position = 'absolute';
        tooltip.style.backgroundColor = 'black';
        tooltip.style.color = 'white';
        tooltip.style.padding = '5px';
        tooltip.style.borderRadius = '4px';
        tooltip.style.zIndex = '100';
        tooltip.style.maxWidth = '300px';
        tooltip.style.wordWrap = 'break-word';
        
        // Set full document name
        tooltip.textContent = link.getAttribute('data-full-name') || link.textContent;
        
        // Append tooltip to body
        document.body.appendChild(tooltip);
        
        // Event listeners for hover
        link.addEventListener('mouseenter', (e) => {
            const rect = link.getBoundingClientRect();
            tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
            tooltip.style.left = `${rect.left + window.scrollX}px`;
            tooltip.style.display = 'block';
        });
        
        link.addEventListener('mouseleave', () => {
            tooltip.style.display = 'none';
        });
    });
});

// Function to toggle leave balances table visibility
function toggleBalancesTable() {
    const container = document.getElementById('balances-table-container');
    const toggleText = document.getElementById('toggle-text');
    
    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'block';
        toggleText.textContent = 'Hide';
        // Initialize filtering when showing for the first time
        if (!window.balanceFilteringInitialized) {
            initializeBalanceFiltering();
            window.balanceFilteringInitialized = true;
        }
    } else {
        container.style.display = 'none';
        toggleText.textContent = 'Show';
    }
}

// Initialize balance table filtering
let allBalanceRows = [];
let filteredBalanceRows = [];

function initializeBalanceFiltering() {
    // Store all rows for filtering
    const tableBody = document.querySelector('#balances-table-container tbody');
    if (tableBody) {
        allBalanceRows = Array.from(tableBody.querySelectorAll('tr'));
        filteredBalanceRows = [...allBalanceRows];
    }
    
    // Add event listeners to filters
    document.getElementById('balance-search-input')?.addEventListener('input', applyBalanceFilters);
    document.getElementById('balance-department-filter')?.addEventListener('change', applyBalanceFilters);
    document.getElementById('balance-status-filter')?.addEventListener('change', applyBalanceFilters);
    document.getElementById('balance-sort-filter')?.addEventListener('change', applyBalanceFilters);
}

function applyBalanceFilters() {
    const searchTerm = document.getElementById('balance-search-input')?.value.toLowerCase() || '';
    const departmentFilter = document.getElementById('balance-department-filter')?.value || '';
    const statusFilter = document.getElementById('balance-status-filter')?.value || '';
    const sortFilter = document.getElementById('balance-sort-filter')?.value || 'name';
    
    // Filter rows
    filteredBalanceRows = allBalanceRows.filter(row => {
        // Search filter
        const employeeName = row.querySelector('td:first-child .font-medium')?.textContent.toLowerCase() || '';
        const employeeId = row.querySelector('td:first-child .text-gray-500')?.textContent.toLowerCase() || '';
        const searchMatch = employeeName.includes(searchTerm) || employeeId.includes(searchTerm);
        
        // Department filter (you'll need to add department data to rows if available)
        let departmentMatch = true;
        if (departmentFilter) {
            // Add department data attribute to rows in the blade template for this to work
            const rowDepartment = row.dataset.department || '';
            departmentMatch = rowDepartment === departmentFilter;
        }
        
        // Status filter
        let statusMatch = true;
        if (statusFilter) {
            const annualValue = parseInt(row.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
            const shortValue = parseInt(row.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
            const monthlyValue = parseInt(row.querySelector('td:nth-child(4) .text-lg')?.textContent || '0');
            
            switch (statusFilter) {
                case 'critical-annual':
                    statusMatch = annualValue < 5;
                    break;
                case 'critical-short':
                    statusMatch = shortValue < 5;
                    break;
                case 'no-monthly':
                    statusMatch = monthlyValue === 0;
                    break;
                case 'good-balance':
                    statusMatch = annualValue >= 5 && shortValue >= 5 && monthlyValue > 0;
                    break;
            }
        }
        
        return searchMatch && departmentMatch && statusMatch;
    });
    
    // Sort rows
    filteredBalanceRows.sort((a, b) => {
        switch (sortFilter) {
            case 'name':
                const nameA = a.querySelector('td:first-child .font-medium')?.textContent || '';
                const nameB = b.querySelector('td:first-child .font-medium')?.textContent || '';
                return nameA.localeCompare(nameB);
            case 'annual-desc':
                const annualA = parseInt(a.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
                const annualB = parseInt(b.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
                return annualB - annualA;
            case 'annual-asc':
                const annualA2 = parseInt(a.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
                const annualB2 = parseInt(b.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
                return annualA2 - annualB2;
            case 'short-desc':
                const shortA = parseInt(a.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
                const shortB = parseInt(b.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
                return shortB - shortA;
            case 'short-asc':
                const shortA2 = parseInt(a.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
                const shortB2 = parseInt(b.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
                return shortA2 - shortB2;
            default:
                return 0;
        }
    });
    
    // Update display
    updateBalanceTableDisplay();
}

function updateBalanceTableDisplay() {
    const tableBody = document.querySelector('#balances-table-container tbody');
    if (!tableBody) return;
    
    // Hide all rows
    allBalanceRows.forEach(row => {
        row.style.display = 'none';
    });
    
    // Show filtered rows
    filteredBalanceRows.forEach(row => {
        row.style.display = '';
    });
    
    // Update results count
    updateBalanceResultsCount();
}

function updateBalanceResultsCount() {
    const totalCount = allBalanceRows.length;
    const filteredCount = filteredBalanceRows.length;
    
    // Add results counter if it doesn't exist
    let counter = document.getElementById('balance-results-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'balance-results-counter';
        counter.className = 'text-sm text-gray-600 mb-2';
        const tableContainer = document.getElementById('balances-table-container');
        tableContainer.insertBefore(counter, tableContainer.firstChild);
    }
    
    counter.textContent = `Showing ${filteredCount} of ${totalCount} employees`;
    
    // Update filter statistics
    updateFilterStatistics();
}

function updateFilterStatistics() {
    const statsContainer = document.getElementById('filter-stats');
    const filterCount = document.getElementById('filter-count');
    
    if (filteredBalanceRows.length !== allBalanceRows.length) {
        // Show statistics when filtering is active
        statsContainer.classList.remove('hidden');
        
        // Count different categories in filtered results
        let criticalAnnual = 0;
        let criticalShort = 0;
        let noMonthly = 0;
        let goodBalance = 0;
        
        filteredBalanceRows.forEach(row => {
            const annualValue = parseInt(row.querySelector('td:nth-child(2) .text-lg')?.textContent || '0');
            const shortValue = parseInt(row.querySelector('td:nth-child(3) .text-lg')?.textContent || '0');
            const monthlyValue = parseInt(row.querySelector('td:nth-child(4) .text-lg')?.textContent || '0');
            
            if (annualValue < 5) criticalAnnual++;
            if (shortValue < 5) criticalShort++;
            if (monthlyValue === 0) noMonthly++;
            if (annualValue >= 5 && shortValue >= 5 && monthlyValue > 0) goodBalance++;
        });
        
        // Update counters
        document.getElementById('filtered-critical-annual').textContent = criticalAnnual;
        document.getElementById('filtered-critical-short').textContent = criticalShort;
        document.getElementById('filtered-no-monthly').textContent = noMonthly;
        document.getElementById('filtered-good-balance').textContent = goodBalance;
        
        filterCount.textContent = `${filteredBalanceRows.length} employees found`;
    } else {
        // Hide statistics when no filtering is active
        statsContainer.classList.add('hidden');
    }
}

function clearBalanceFilters() {
    document.getElementById('balance-search-input').value = '';
    document.getElementById('balance-department-filter').value = '';
    document.getElementById('balance-status-filter').value = '';
    document.getElementById('balance-sort-filter').value = 'name';
    
    // Reset to show all rows
    filteredBalanceRows = [...allBalanceRows];
    updateBalanceTableDisplay();
}

function exportBalanceData() {
    // Prepare CSV data
    const csvData = [];
    
    // Add headers
    csvData.push([
        'Employee Name',
        'Employee ID',
        'Department',
        'Annual Leaves Remaining',
        'Annual Leaves Used',
        'Annual Leaves Total',
        'Short Leaves Remaining',
        'Short Leaves Used',
        'Short Leaves Total',
        'Monthly Leaves Remaining',
        'Monthly Leaves Used',
        'Monthly Half Leaves Remaining',
        'Monthly Half Leaves Used',
        'Monthly Short Leaves Remaining',
        'Monthly Short Leaves Used'
    ]);
    
    // Add data from filtered rows
    filteredBalanceRows.forEach(row => {
        const employeeName = row.querySelector('td:first-child .font-medium')?.textContent || '';
        const employeeId = row.querySelector('td:first-child .text-gray-500')?.textContent.replace('ID: ', '') || '';
        const department = row.dataset.department || '';
        
        const annualRemaining = row.querySelector('td:nth-child(2) .text-lg')?.textContent || '0';
        const annualUsed = row.querySelector('td:nth-child(2) .text-xs')?.textContent.split('/')[0] || '0';
        const annualTotal = row.querySelector('td:nth-child(2) .text-xs')?.textContent.split('/')[1]?.split(' ')[0] || '0';
        
        const shortRemaining = row.querySelector('td:nth-child(3) .text-lg')?.textContent || '0';
        const shortUsed = row.querySelector('td:nth-child(3) .text-xs')?.textContent.split('/')[0] || '0';
        const shortTotal = row.querySelector('td:nth-child(3) .text-xs')?.textContent.split('/')[1]?.split(' ')[0] || '0';
        
        const monthlyRemaining = row.querySelector('td:nth-child(4) .text-lg')?.textContent || '0';
        const monthlyUsed = row.querySelector('td:nth-child(4) .text-xs')?.textContent.split('/')[0] || '0';
        
        const halfRemaining = row.querySelector('td:nth-child(5) .text-lg')?.textContent || '0';
        const halfUsed = row.querySelector('td:nth-child(5) .text-xs')?.textContent.split('/')[0] || '0';
        
        const monthlyShortRemaining = row.querySelector('td:nth-child(6) .text-lg')?.textContent || '0';
        const monthlyShortUsed = row.querySelector('td:nth-child(6) .text-xs')?.textContent.split('/')[0] || '0';
        
        csvData.push([
            employeeName,
            employeeId,
            department,
            annualRemaining,
            annualUsed,
            annualTotal,
            shortRemaining,
            shortUsed,
            shortTotal,
            monthlyRemaining,
            monthlyUsed,
            halfRemaining,
            halfUsed,
            monthlyShortRemaining,
            monthlyShortUsed
        ]);
    });
    
    // Convert to CSV string
    const csvContent = csvData.map(row => 
        row.map(cell => `"${cell}"`).join(',')
    ).join('\n');
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `employee_leave_balances_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function applyQuickFilter(filterType) {
    // Clear existing filters
    document.getElementById('balance-search-input').value = '';
    document.getElementById('balance-department-filter').value = '';
    document.getElementById('balance-sort-filter').value = 'name';
    
    // Apply the quick filter
    if (filterType === 'all') {
        document.getElementById('balance-status-filter').value = '';
    } else {
        document.getElementById('balance-status-filter').value = filterType;
    }
    
    // Apply filters
    applyBalanceFilters();
    
    // Update active filter styling
    updateQuickFilterButtons(filterType);
}

function updateQuickFilterButtons(activeFilter) {
    // Reset all buttons
    document.querySelectorAll('[onclick^="applyQuickFilter"]').forEach(btn => {
        btn.classList.remove('ring-2', 'ring-[#184E77]');
    });
    
    // Highlight active button
    const activeButton = document.querySelector(`[onclick="applyQuickFilter('${activeFilter}')"]`);
    if (activeButton) {
        activeButton.classList.add('ring-2', 'ring-[#184E77]');
    }
}

</script>
  
  
@endsection
