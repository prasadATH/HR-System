@extends('layouts.dashboard-layout')

@section('title', 'Add New Employee')

@section('content')
<div class="flex flex-col items-start justify-start w-full px-16">
<div class="w-full flex space-y-2 space-x-8 border-b-2 border-[#00000080] pb-8 pl-8 pt-8">
    <div class="flex items-center justify-center w-20 p-4 border-2 border-black rounded-full">
      <p class="text-3xl"><i class="ri-notification-4-line"></i></p>
    </div>
    <div class="flex items-center justify-center w-20 border-2 border-black rounded-full">
      <img src="{{ asset('build/assets/bg1.png') }}" class="object-cover w-8 h-12">
    </div>
    <div class="flex items-center justify-center w-20">
    <p class="text-3xl"><i class="ri-arrow-down-s-fill"></i></p>
    </div>
</div>

<nav class="flex px-5 py-3 mt-4 mb-4" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-3">
    <li class="inline-flex items-center">
      <a href="#" class="inline-flex items-center text-3xl font-medium text-[#00000080] hover:text-blue-600">
        Employee
      </a>
    </li>
    <li>
      <div class="flex items-center">
        <p class="text-[#00000080] text-3xl"><i class="ri-arrow-right-wide-line"></i></p>
        <a href="#" class="ml-1 font-medium text-[#00000080] text-3xl hover:text-blue-600">Employee Management</a>
      </div>
    </li>
  </ol>
</nav>
<div>
</div>
<form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="w-full flex space-x-32">
        <div class="w-1/2 flex flex-col justify-center items-center nunito- space-y-4 p-8 bg-[#D9D9D980] rounded-3xl">
            <div class="w-full flex">
                <div class="w-1/3 flex justify-start items-center">
                    <img id="profileImage" src="{{ asset('build/assets/profile.jpg') }}" class="w-48 h-48 rounded-full" onclick="triggerFileInput()">
                    <input type="file" name="image" id="image" style="display:none;" onchange="previewImage(event)">
                </div>
                <div class="w-2/3 flex flex-col justify-center items-start space-y-4 nunito-">
                <div class="w-3/4 space-y-4 pl-16 text-black font-bold">
                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A] " required />
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A] " required />
                    <input type="text" id="employee_id" name="employee_id" placeholder="Enter Employee ID" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A] " required />
                </div>
                </div>
            </div>
            <div class="w-full h-1/2">
                <textarea id="description" name="description" placeholder="Enter Description" rows="2" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]"></textarea>
        </div>  
    </div>

    <div class="w-1/2 flex flex-col justify-start items-start nunito- rounded-3xl">
        <div class="w-full flex justify-between items-center bg-[#D9D9D980] px-4 pt-4 rounded-t-xl">
            <p class="text-3xl font-bold text-black">Legal Documents</p>
            <label for="doc-files" class="flex items-center justify-center px-4 py-2 bg-[#184E77] border-2 border-[#52B69A80] text-white rounded-md cursor-pointer hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"> 
                <span class="iconify" data-icon="ic:sharp-upload" style="width: 16px; height: 16px;"></span>
                <span class="ml-2">Upload Files</span>
            </label>
            <!-- Visible File Input -->
            <input type="file" id="doc-files" accept="application/pdf" class="hidden" multiple />

            <!-- Hidden File Input -->
            <input type="file" name="legal_documents[]" id="hidden-files" class="hidden" multiple />
        </div>

        <div id="file-list" class="text-black text-sm w-full bg-[#D9D9D980] flex flex-col justify-end items-end rounded-b-xl pr-4 pt-4">
            <p>Attached Files:</p>
            <ul id="file-list-items"></ul>
        </div>
    </div>

  </div>
