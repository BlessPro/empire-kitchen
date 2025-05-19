// This file contains the JavaScript code for the admin dashboard page.
// It includes functionality for charts, table pagination, and a month filter.
// It uses Chart.js for charting and Feather Icons for icon rendering.
feather.replace();



//variables for the charts
// const clientsChartCtx1 = document.getElementById('clientsChart1').getContext('2d');
// const clientsChartCtx2 = document.getElementById('clientsChart2').getContext('2d');


//variales for the pipeline chart
const pipeline_chart=document.getElementById('ProjectsPipeline').getContext('2d');
//initializing the barcharts
new Chart(pipeline_chart, {
type: 'bar',
data: {
  labels: ['', '', '', ''],

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
//initializing the doughnut chart for the admin/dashboard
const ctx = document.getElementById('clientsChart').getContext('2d');
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

//initializing the doughnut chart for the admin/report page
const ctx1 = document.getElementById('clientsChart1').getContext('2d');
new Chart(ctx1, {
type: 'doughnut',
data: {
  labels: ['Completed Projects', 'Pending Projects', 'Closed Projects'],
  datasets: [{
    data: [5, 25, 16],
    backgroundColor: ['#6B1E72', '#FF7300','#9151FF' ],
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
// // Prepare the data for the chart (extract values from the projects)
// const measurementData = pipelineData.map(project => project.measurement_date ? 1 : 0);
// const designData = pipelineData.map(project => project.design_date ? 1 : 0);
// const installationData = pipelineData.map(project => project.installation_date ? 1 : 0);
// const paymentData = pipelineData.map(project => project.payment_date ? 1 : 0);

// // Create the chart using Chart.js
// const projectsPipelineCtx = document.getElementById('ProjectsPipeline').getContext('2d');
// const projectsPipelineChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Measurement', 'Design', 'Installation', 'Payment'],
//         datasets: [{
//             label: 'Project Pipeline',
//             data: [
//                 measurementData.length,
//                 designData.length,
//                 installationData.length,
//                 paymentData.length
//             ],
//             backgroundColor: [
//                 'rgba(255, 159, 64, 0.6)', // Orange
//                 'rgba(54, 162, 235, 0.6)', // Blue
//                 'rgba(75, 192, 192, 0.6)', // Green
//                 'rgba(153, 102, 255, 0.6)'  // Purple
//             ],
//             borderColor: [
//                 'rgba(255, 159, 64, 1)', // Orange
//                 'rgba(54, 162, 235, 1)', // Blue
//                 'rgba(75, 192, 192, 1)', // Green
//                 'rgba(153, 102, 255, 1)'  // Purple
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });


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

//for the form submittion
//added29.04.2025
// Open/Close Modals
// DOM Elements
const openClientModalBtn = document.getElementById('openClientModal');
const closeClientModalBtn = document.getElementById('closeClientModal');
const closeSuccessModalBtn = document.getElementById('closeSuccessModal');
const clientModal = document.getElementById('clientModal');
const successModal = document.getElementById('successModal');
const clientForm = document.getElementById('clientForm');

// Event Listeners
openClientModalBtn.addEventListener('click', () => {
    clientModal.classList.remove('hidden');
});

closeClientModalBtn.addEventListener('click', () => {
    clientModal.classList.add('hidden');
});

closeSuccessModalBtn.addEventListener('click', () => {
    successModal.classList.add('hidden');
});

// Form Submission
clientForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
        const response = await fetch(clientForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: new FormData(clientForm)
        });

        const data = await response.json();

        if (data.success) {
            clientModal.classList.add('hidden');
            successModal.classList.remove('hidden');
            clientForm.reset();
        }
    } catch (error) {
        console.error('Error:', error);
    }
});


// adding style to the  status
// written on 1.05.2025
// Holiday

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


        //copied from the client management page to be used for the client, poject info and client-porjects page.
    document.getElementById('openAddClientModal').addEventListener('click', function () {
        document.getElementById('addClientModal').classList.remove('hidden');
    });

    document.getElementById('cancelAddClient').addEventListener('click', function () {
        document.getElementById('addClientModal').classList.add('hidden');
    });

    document.getElementById('addClientForm').addEventListener('submit', function (e) {
        e.preventDefault();




        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('clients.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) throw new Error('Something went wrong');
            return response.json();
        })
        .then(data => {
            // Close form modal and show success modal
            document.getElementById('addClientModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('hidden');
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });

    document.getElementById('closeSuccessModal').addEventListener('click', function () {
        document.getElementById('successModal').classList.add('hidden');
        location.reload(); // refresh to update the table
    });


