// This file contains the JavaScript code for the admin dashboard page.
// It includes functionality for charts, table pagination, and a month filter.
// It uses Chart.js for charting and Feather Icons for icon rendering.
feather.replace();



//variables for the charts
const clientsChartCtx = document.getElementById('clientsChart').getContext('2d');
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