</div>


        <!-- Employment Information --> 
    <div class="w-full flex space-x-16 pt-8">
    <div tabindex="0" class="w-full flex flex-col h-auto space-y-8 p-8 bg-[#D9D9D980] rounded-3xl cursor-pointer nunito focus:outline-none focus:ring-2 focus:ring-[#52B69A] focus:border-[#184E77]">
        <div class="w-full flex pl-8">
            <p class="text-3xl font-bold text-black">Employment Information</p>
        </div>
        <div class="w-full flex">
            <div class="w-1/2 flex flex-col pl-8 space-y-8 text-[#00000080]">
                <div class="w-full flex space-x-8">
                    <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                    <p class="text-xl">Job Title</p>
                </div>
                <div class="w-full flex space-x-8">
                    <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                    <p class="text-xl">Department</p>
                </div>
                <div class="w-full flex space-x-8">
                    <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                    <p class="text-xl">Branch</p>
                </div>
                <div class="w-full flex space-x-8">
                    <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                    <p class="text-xl">Employment Type</p>
                </div>
                <div class="w-full flex space-x-8">
                    <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                    <p class="text-xl">Probation Period</p>
                </div>
            </div>
            <div class="w-3/4 space-y-4 pl-16 text-black font-bold">
                <div class="w-full">
                    <input type="text" name="title" placeholder="Enter Job Title" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
                </div>
                <div class="w-full">
                <select name="name" id="name" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                </div>
                <div class="w-full">
                    <select name="branch" id="branch" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" required>
                        <option value="">Select Branch</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->branch }}">{{ $department->branch }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="w-full">
                    <select name="employment_type" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]">
                        <option value="">Select Employment Type</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->employment_type }}">{{ $department->employment_type }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="w-full">
                    <input type="date" name="probation_start_date" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
                </div>
                <div class="w-full">
                    <input type="text" name="probation_period" placeholder="Enter Probation Period (e.g., 6 Months)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
                </div>
            </div>
    </div>
    </div>

        <!-- Personal Information --> 
        <div tabindex="0" class="w-full flex flex-col h-auto space-y-8 p-8 bg-[#D9D9D980] rounded-3xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#52B69A] focus:border-[#184E77]">
    <div class="w-full flex pl-8">
        <p class="text-3xl font-bold text-black">Personal Information</p>
    </div>
    <div class="w-full flex">
        <div class="w-1/2 flex flex-col pl-8 space-y-8 text-[#00000080]">
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="full_name" class="text-xl">Full Name</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="age" class="text-xl">Age</label>
            </div>
            <div class="w-full flex space-x-8 pt-4">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="email" class="text-xl">Email Address</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="phone" class="text-xl">Phone Number</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="gender" class="text-xl">Gender</label>
            </div>
            <div class="w-full flex space-x-8 pt-4">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="date_of_birth" class="text-xl">Date of Birth</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="address" class="text-xl">Living Address</label>
            </div>
        </div>
        <div class="w-3/4 space-y-4 pl-16 text-black font-bold">
            <div class="w-full">
                <input type="text" id="full_name" name="full_name" placeholder="Enter Full Name" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A] " required />
            </div>
            <div class="w-full">
                <input type="number" id="age" name="age" placeholder="Enter Age" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="email" id="email" name="email" placeholder="Enter Email Address" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <select id="gender" name="gender" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="w-full">
                <input type="date" id="date_of_birth" name="date_of_birth" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <textarea id="address" name="address" placeholder="Enter Living Address" rows="2" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]"></textarea>
            </div>
        </div>
    </div>
