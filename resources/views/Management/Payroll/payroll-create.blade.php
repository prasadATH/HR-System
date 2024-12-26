@extends('layouts.dashboard-layout')

@section('title', 'Add Payroll')

@section('content')
@if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
<form method="POST" action="{{ route('payroll.store') }}" class="p-0 m-0">
    @csrf
<div class="flex flex-col items-start justify-start w-full px-4">

    <div class="w-full pt-2">
      <div class="flex items-center justify-between w-full">
        <div class="flex ">
        <p class="text-6xl font-bold text-black nunito-">Payroll</p>
        </div>
        <div class="flex items-center space-x-4">

    
        <!-- Add Employee Button -->
        <button class="flex items-center justify-center nunito- space-x-2 px-8 py-2 text-white text-2xl bg-gradient-to-r from-[#184E77] to-[#52B69A] rounded-xl shadow-sm hover:from-[#1B5A8A] hover:to-[#60C3A8]">
        <p class="text-3xl"><i class="ri-add-fill"></i></p>
            <span>Add Record</span>
        </button>
        </div>
    
      </div>
    </div>
    <nav class="flex py-3" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3 nunito-">
        <li class="inline-flex items-center">
          <a href="#" class="inline-flex items-center text-3xl font-medium text-[#00000080] hover:text-blue-600">
          Payroll
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <p class="text-[#00000080] text-3xl"><i class="ri-arrow-right-wide-line"></i></p>
            <a href="#" class="ml-1 font-medium text-[#00000080] text-3xl hover:text-blue-600">Add New Record</a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="w-full flex flex-col justify-center items-center space-y-4">
    <div class="w-full flex justify-start items-center space-x-12 nunito-"> 
          <div class="w-full mx-auto p-6 bg-[#D9D9D966] rounded-3xl p-8 space-y-4">
          <div class="w-full flex justify-start items-center pl-16">
              <p class="text-3xl font-bold text-black">Employee Details :</p>
            </div>
            <div class="w-full flex space-x-48 px-16">
              <!-- Employee ID -->
              <div class="w-full">
                <label for="employee-id" class="block text-xl text-black font-bold">Employee ID :</label>
                <input
                  type="text"
                  id="employee-id"
                  name="employee-id"
                  placeholder="Enter your Employee ID"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
              <div class="w-full">
                <label for="work-hours" class="block text-xl text-black font-bold">Total Work Hours :</label>
                <input
                  type="number"
                  id="work-hours"
                  name="work-hours"
                  placeholder="Enter total work hours"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
             
            </div>
          </div>
         
        </div>
        <div class="w-full mx-auto bg-[#D9D9D966] rounded-3xl p-8 space-y-4 nunito-">
            <div class="w-full flex justify-start items-center">
              <p class="text-3xl font-bold text-black pl-16">Salary Details :</p>
            </div>
            <div class="w-full flex justify-between items-center space-x-48 px-16">
              <div class="w-1/2 flex flex-col space-y-4">
                 <!-- Claim Date -->
              <div>
                <label for="salary_month" class="block text-xl text-black font-bold">Month :</label>
                <input
                  type="month"
                  id="salary_month"
                  name="salary_month"
                  placeholder="Enter the month here"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] text-[#0000008C] font-bold rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
               <!-- Amount -->
               <div>
                <label for="salary_amount" class="block text-xl text-black font-bold">Salary Amount :</label>
                <input
                  type="number"
                  id="salary_amount"
                  name="salary_amount"
                  placeholder="Enter the Amount"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
               <!-- Approved By -->
               <div>
                <label for="total_payed" class="block text-xl text-black font-bold">Total amount payed :</label>
                <input
                  type="text"
                  id="total_payed"
                  name="total_payed"
                  placeholder="Enter the Amount"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
              </div>
            
            <div class="w-1/2 flex flex-col space-y-4">
               <!-- Claim Date -->
               <div>
                <label for="pay_date" class="block text-xl text-black font-bold">Pay Date :</label>
                <input
                  type="date"
                  id="pay_date"
                  name="pay_date"
                  placeholder="Enter the date here"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] text-[#0000008C] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
              <!-- Status -->
              <div>
                <label for="tax_amount" class="block text-xl text-black font-bold">Tax :</label>
                <input
                  type="number"
                  id="tax_amount"
                  name="tax_amount"
                  placeholder="Enter the tax amount"
                  class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
                />
              </div>
              <!-- Status -->
              <div>
                  <label for="payment_status" class="block text-xl text-black font-bold">Status :</label>
                  <input
                    type="text"
                    id="payment_status"
                    name="payment_status"
                    placeholder="Enter the Status"
                    class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
                  />
              </div>
    
            </div>
            </div>
            </div>
          
    <!-- Deductions Section -->
    <div class="w-full mx-auto bg-[#D9D9D966] rounded-3xl p-8 space-y-4">
        <div class="w-full flex justify-start items-center">
          <p class="text-3xl font-bold text-black pl-16">Deductions :</p>
        </div>
        <div class="w-full flex justify-center items-end space-x-48 px-16">
          <div class="w-full">
            <label for="deduction-description" class="block text-xl text-black font-bold">Description:</label>
            <textarea id="deduction-description" placeholder="Add description here" rows="1" class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"></textarea>
          </div>
          <div class="w-full flex justify-center items-end space-x-8">
            <div class="w-full">
              <label for="deduction-amount" class="block text-xl text-black font-bold">Amount :</label>
              <input type="number" id="deduction-amount" placeholder="Enter the Amount" class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"/>
            </div>
            <div>
              <button type="button" id="add-deduction" class="px-2 py-2 text-[#00000066] text-2xl bg-[#184E77] rounded-xl hover:bg-gray-200">
                <p class="text-3xl text-white"><i class="ri-add-line"></i></p>
              </button>
            </div>
          </div>
        </div>
        <div id="deduction-list" class="px-16 mt-4"></div>
      </div>
  
      <!-- Allowance Section -->
      <div class="w-full mx-auto bg-[#D9D9D966] rounded-3xl p-8 space-y-4">
        <div class="w-full flex justify-start items-center">
          <p class="text-3xl font-bold text-black pl-16">Allowance :</p>
        </div>
        <div class="w-full flex justify-center items-end space-x-48 px-16">
          <div class="w-full">
            <label for="allowance-description" class="block text-xl text-black font-bold">Description:</label>
            <textarea id="allowance-description" placeholder="Add description here" rows="1" class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"></textarea>
          </div>
          <div class="w-full flex justify-center items-end space-x-8">
            <div class="w-full">
              <label for="allowance-amount" class="block text-xl text-black font-bold">Amount :</label>
              <input type="number" id="allowance-amount" placeholder="Enter the Amount" class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"/>
            </div>
            <div>
              <button type="button" id="add-allowance" class="px-2 py-2 text-[#00000066] text-2xl bg-[#184E77] rounded-xl hover:bg-gray-200">
                <p class="text-3xl text-white"><i class="ri-add-line"></i></p>
              </button>
            </div>
          </div>
        </div>
        <div id="allowance-list" class="px-16 mt-4"></div>
      </div>
      
    </div>
  </div>
  </form>
  
  <script>document.getElementById('add-deduction').addEventListener('click', function () {
    const description = document.getElementById('deduction-description').value;
    const amount = document.getElementById('deduction-amount').value;
  
    if (description && amount) {
      const list = document.getElementById('deduction-list');
      const item = document.createElement('div');
      item.className = 'flex justify-between items-center p-2 bg-gray-100 rounded-xl mt-2';
      item.innerHTML = `
        <span class="text-xl font-bold">${description} - LKR ${amount}</span>
        <button type="button" class="text-red-500" onclick="this.parentElement.remove(); removeHiddenInput(this);">&times;</button>
      `;
      list.appendChild(item);
  
        // Create hidden inputs for form submission
        const form = document.querySelector('form');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'deductions[]'; // Group description and amount in one entry
        hiddenInput.value = JSON.stringify({ description, amount }); // Use JSON to group data
        hiddenInput.className = 'deduction-hidden';

  
    
      item.appendChild(hiddenInput);
    }
  });
  
  document.getElementById('add-allowance').addEventListener('click', function () {
    const description = document.getElementById('allowance-description').value;
    const amount = document.getElementById('allowance-amount').value;
  
    if (description && amount) {
      const list = document.getElementById('allowance-list');
      const item = document.createElement('div');
      item.className = 'flex justify-between items-center p-2 bg-gray-100 rounded-xl mt-2';
      item.innerHTML = `
        <span class="text-xl font-bold">${description} - LKR ${amount}</span>
        <button type="button" class="text-red-500" onclick="this.parentElement.remove(); removeHiddenInput(this);">&times;</button>
      `;
      list.appendChild(item);
  
      // Create hidden inputs for form submission
      const form = document.querySelector('form');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'allowances[]'; // Group description and amount in one entry
        hiddenInput.value = JSON.stringify({ description, amount }); // Use JSON to group data
        hiddenInput.className = 'allowance-hidden';
  
      item.appendChild(hiddenInput);
    }
  });
  
  // Function to remove associated hidden inputs
  function removeHiddenInput(button) {
    const hiddenInputs = button.parentElement.querySelectorAll('input[type="hidden"]');
    hiddenInputs.forEach(input => input.remove());
  }
  
  </script>
  @endsection