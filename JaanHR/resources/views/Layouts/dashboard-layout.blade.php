<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./assetes/css/root.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <script src="https://unpkg.com/alpinejs" defer></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="w-full flex h-auto bg-[#FFFFFF]">
<div class="w-1/5 bg-[#D9D9D9] rounded-3xl pt-24 shadow-md p-8 flex flex-col justify-center items-center">
  <!-- Main Menu -->
  <div class="w-5/6 mb-6 space-y-8">
    <h2 class="text-[#00000080] font-extrabold text-4xl mb-4 nunito-">MAIN MENU</h2>
    <ul class="w-full space-y-8">
      <li class="mb-2">
        <a href="{{ route('dashboard.management') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
        <div class="flex items-center w-full space-x-4">
       
        <span class="iconify" data-icon="ic:baseline-dashboard" style="width: 16px; height: 16px;"></span>
            <span id="dashboard" class="text-2xl text-black nunito-" style="font-weight: 700;">Dashboard</span>

            </div>
        </a>
      </li>
      <li class="mb-2">
        <a href="{{route('department.management')}}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
        <div class="flex items-center w-full space-x-4">
        <span class="iconify" data-icon="fluent-emoji-high-contrast:department-store" style="width: 16px; height: 16px;"></span>
            <span id="Departments" class="text-2xl font-bold text-black nunito-" style="font-weight: 700;">Departments</span>
        </div>
        </a>
      </li>
      <li>
      <a href="{{ route('employee.management') }}"> 
        <button class="flex items-center justify-between w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('employeeMenu'); toggleGradientText1()">
            <div class="flex items-center w-full space-x-4">
            <span class="iconify" data-icon="ic:round-man" style="width: 16px; height: 16px;"></span>
            <p id="EmployeeText" class="text-2xl font-bold text-black transition-all duration-300 cursor-pointer nunito-" style="font-weight: 700;">Employee</p>
            </div>
          <p class="text-xl text-black"><i class="ri-arrow-down-s-line"></i></p>
        </button>
        </a>
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
              <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">Option 1</a>
              <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Option 2</a>
              </div>
            </div>
            </div>
        </ul>
      </li>
    </ul>
  </div>

   <!-- Finance -->
  <div class="w-5/6 pt-4 mb-6 space-y-8">
  <h2 class="text-[#00000080] font-bold text-4xl mb-4 nunito-">FINANCE</h2>
  <ul class="w-full space-y-8">
    <!-- Payroll -->
    <li class="w-full space-y-4">
    <button class="flex items-center justify-between w-full text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('payrollMenu'); toggleGradientText()">
      <div class="flex items-center w-full space-x-4">
      <span class="iconify" data-icon="fluent:reciept-20-filled" style="width: 16px; height: 16px;"></span>
        <a href="{{ route('payroll.management') }}"> 
        <p id="payrollText" class="text-2xl font-bold text-black transition-all duration-300 cursor-pointer nunito-" style="font-weight: 700;">Payroll</p>
        </a>
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
      <a href="{{ route('advance.management') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
      <span class="iconify" data-icon="majesticons:money" style="width: 16px; height: 16px;"></span>
        <span id="Loan" class="text-2xl font-bold text-black nunito-" style="font-weight: 700;">Advance</span>
      </a>
    </li>
    <!-- Expenses Claim -->
    <li>
      <button class="flex items-center justify-between w-full text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('expensesMenu'); toggleGradientText2()">
        <div class="flex items-center w-full space-x-4">
        <span class="iconify" data-icon="material-symbols-light:list-alt" style="width: 16px; height: 16px;"></span>
          <a href="{{ route('expense.management') }}">
          <p id="ExpensesText" class="text-2xl font-bold text-black transition-all duration-300 cursor-pointer nunito-" style="font-weight: 700;">Expenses</p>
          </a>
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
              <a href="#" class="text-[#0F5A80] hover:text-blue-500 font-semibold nunito-">View records</a>
              <a href="#" class="font-medium text-black hover:text-blue-500 nunito-">Option 2</a>
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
    <h2 class="text-[#00000080] font-bold text-4xl mb-4 nunito-">OTHER</h2>
    <ul class="w-full space-y-8">
      <li>
        <button class="flex items-center w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('attendanceMenu'); toggleGradientText3()">
        <div class="flex items-center w-full space-x-4">
        <span class="iconify" data-icon="uil:calender" style="width: 16px; height: 16px;"></span>
        <a href="{{ route('attendance.management') }}">
        <p id="AttendanceText" class="text-2xl font-bold text-black transition-all duration-300 cursor-pointer nunito-" style="font-weight: 700;">Attendance</p>
        </a>  
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
        <button class="flex items-center justify-between w-full space-x-2 text-gray-600 hover:text-blue-500 focus:outline-none" onclick="toggleMenu('leavesMenu'); toggleGradientText4()">
        <div class="flex items-center w-full space-x-4">
        <span class="iconify" data-icon="simple-line-icons:calender" style="width: 16px; height: 16px;"></span>
        <a href="{{ route('leave.management') }}"> 
        <p id="LeaveText" class="text-2xl font-bold text-black transition-all duration-300 cursor-pointer nunito-" style="font-weight: 700;">Leave</p>
      </a>    
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
      <li><a href="{{ route('incident.management') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500"><span class="iconify" data-icon="material-symbols:event-list" style="width: 16px; height: 16px;"></span>
      <span id="Incident" class="text-2xl font-bold text-black nunito-" style="font-weight: 700;">Incident</span></a></li>

      <li><a href="{{ route('employees.hierarchy') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500"><span class="iconify" data-icon="hugeicons:structure-03" style="width: 16px; height: 16px;"></span>
      <span class="text-2xl font-bold text-black nunito-" style="font-weight: 700;">Company Structure</span></a></li>
      <a href="{{route('setting.management')}}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500">
      <span class="iconify" data-icon="proicons:settings" style="width: 16px; height: 16px;"></span>
    <span class="text-2xl font-bold text-black nunito-">Settings</span>
    </a>
  
    </ul>
  </div>

  <!-- Settings and Help -->
  <div class="w-5/6 mt-auto space-y-8">

  </div>
