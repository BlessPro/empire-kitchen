<x-layouts.adminapp>
    <x-slot name="header">

        <style>

.feather {
    fill: none;
    transition: all 0.3s;
  }
  .group:hover .feather {
    fill: currentColor;
  }

  input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    height: 20px;
    width: 20px;
    background-color: white;
    border: 2px solid #ccd6dd;
    border-radius: 6px;
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: all 0.2s ease;
  }

  input[type="checkbox"]:checked {
    background-color: #3b82f6; /* Tailwind blue-500 */
    border-color: #3b82f6;
  }

  input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 6px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
  }

  input[type="checkbox"]:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); /* subtle blue ring */
  }

            </style>
        <main class="flex-1  items-center ">

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">
             <h2 class="text-[25px] font-semi-bold text-gray-900 "> Overview </h2>
           </div>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
             <div class="bg-white p-4 rounded-[30px] shadow">
               <div class="flex items-start justify-between mb-6">
                 <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Total Incoming Clients</h2>
                       <!-- Doughnut Chart  -->

                 <div>
                   <select id="month" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                   </select>

                 </div>
               </div>


               <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 <!-- Chart -->

                 <div class="flex justify-center items-center w-[200px] h-[200px] mx-auto">
                   <canvas id="clientsChart"  class="w-full h-full"></canvas>
                 </div>

                 <!-- Legend -->
                 <ul class="space-y-4 items-center">
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-full bg-orange-500 mr-3"></span>
                     <span class="text-gray-800">New Clients (5)</span>
                   </li>
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-purple-900 mr-3"></span>
                     <span class="text-gray-800">Schd. Measurements (10)</span>
                   </li>
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                     <span class="text-gray-800">Pending Designs (7)</span>
                   </li>
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-yellow-400 mr-3"></span>
                     <span class="text-gray-800">Quotes (9)</span>
                   </li>
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-blue-500 mr-3"></span>
                     <span class="text-gray-800">Payments (6)</span>
                   </li>
                 </ul>
               </div>
             </div>

             <!--the pipeline bar chart begins-->
             <div class="bg-white p-4 rounded-[30px] shadow">

             <div class="flex items-center justify-between space-x-6 px-5 py-2">
               <h2 class="font-medium text-[14px] text-gray-900">Project Pipeline</h2>

               <div class="flex items-center space-x-6">
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 rounded-full bg-orange-400"></span>
                   <span class="text-sm text-gray-700">Measurement</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                   <span class="text-sm text-gray-700">Design</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 rounded-full bg-green-500"></span>
                   <span class="text-sm text-gray-700">Installation</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 rounded-full bg-purple-400"></span>
                   <span class="text-sm text-gray-700">Payment</span>
                 </div>
               </div>
             </div>

                 <canvas id="ProjectsPipeline"  class="w-full h-full"></canvas>
             </div>
           <!--the pipeline bar chart begins-->
           </div>

           <!-- Projects Table -->
           <div class="px-5 py-5 text-[25px] font-semi-bold text-gray-900" > <h1>My Projects</h1></div>

           <div class="bg-white rounded-[20px] shadow">

             <div class="flex justify-between items-center pt-4 pb-5 pr-6 pl-6">
               <p class="text-gray-600 text-10px font-normal">Easily manage your projects here</p>
               <div class="flex gap-3">
                 <button class="flex items-center gap-2 px-4 py-2 border rounded-full border-gray-300 text-gray-700 text-sm">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6h4M6 10h12M6 14h12M10 18h4" />
                   </svg>
                   Filter
                 </button>
                 <button class="flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-800 border border-purple-800 rounded-full text-sm font-semibold">
                   Export
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 8v4m0-4l-2 2m2-2l2 2" />
                   </svg>
                 </button>
               </div>
             </div>


                  <!--My projects table begins-->
                   <table class="min-w-full text-left">
                     <thead class="bg-gray-100 text-sm text-gray-600">
                       <tr>
                         <th class="p-4 font-medium">
                           <input type="checkbox" id="selectAll" />
                         </th>
                         <th class="p-4 font-mediumt text-[15px]">Project Name</th>
                         <th class="p-4 font-mediumt text-[15px]">Status</th>
                         <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                         <th class="p-4 font-mediumt text-[15px]">Duration</th>
                         <th class="p-4 font-mediumt text-[15px]">Cost</th>
                         <th class="p-4 font-mediumt text-[15px]"></th>
                       </tr>
                     </thead>
                     <tbody class="text-gray-700">

                     </tbody>
                   </table>
                   <div class="mt-6 flex  flex justify-between items-center  pb-5 pr-6 pl-6">
                     <p class="text-sm text-gray-500 results-text">Showing 1 to 3 of 50 results</p>
                     <nav class="flex items-center gap-1">
                       <button id="prevPage" class="px-3 py-1.5 rounded-md border text-sm text-gray-500 hover:bg-gray-100 disabled:opacity-50">
                         Previous
                       </button>
                       <button id="nextPage" class="px-3 py-1.5 rounded-md border text-sm text-gray-500 hover:bg-gray-100">
                         Next
                       </button>
                     </nav>
                   </div>


           </div>
         </div>
         </main>
         @vite(['resources/js/app.js'])

    </x-slot>


