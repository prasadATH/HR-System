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
                   oninput="fetchContributions()"
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
            
  <div id="contributions-table" class="mt-4 bg-gray-100 p-4 rounded-lg hidden">
    <h3 class="text-xl font-bold mb-2">Employee Contributions</h3>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-2 py-1">EPF Number</th>
                <th class="border border-gray-300 px-2 py-1">ETF Number</th>
                <th class="border border-gray-300 px-2 py-1">Basic Salary</th>
                <th class="border border-gray-300 px-2 py-1">Total EPF</th>
                <th class="border border-gray-300 px-2 py-1">Total ETF</th>
            </tr>
        </thead>
        <tbody id="contributions-body">
            <!-- Rows will be populated dynamically -->
        </tbody>
    </table>
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
                <label for="salary_amount" class="block text-xl text-black font-bold">Basic Salary :</label>
                <input
                  type="number"
                  id="salary_amount"
                  name="salary_amount"
                  readonly
                  placeholder="Enter ID to load salary"
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
                  readonly
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
            <!-- Status -->
            <div class="w-1/2 flex flex-col justify-start items-start pr-24 pl-16">
              <label for="bonus" class="block text-xl text-black font-bold">Bonus :</label>
              <input
                type="number"
                id="bonus"
                name="bonus"
                placeholder="Enter the amount"
                class="mt-1 block w-full px-3 py-2 border-2 border-[#1C1B1F80] font-bold shadow-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 text-xl"
              />
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

  
  <script>
    document.getElementById('add-deduction').addEventListener('click', function () {
    const description = document.getElementById('deduction-description').value;
    const amount = parseFloat(document.getElementById('deduction-amount').value) || 0;

    if (description && amount) {
        const list = document.getElementById('deduction-list');
        const item = document.createElement('div');
        item.className = 'flex justify-between items-center p-2 bg-gray-100 rounded-xl mt-2';
        item.innerHTML = `
            <span class="text-xl font-bold">${description} - LKR ${amount.toFixed(2)}</span>
            <button type="button" class="text-red-500" onclick="this.parentElement.remove(); updateTotalPayable();">&times;</button>
        `;

        // Create hidden input for deduction
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'deductions[]';
        hiddenInput.value = JSON.stringify({ description, amount });
        item.appendChild(hiddenInput);

        list.appendChild(item);
        updateTotalPayable(); // Update total payable
    }
});

document.getElementById('add-allowance').addEventListener('click', function () {
    const description = document.getElementById('allowance-description').value;
    const amount = parseFloat(document.getElementById('allowance-amount').value) || 0;

    if (description && amount) {
        const list = document.getElementById('allowance-list');
        const item = document.createElement('div');
        item.className = 'flex justify-between items-center p-2 bg-gray-100 rounded-xl mt-2';
        item.innerHTML = `
            <span class="text-xl font-bold">${description} - LKR ${amount.toFixed(2)}</span>
            <button type="button" class="text-red-500" onclick="this.parentElement.remove(); updateTotalPayable();">&times;</button>
        `;

        // Create hidden input for allowance
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'allowances[]';
        hiddenInput.value = JSON.stringify({ description, amount });
        item.appendChild(hiddenInput);

        list.appendChild(item);
        updateTotalPayable(); // Update total payable
    }
});

  
  // Function to remove associated hidden inputs
  function removeHiddenInput(button) {
    const hiddenInputs = button.parentElement.querySelectorAll('input[type="hidden"]');
    hiddenInputs.forEach(input => input.remove());
  }
  

  function fetchContributions() {
    const employeeId = document.getElementById('employee-id').value;
    const contributionsTable = document.getElementById('contributions-table');
    const contributionsBody = document.getElementById('contributions-body');
    const salaryAmountField = document.getElementById('salary_amount');

    if (!employeeId) {
        contributionsTable.classList.add('hidden');
        salaryAmountField.value = '';
        updateTotalPayable();
        return;
    }

    fetch(`contributions/contributions/${employeeId}`)
        .then(response => response.json())
        .then(data => {
            contributionsBody.innerHTML = '';
            if (data.length > 0) {
                salaryAmountField.value = data[0].basic_salary || 0;
                data.forEach(contribution => {
                    const row = `
                        <tr>
                            <td class="border border-gray-300 px-2 py-1">${contribution.epf_number}</td>
                            <td class="border border-gray-300 px-2 py-1">${contribution.etf_number}</td>
                            <td class="border border-gray-300 px-2 py-1">${contribution.basic_salary}</td>
                            <td class="border border-gray-300 px-2 py-1">${contribution.total_epf_contributed}</td>
                            <td class="border border-gray-300 px-2 py-1">${contribution.total_etf_contributed}</td>
                        </tr>
                    `;
                    contributionsBody.innerHTML += row;
                });
                contributionsTable.classList.remove('hidden');
                updateTotalPayable();
            } else {
                contributionsBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center border border-gray-300 px-2 py-1">No contributions found for this employee.</td>
                    </tr>
                `;
                contributionsTable.classList.remove('hidden');
                updateTotalPayable();
            }
        })
        .catch(error => {
            console.error('Error fetching contributions:', error);
        });
}

function updateTotalPayable() {
    const basicSalary = parseFloat(document.getElementById('salary_amount').value) || 0;
    const allowances = [...document.querySelectorAll('#allowance-list input[type="hidden"]')]
        .reduce((total, input) => total + JSON.parse(input.value).amount, 0);
    const deductions = [...document.querySelectorAll('#deduction-list input[type="hidden"]')]
        .reduce((total, input) => total + JSON.parse(input.value).amount, 0);
    const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    const bonus = parseFloat(document.getElementById('bonus').value) || 0;

    // EPF 8% deduction
    const epfDeduction = (basicSalary * 8) / 100;
    //const etfDeduction = (basicSalary * 3) / 100;

    // Calculate Total Payable
    const totalPayable = basicSalary + allowances - deductions - tax - epfDeduction + bonus;

    // Update Total Payable Field
    document.getElementById('total_payed').value = totalPayable.toFixed(2);
}

// Attach Event Listeners
document.getElementById('bonus').addEventListener('input', updateTotalPayable);
document.getElementById('tax_amount').addEventListener('input', updateTotalPayable);
document.getElementById('deduction-amount').addEventListener('input', updateTotalPayable);
document.getElementById('allowance-amount').addEventListener('input', updateTotalPayable);

  </script>
  @endsection