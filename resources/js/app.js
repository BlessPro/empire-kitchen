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
,
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

// currentItems.forEach(item => {
// tbody.innerHTML += `
//   <tr class="border-t hover:bg-gray-50">
//     <td class="p-4"><input type="checkbox" class="child-checkbox"/></td>
//     <td class="p-4 font-normal text-[15px]">${item.name}</td>
//     <td class="p-4">
//       <span class="px-3 py-1 text-sm rounded-full ${item.statusStyle}">${item.status}</span>
//     </td>
//     <td class="p-4 font-normal text-[15px]">${item.client}</td>
//     <td class="p-4 font-normal text-[15px]">${item.duration}</td>
//     <td class="p-4 font-normal text-[15px]">${item.cost}</td>

//     <td class="p-4 text-right"><button class="text-gray-500 hover:text-red-500"><i data-feather="layers" class="mr-3"></i> </button></td>
//   </tr>
// `;
// });

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