<script>
    import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// This file contains the JavaScript code for the admin dashboard page.
// It includes functionality for charts, table pagination, and a month filter.
// It uses Chart.js for charting and Feather Icons for icon rendering.
feather.replace();
//variables for the charts
const ctx = document.getElementById('clientsChart').getContext('2d');
//variales for the pipeline chart
const pipeline_chart=document.getElementById('ProjectsPipeline').getContext('2d');
//initializing the barcharts
new Chart(pipeline_chart, {
type: 'bar',
data: {
  labels: ['Smith', 'New build', 'Lake view home project', 'Johnson Remodel'],

  datasets: [{
    data: [5, 10, 25, 9, 6],
    label: "Shadow",
    backgroundColor: ['#FFA500', '#0065D2', '#14BA6D', '#AF52DE', ],
    borderWidth: 1,
      borderColor: '#fff',
      hoverOffset: 8,
      borderRadius: 10,
      spacing: 4,
          // Controls individual bar thickness relative to the category width
       barPercentage: 0.6,      // default is 0.9

    // Controls how much space each category takes
       categoryPercentage: 0.7, // default is 0.8

  }]
},
options: {
plugins: {
legend: {
  display: false // hides legend under chart
}
},
scales: {
x: {
  grid: {
    display:false,
    borderDash: [4, 4], // makes X axis grid dashed
    color: "rgba(0,0,0,0.1)"
  },
  ticks: {
    color: "#4B5563", // Tailwind gray-700
    font: {
      size: 12
    }
  }
},
y: {
  grid: {
    display:true,
    borderDash: [4, 4], //  makes Y axis grid dashed
    color: "rgba(0,0,0,0.1)"
  },
  ticks: {
    stepSize: 5,
    color: "#4B5563",
    font: {
      size: 12
    }
  }
}
}
}
});

//   options: {
//     plugins: {
//       legend: {
//         display: false,
//         position: 'false',
//         borderRadius: 5,


//       },


//     }
//   }
// });
//initializing the doughnut chart
new Chart(ctx, {
type: 'doughnut',
data: {
  labels: ['New Clients', 'Schd. Measurements', 'Pending Designs', 'Quotes', 'Payments'],
  datasets: [{
    data: [5, 25, 7, 9, 6],
    backgroundColor: ['#f97316', '#581c87', '#8b5cf6', '#eab308', '#3b82f6'],
    borderWidth: 1,
      borderColor: '#fff',
      hoverOffset: 8,
      borderRadius: 7,
      spacing: 4,
  }]
},
options: {
  cutout: '70%',
  plugins: {
    legend: {
      display: false,
      position: 'right',
      borderRadius: 5,
    },

  }
}
});



//adding month filter to the Total Incoming Clients section
// Get the select element and month names

const monthSelect = document.getElementById('month');
const monthNames = [
"January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"
];

const currentMonthIndex = new Date().getMonth(); // 0 = Jan, 11 = Dec

// Add all months as options
monthNames.forEach((name, index) => {
const option = document.createElement("option");
option.value = String(index + 1).padStart(2, '0'); // Format as 01, 02, ...
option.textContent = name;

// Automatically select current month
if (index === currentMonthIndex) {
option.selected = true;
}

monthSelect.appendChild(option);
});