</div>
</div>

        <!-- Education and Experience --> 
        <div class="w-full flex space-x-16 pb-8 pt-8">
    <div tabindex="0" class="w-full flex flex-col h-auto space-y-8 p-8 bg-[#D9D9D980] rounded-3xl nunito cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#52B69A] focus:border-[#184E77]">
    <div class="w-full flex pl-8">
        <p class="text-3xl font-bold text-black">Education and Experience</p>
    </div>
    <div class="w-full flex">
        <div class="w-1/2 flex flex-col pl-8 space-y-8 text-[#00000080]">
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="degree" class="text-xl">Degree</label>
            </div>
            <div class="w-full flex space-x-8 pt-4">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="institution" class="text-xl">Institution</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="graduation_year" class="text-xl">Graduation Year</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="work_experience" class="text-xl">Work Experience</label>
            </div>
        </div>
        <div class="w-3/4 space-y-4 pl-16 text-black font-bold">
            <div class="w-full">
                <input type="text" id="degree" name="degree" placeholder="Enter Degree (e.g., BSc Software Engineering)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="text" id="institution" name="institution" placeholder="Enter Institution (e.g., University of Westminster)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="number" id="graduation_year" name="graduation_year" placeholder="Enter Graduation Year (e.g., 2024)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full flex flex-col space-y-2">
                <input type="text" id="work_experience_years" name="work_experience_years" placeholder="Enter Years of Work Experience (e.g., 2015 - 2020)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
                <input type="text" id="work_experience_role" name="work_experience_role" placeholder="Enter Role (e.g., Project Manager)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
                <input type="text" id="work_experience_company" name="work_experience_company" placeholder="Enter Company (e.g., IFS, Sri Lanka)" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
        </div>
    </div> 
    </div>

        <!-- Training and Certification --> 
        <div tabindex="0" class="w-full flex flex-col h-auto space-y-8 mt-8 p-8 bg-[#D9D9D980] rounded-3xl nunito cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#52B69A] focus:border-[#184E77]">
    <div class="w-full flex pl-8">
        <p class="text-3xl font-bold text-black">Training and Certification</p>
    </div>
    <div class="w-full flex">
        <div class="w-1/2 flex flex-col pl-8 space-y-8 text-[#00000080]">
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="course_name" class="text-xl">Course Name</label>
            </div>
            <div class="w-full flex space-x-8 pt-4">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="training_provider" class="text-xl">Training Provider</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="completion_date" class="text-xl">Completion Date</label>
            </div>
            <div class="w-full flex space-x-8">
                <p class="text-xl"><i class="ri-info-card-fill"></i></p>
                <label for="certification_status" class="text-xl">Certification Status</label>
            </div>
        </div>
        <div class="w-3/4 space-y-4 pl-16 text-black font-bold">
            <div class="w-full">
                <input type="text" id="course_name" name="course_name" placeholder="Enter Course Name" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="text" id="training_provider" name="training_provider" placeholder="Enter Training Provider" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <input type="date" id="completion_date" name="completion_date" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]" />
            </div>
            <div class="w-full">
                <select id="certification_status" name="certification_status" class="w-full p-2 text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#52B69A]">
                    <option value="" disabled selected>Select Certification Status</option>
                    <option value="merit">Merit</option>
                    <option value="distinction">Distinction</option>
                    <option value="pass">Pass</option>
                </select>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<button class="w-1/3 flex items-center justify-center space-x-2 px-10 py-2 text-white text-2xl bg-gradient-to-r from-[#184E77] to-[#52B69A] rounded-xl shadow-sm hover:from-[#1B5A8A] hover:to-[#60C3A8]">
        <p class="text-3xl"><i class="ri-add-fill"></i></p>
        <span>Save Employee</span>
</button>
</div>
    </form>

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
    // Trigger the file input when the image is clicked
    let selectedFiles = new DataTransfer();

    function handleFileSelection(input) {
        const files = Array.from(input.files);
        const fileListDisplay = document.getElementById('file-list-items');
        const hiddenInput = document.getElementById('hidden-files');

        files.forEach((file) => {
            selectedFiles.items.add(file);

            const listItem = document.createElement('li');
            listItem.textContent = file.name;

            const removeButton = document.createElement('span');
            removeButton.textContent = ' ✖';
            removeButton.style.color = 'red';
            removeButton.style.cursor = 'pointer';
            removeButton.style.marginLeft = '10px';
            removeButton.onclick = function () {
                removeFile(file.name);
                listItem.remove();
            };

            listItem.appendChild(removeButton);
            fileListDisplay.appendChild(listItem);
        });

        hiddenInput.files = selectedFiles.files;
        input.value = ''; // Clear the visible input to allow re-upload
    }

    function removeFile(fileName) {
        const newDataTransfer = new DataTransfer();
        Array.from(selectedFiles.files).forEach((file) => {
            if (file.name !== fileName) {
                newDataTransfer.items.add(file);
            }
        });

        selectedFiles = newDataTransfer;
        document.getElementById('hidden-files').files = selectedFiles.files;
    }

    document.getElementById('doc-files').addEventListener('change', function () {
        handleFileSelection(this);
    });


    function triggerFileInput() {
        document.getElementById('image').click();
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profileImage');
            output.src = reader.result;  // Update the image preview
        };
        reader.readAsDataURL(event.target.files[0]);  // Convert image to data URL for preview
    }

</script>
  
@endsection