@extends('layouts.dashboard-layout')

@section('title', 'Edit Payroll')

@section('content')
<div class="w-full flex h-auto bg-[#FFFFFF]">
    <div class="w-1/5 bg-[#D9D9D9] rounded-3xl pt-24 shadow-md p-8 flex flex-col justify-center items-center">
      <!-- Main Menu -->
      <div class="w-5/6 mb-6 space-y-8">
        <h2 class="text-[#00000080] font-extrabold text-2xl mb-4 nunito-">MAIN MENU</h2>
        <ul class="w-full space-y-8">
          <li class="mb-2">
            <a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
            <div class="flex items-center w-full space-x-4">
              <span class="iconify" data-icon="ic:baseline-dashboard" style="width: 16px; height: 16px;"></span>
              <span id="dashboard" class="text-xl font-extrabold text-black nunito-">Dashboard</span>
                </div>
            </a>
          </li>
          <li class="mb-2">
            <a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
            <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="fluent-emoji-high-contrast:department-store" style="width: 16px; height: 16px;"></span>
                <span id="Departments" class="text-xl font-bold text-black nunito-">Departments</span>
            </div>
            </a>
          </li>
          <li>
            <button class="flex items-center justify-between w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('employeeMenu')">
                <div class="flex items-center w-full space-x-4">
                <span class="iconify" data-icon="ic:round-man" style="width: 16px; height: 16px;"></span>
                <p class="text-xl font-bold text-black nunito-">Employee</p>
                </div>
              <p class="text-xl text-black"><i class="ri-arrow-down-s-line"></i></p>
            </button>
            <ul id="employeeMenu" class="hidden pl-6 space-y-2">
            <div class="flex items-center">
                <!-- Timeline -->
                <div class="flex flex-col items-center">
                  <div class="w-2 h-2 rounded-full bg-gradient-to-b from-blue-600 to-teal-400"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <!-- Labels -->
                <div class="ml-4">
                  <div class="flex flex-col space-y-6">
                  <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Expense 1</a>
                  <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Expense 2</a>
                  </div>
                </div>
                </div>
            </ul>
          </li>
        </ul>
      </div>
    
       <!-- Finance -->
      <div class="w-5/6 pt-4 mb-6 space-y-8">
      <h2 class="text-[#00000080] font-bold text-2xl mb-4 nunito-">FINANCE</h2>
      <ul class="w-full space-y-8">
        <!-- Payroll -->
        <li class="w-full space-y-4">
        <button class="flex items-center justify-between w-full text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('payrollMenu'); toggleGradientText()">
          <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="fluent:reciept-20-filled" style="width: 16px; height: 16px;"></span>
            <p id="payrollText" class="text-xl font-bold text-black transition-all duration-300 cursor-pointer nunito-">Payroll</p>
          </div>
          <p class="text-xl text-blue-500"><i class="ri-arrow-down-s-line"></i></p>
        </button>
    
          
          <div id="payrollMenu" class="hidden pl-6">
      <div class="flex items-center">
        <!-- Timeline -->
        <div class="flex flex-col items-center">
          <div class="w-2 h-2 rounded-full bg-gradient-to-b from-blue-600 to-teal-400"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
        </div>
        <!-- Labels -->
        <div class="ml-4">
          <div class="flex flex-col space-y-6">
            <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Department Wise</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Salary Components</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Processing Details</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Reports</a>
          </div>
        </div>
      </div>
    </div>
    
        </li>
        <!-- Loan -->
        <li class="mb-2">
          <a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
          <span class="iconify" data-icon="majesticons:money" style="width: 16px; height: 16px;"></span>
          <span id="Loan" class="text-xl font-bold text-black nunito-">Loan</span>
          </a>
        </li>
        <!-- Expenses Claim -->
        <li>
          <button class="flex items-center justify-between w-full text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('expensesMenu')">
            <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="material-symbols-light:list-alt" style="width: 16px; height: 16px;"></span>
              <p class="text-xl font-bold text-black nunito-">Expenses Claim</p>
            </div>
            <p class="text-xl text-blue-500"><i class="ri-arrow-down-s-line"></i></p>
          </button>
          <div id="expensesMenu" class="hidden pl-6">
            <div class="flex items-center">
              
              <!-- Labels -->
              <div class="flex items-center">
                <!-- Timeline -->
                <div class="flex flex-col items-center">
                  <div class="w-2 h-2 rounded-full bg-gradient-to-b from-blue-600 to-teal-400"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <!-- Labels -->
                <div class="ml-4">
                  <div class="flex flex-col space-y-6">
                  <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Expense 1</a>
                  <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Expense 2</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    
      <!-- Other Menu -->
      <div class="w-5/6 pt-4 mb-6 space-y-8">
        <h2 class="text-[#00000080] font-bold text-2xl mb-4 nunito-">OTHER MENU</h2>
        <ul class="w-full space-y-8">
          <li>
            <button class="flex items-center w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('attendanceMenu')">
            <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="uil:calender" style="width: 16px; height: 16px;"></span>
            <p class="text-xl font-bold text-black nunito-">Attendance</p>
            </div>
            <p class="text-xl text-black"><i class="ri-arrow-down-s-line"></i></p>
            </button>
            
            <div id="attendanceMenu" class="flex items-center hidden">
        <!-- Timeline -->
        <div class="flex flex-col items-center">
          <div class="w-2 h-2 rounded-full bg-gradient-to-b from-blue-600 to-teal-400"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
          <div class="w-1 h-10 bg-black"></div>
          <div class="w-2 h-2 bg-black rounded-full"></div>
        </div>
        <!-- Labels -->
        <div class="ml-4">
          <div class="flex flex-col space-y-6">
            <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Department Wise</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Salary Components</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Processing Details</a>
            <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Reports</a>
          </div>
        </div>
      </div>
          </li>
          <li>
            <button class="flex items-center justify-between w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('leavesMenu')">
            <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="simple-line-icons:calender" style="width: 16px; height: 16px;"></span>
            <p id="LeaveText" class="text-xl font-bold text-black transition-all duration-300 cursor-pointer nunito-">Leave</p>
                </div>
            <p class="text-xl text-black"><i class="ri-arrow-down-s-line"></i></p>
            </button>
            <ul id="leavesMenu" class="hidden pl-6 space-y-2">
            <div class="flex items-center">
                <!-- Timeline -->
                <div class="flex flex-col items-center">
                  <div class="w-2 h-2 rounded-full bg-gradient-to-b from-blue-600 to-teal-400"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                  <div class="w-1 h-10 bg-black"></div>
                  <div class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <!-- Labels -->
                <div class="ml-4">
                  <div class="flex flex-col space-y-6">
                  <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Expense 1</a>
                  <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Expense 2</a>
                  </div>
                </div>
              </div>
              
            </ul>
          </li>
          <li><a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500"><span class="iconify" data-icon="material-symbols:event-list" style="width: 16px; height: 16px;"></span>
          <span id="Incident" class="text-xl font-bold text-black nunito-">Incident</span></a></li>
          <li><a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500"><span class="iconify" data-icon="hugeicons:job-search" style="width: 16px; height: 16px;"></span>
          <span class="text-xl font-bold text-black nunito-">Jobs</span></a></li>
          <li><a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500"><span class="iconify" data-icon="hugeicons:structure-03" style="width: 16px; height: 16px;"></span>
          <span class="text-xl font-bold text-black nunito-">Company Structure</span></a></li>
        </ul>
      </div>
    
      <!-- Settings and Help -->
      <div class="w-5/6 mt-auto space-y-8">
        <a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
        <span class="iconify" data-icon="proicons:settings" style="width: 16px; height: 16px;"></span>
        <span class="text-xl font-bold text-black nunito-">Settings</span>
        </a>
        <a href="#" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
        <span class="iconify" data-icon="cuida:help-outline" style="width: 16px; height: 16px;"></span>
        <span class="text-xl font-bold text-black nunito-">Help & Center</span>
        </a>
      </div>
    </div>
    <div class="flex flex-col items-start justify-start w-full px-16">
    <div class="w-full flex space-y-2 space-x-8 border-b-2 border-[#00000080] pb-8 pl-8 pt-8">
      <div class="flex w-5/6">
      <input id="input-field" type="text" placeholder="Search employee here" class="w-full px-4 py-2 border-2 border-[#00000080] text-2xl text-[#00000080] rounded-xl"/>
      </div>
        <div class="flex items-center justify-center w-20 p-4 border-2 border-black rounded-full">
          <p class="text-3xl"><i class="ri-notification-4-line"></i></p>
        </div>
        <div class="flex items-center justify-center w-20 border-2 border-black rounded-full">
          <img src="./assetes/image/bg1.png" class="object-cover w-8 h-12">
        </div>
        <div class="flex items-center justify-center w-20">
        <p class="text-3xl"><i class="ri-arrow-down-s-fill"></i></p>
        </div>
    </div>
    <div class="w-full pt-8">
      <div class="flex items-center justify-between w-full">
        <div class="flex ">
        <p class="text-6xl font-bold text-black nunito-">Payroll</p>
        </div>
        <div class="flex items-center space-x-4">
        <!-- Filter Button -->
        <button class="flex items-center justify-between px-4 py-2 text-[#00000066] text-2xl bg-[#D9D9D980] border-2 border-[#D9D9D980] rounded-md hover:bg-gray-200">
            <p class="text-3xl"><i class="ri-filter-2-line"></i></p>
            <span>Filter</span>
            <p class="text-3xl text-[#00000066]"><i class="ri-arrow-down-s-line"></i></p>
        </button>
    
        <!-- Add Employee Button -->
        <button class="flex items-center justify-center nunito- space-x-2 px-8 py-2 text-white text-2xl bg-gradient-to-r from-[#184E77] to-[#52B69A] rounded-xl shadow-sm hover:from-[#1B5A8A] hover:to-[#60C3A8]">
        <p class="text-3xl"><i class="ri-add-fill"></i></p>
            <span>Add Expenses</span>
        </button>
        </div>
    
      </div>
    </div>
    <nav class="flex py-3" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3 nunito-">
        <li class="inline-flex items-center">
          <a href="#" class="inline-flex items-center text-3xl font-medium text-[#00000080] hover:text-blue-600">
          Attendance
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <p class="text-[#00000080] text-3xl"><i class="ri-arrow-right-wide-line"></i></p>
            <a href="#" class="ml-1 font-medium text-[#00000080] text-3xl hover:text-blue-600">Employee Attendance</a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="w-full flex nunito- pt-8">
    <div class="w-1/2 flex flex-col space-y-8">
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Employee Name :</p>
            <p class="text-2xl text-black font-bold">Sumanapala Athukorala Sumanapala</p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Employee ID :</p>
            <p class="text-2xl text-black font-bold">23456789345</p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Employee Department :</p>
            <p class="text-2xl text-black font-bold">UI / UX Department</p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Total work hours :</p>
            <p class="text-2xl text-black font-bold">234 hrs</p>
        </div>
        
    </div>
    <div class="w-1/2 flex flex-col space-y-8">
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Account Holder Name :</p>
            <p class="text-2xl text-black font-bold">Sumanapala Athukorala Sumanapala</p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Account No :</p>
            <p class="text-2xl text-black font-bold">23456789345</p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Bank :</p>
            <p class="text-2xl text-black font-bold">Sampath Bank </p>
        </div>
        <div class="w-full flex flex-col space-y-4">
            <p class="text-2xl text-[#00000099] font-bold">Branch :</p>
            <p class="text-2xl text-black font-bold">234 hrs</p>
        </div>
    
    </div>
    </div>
    <table class="w-full border border-[#00000033] nunito- mt-8" style="border-spacing: 0 10px; table-layout: fixed; width: 100%;">
      <thead>
        <tr class="bg-white border-b border-[#00000033]">
          <th class="text-xl text-black font-bold px-4 py-2 bg-[#D9D9D9] text-left align-middle border-r border-[#00000033]">Description</th>
          <th class="text-xl text-black font-bold px-4 py-2 bg-[#D9D9D9] text-right align-middle border-r border-[#00000033]">Earnings</th>
          <th class="text-xl text-black font-bold px-4 py-2 bg-[#D9D9D9] text-right align-middle">Deductions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-xl text-black px-4 py-2 pt-8 text-left align-middle">
            Salary Amount
          </td>
          <td class="text-xl text-black px-4 py-2 pt-8 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 pt-8 text-right align-middle"></td>
        </tr>
        <tr>
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
            Basic Salary
          </td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle"></td>
        </tr>
        <tr>
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
            Medical Allowance
          </td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle"></td>
        </tr>
        <tr>
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
          Bonus</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle"></td>
        </tr>
        <tr>
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
          Loan
          </td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">8,000/=</td>
        </tr>
        <tr class="border-t border-[#00000033]">
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
          Tax
          </td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">8,000/=</td>
        </tr>
        <tr class="border border-[#00000033]">
          <td class="text-xl text-black px-4 py-2 text-left align-middle">
          Total
          </td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">17,000 /=</td>
          <td class="text-xl text-black px-4 py-2 text-right align-middle">8,000/=</td>
        </tr>
      </tbody>
    </table>
    
    </div>
    </div>
    <style>
       td {
        position: relative; /* Required for pseudo-element positioning */
      }
    
      td::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 1px; /* Line thickness */
        background-color: #00000033; /* Line color */
      }
    
      /* Remove the line for the last column to avoid duplicate lines */
      tr td:last-child::after {
        display: none;
      }
    </style>
    
@endsection