// posting content into the table
const allProjects = [
{
name: "Maple Street",
status: "Completed",
statusStyle: "bg-green-100 text-green-700",
client: "Yaw Boateng",
duration: "3 weeks",
cost: "$10,000"
},
{
  name: "Smith Residence",
  status: "Completed",
  statusStyle: "bg-green-100 text-green-700",
  client: "Kwesi Kumi",
  duration: "3 weeks",
  cost: "$10,000"
},
{
name: "New Build Greenway",
status: "Under Review",
statusStyle: "border border-yellow-500 text-yellow-600",
client: "Kwesi Osei",
duration: "3 weeks",
cost: "$30,000"
},
{
  name: "Johnson Remodel",
  status: "In Progress",
  statusStyle: "border border-purple-500 text-purple-600",
  client: "Akwasi Appiah",
  duration: "2 weeks",
  cost: "$20,000"
},
{
name: "Smith Residence",
status: "Completed",
statusStyle: "bg-green-100 text-green-700",
client: "Kwesi Kumi",
duration: "3 weeks",
cost: "$10,000"
},
{
name: "Johnson Remodel",
status: "In Progress",
statusStyle: "border border-purple-500 text-purple-600",
client: "Akwasi Appiah",
duration: "2 weeks",
cost: "$20,000"
},
{
name: "XYZ Corporation",
status: "Under Review",
statusStyle: "border border-yellow-500 text-yellow-600",
client: "Ngozi Ogunde",
duration: "2 months",
cost: "$10,000"
},
{
  name: "Johnson Remodel",
  status: "In Progress",
  statusStyle: "border border-purple-500 text-purple-600",
  client: "Akwasi Appiah",
  duration: "2 weeks",
  cost: "$20,000"
},
// Add more entries as needed...
];

const itemsPerPage = 8;
let currentPage = 1;

function renderTable() {
const start = (currentPage - 1) * itemsPerPage;
const end = start + itemsPerPage;
const currentItems = allProjects.slice(start, end);

const tbody = document.querySelector("table tbody");
tbody.innerHTML = "";

currentItems.forEach(item => {
tbody.innerHTML += `
  <tr class="border-t hover:bg-gray-50">
    <td class="p-4"><input type="checkbox" class="child-checkbox"/></td>
    <td class="p-4 font-semibold">${item.name}</td>
    <td class="p-4">
      <span class="px-3 py-1 text-sm rounded-full ${item.statusStyle}">${item.status}</span>
    </td>
    <td class="p-4">${item.client}</td>
    <td class="p-4 font-medium">${item.duration}</td>
    <td class="p-4 font-medium">${item.cost}</td>
    <td class="p-4 text-right"><button class="text-gray-500 hover:text-red-500"><i class="fas fa-trash-alt"></i></button></td>
  </tr>
`;
});

// When 'selectAll' is toggled
document.getElementById("selectAll").addEventListener("change", function () {
const isChecked = this.checked;
const checkboxes = document.querySelectorAll(".child-checkbox");
checkboxes.forEach(cb => cb.checked = isChecked);
});
// When 'selectAll' is unchecked

const allCheckboxes = document.querySelectorAll(".child-checkbox");
allCheckboxes.forEach(cb => {
cb.addEventListener("change", () => {
const allChecked = Array.from(allCheckboxes).every(c => c.checked);
document.getElementById("selectAll").checked = allChecked;
});
});

// Update results info
const resultsText = document.querySelector(".results-text");
resultsText.textContent = `Showing ${start + 1} to ${Math.min(end, allProjects.length)} of ${allProjects.length} results`;

// Update button states
document.getElementById("prevPage").disabled = currentPage === 1;
document.getElementById("nextPage").disabled = end >= allProjects.length;
}

function goToPage(page) {
currentPage = page;
renderTable();
}

document.addEventListener("DOMContentLoaded", () => {
document.getElementById("prevPage").addEventListener("click", () => {
if (currentPage > 1) goToPage(currentPage - 1);
});

document.getElementById("nextPage").addEventListener("click", () => {
if ((currentPage * itemsPerPage) < allProjects.length) goToPage(currentPage + 1);
});

renderTable();
});

</script>

</x-layouts.adminapp>