</div>




        <!-- Main Content -->
        <div class="w-4/5 flex flex-col p-8">
            <div class="flex items-center justify-between  border-b border-gray-200">
                <h1 class="text-3xl font-bold">@yield('title', 'Dashboard')</h1>
            
                <div class="w-1/7 flex space-y-2 space-x-8  pb-8 pl-8 pt-8 align-right justify-center">

    <div class="flex items-center justify-center w-24 h-24 p-4 border-2 border-black rounded-full mt-2">
      <p class="text-5xl"><span class="iconify" data-icon="ic:round-notifications-active" style="width: 50px;"></span></p>
    </div>
    <div class="relative">
    <!-- Trigger for dropdown -->
    <div class="flex items-center justify-center space-x-2 cursor-pointer" onclick="toggleDropdown()">
    <!-- Rounded image -->
    <img src="/bg1.png" class=" flex justify-center rounded-full w-24 h-24 object-cover"> <!-- Adjusted width and height for a square shape to maintain roundness -->

    <!-- Arrow icon -->
    <div class="flex items-center justify-center">
        <p class="text-3xl"><i class="ri-arrow-down-s-fill"></i></p>
    </div>
</div>

    <!-- Dropdown Menu -->
    <div class="hidden absolute right-0 w-60 bg-white rounded-md shadow-lg mt-2" id="userDropdown">
        <div class="py-2 px-4 text-gray-700 border-b">
        <div class="font-bold">
            Logged in as:
            </div>
            <div>{{ Auth::user()->name }}</div>
            <div>{{ Auth::user()->email }}</div>
        </div>
    <form method="POST" action="{{ route('logout') }}" class="p-0 m-0">
                    @csrf
                    <button class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
                  </div>
</div>

</div>
            </div>
            <div class="pt-6">
                                  <!-- Notification -->
    <div id="notification" class="notification bg-success text-white p-3 rounded shadow">
        <span id="notification-message"></span>
    </div>
                @yield('content')

            </div>
        </div>
    </div>

    <script>

function toggleDropdown() {
    var dropdown = document.getElementById("userDropdown");
    dropdown.classList.toggle("hidden");
}
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('hidden');
        }
    </script>

<script>
    function showNotification(message) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');
        notificationMessage.textContent = message;
        notification.classList.add('show');

        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
</script>

@if (session('notification'))
<script>
    // Display notification from session
    showNotification("{{ session('notification') }}");
</script>
@endif

<style>
.notification { 
    position: fixed;
    top: -100px; /* Start above the viewport */
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(to right, #184E77, #52B69A); /* Gradient background */
    color: white; /* Text color */
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.5s ease-in-out; /* Smooth transition */
    z-index: 1050; /* Ensure it appears on top */
}

.notification.show {
    top: 20px; /* Enter into the viewport */
}
.notification.hide {
    top: -100px; /* Exit to the top */
}

    </style>


<script>
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
  function toggleGradientText1() {
    const textElement = document.getElementById('EmployeeText');
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
  function toggleGradientText2() {
    const textElement = document.getElementById('ExpensesText');
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
  function toggleGradientText3() {
    const textElement = document.getElementById('AttendanceText');
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
  function toggleGradientText4() {
    const textElement = document.getElementById('LeaveText');
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
  const textElements = document.querySelectorAll('span.text-xl');

textElements.forEach((element) => {
    element.addEventListener('click', function () {
        // Reset all text elements to black
        textElements.forEach((el) => {
            el.classList.remove('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
            el.classList.add('text-black');
        });

        // Apply gradient to the clicked element
        this.classList.remove('text-black');
        this.classList.add('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    });
});

const textElements1 = document.querySelectorAll('span.text-xl');

textElements.forEach((element) => {
    element.addEventListener('click', function () {
        // Reset all text elements to black
        textElements.forEach((el) => {
            el.classList.remove('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
            el.classList.add('text-black');
        });

        // Apply gradient to the clicked element
        this.classList.remove('text-black');
        this.classList.add('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    });
});
const textElements2 = document.querySelectorAll('span.text-xl');

textElements.forEach((element) => {
    element.addEventListener('click', function () {
        // Reset all text elements to black
        textElements.forEach((el) => {
            el.classList.remove('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
            el.classList.add('text-black');
        });

        // Apply gradient to the clicked element
        this.classList.remove('text-black');
        this.classList.add('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    });
});

const textElements3 = document.querySelectorAll('span.text-xl');

textElements.forEach((element) => {
    element.addEventListener('click', function () {
        // Reset all text elements to black
        textElements.forEach((el) => {
            el.classList.remove('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
            el.classList.add('text-black');
        });

        // Apply gradient to the clicked element
        this.classList.remove('text-black');
        this.classList.add('bg-gradient-to-r', 'from-[#184E77]', 'to-[#52B69A]', 'text-transparent', 'bg-clip-text');
    });
});

</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
