import Iconify from '@iconify/iconify';
import axios from 'axios';


// This file contains the JavaScript code for the admin dashboard page.
// It includes functionality for charts, table pagination, and a month filter.
// It uses Chart.js for charting and Feather Icons for icon rendering.
feather.replace();



//variables for the charts
// const clientsChartCtx1 = document.getElementById('clientsChart1').getContext('2d');
// const clientsChartCtx2 = document.getElementById('clientsChart2').getContext('2d');


// Dashboard charts (admin)
const pipelineLegend = document.getElementById('pipelineLegend');
const renderPipelineLegend = (labels = [], counts = [], colors = []) => {
    if (!pipelineLegend) return;
    pipelineLegend.innerHTML = '';

    if (!labels.length) {
        const empty = document.createElement('li');
        empty.className = 'text-sm text-gray-500';
        empty.textContent = 'No project data yet';
        pipelineLegend.appendChild(empty);
        return;
    }

    labels.forEach((label, index) => {
        const li = document.createElement('li');
        li.className = 'flex items-center space-x-2';
        const color = colors[index] || '#9ca3af';
        const value = counts[index] ?? 0;
        li.innerHTML = `
            <span class="w-3 h-3 rounded-full" style="background-color:${color}"></span>
            <span>${label} (${value})</span>
        `;
        pipelineLegend.appendChild(li);
    });
};

const pipelineCanvas = document.getElementById('ProjectsPipeline');
let pipelineChart;
if (pipelineCanvas) {
    const pipelineCtx = pipelineCanvas.getContext('2d');
    pipelineChart = new Chart(pipelineCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                data: [],
                label: 'Projects',
                backgroundColor: [],
                borderWidth: 1,
                borderColor: '#fff',
                hoverOffset: 8,
                borderRadius: 10,
                spacing: 4,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        borderDash: [4, 4],
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        color: '#4B5563',
                        font: { size: 12 }
                    }
                },
                y: {
                    grid: {
                        display: true,
                        borderDash: [4, 4],
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        stepSize: 5,
                        color: '#4B5563',
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    const loadPipeline = async () => {
        try {
            const response = await axios.get('/admin/dashboard/pipeline');
            const payload = response.data || {};
            const labels = payload.labels || [];
            const counts = payload.data || [];
            const colors = payload.colors || [];

            pipelineChart.data.labels = labels;
            pipelineChart.data.datasets[0].data = counts;
            pipelineChart.data.datasets[0].backgroundColor = colors.length ? colors : pipelineChart.data.datasets[0].backgroundColor;
            pipelineChart.update();

            renderPipelineLegend(labels, counts, colors);
        } catch (error) {
            console.error('Failed to load project pipeline data', error);
        }
    };

    loadPipeline();
}

const legendElements = {
    clients: document.getElementById('legend-clients'),
    projects: document.getElementById('legend-projects'),
    bookings: document.getElementById('legend-bookings'),
};

const updateLegendCounts = (counts = {}) => {
    if (legendElements.clients) {
        legendElements.clients.textContent = `New Clients (${counts.clients ?? 0})`;
    }
    if (legendElements.projects) {
        legendElements.projects.textContent = `New Projects (${counts.projects ?? 0})`;
    }
    if (legendElements.bookings) {
        legendElements.bookings.textContent = `New Bookings (${counts.bookings ?? 0})`;
    }
};

const clientsCanvas = document.getElementById('clientsChart');
let clientsChart;
if (clientsCanvas) {
    const donutCtx = clientsCanvas.getContext('2d');
    const donutColors = ['#f97316', '#581c87', '#6366f1'];
    clientsChart = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['New Clients', 'New Projects', 'New Bookings'],
            datasets: [{
                data: [0, 0, 0],
                backgroundColor: donutColors,
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
                },
            }
        }
    });

    const rangeSelect = document.getElementById('dashboardRange');

    const loadMetrics = async (range = 'this_month') => {
        try {
            const response = await axios.get('/admin/dashboard/metrics', {
                params: { range }
            });

            const payload = response.data || {};
            const counts = payload.counts || {};

            clientsChart.data.datasets[0].data = [
                counts.clients ?? 0,
                counts.projects ?? 0,
                counts.bookings ?? 0,
            ];
            clientsChart.update();

            updateLegendCounts(counts);

            if (rangeSelect && payload.range && rangeSelect.value !== payload.range) {
                rangeSelect.value = payload.range;
            }
        } catch (error) {
            console.error('Failed to load dashboard metrics', error);
        }
    };

    if (rangeSelect) {
        rangeSelect.addEventListener('change', (event) => {
            loadMetrics(event.target.value);
        });
    }

    loadMetrics(rangeSelect ? rangeSelect.value : 'this_month');
}

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
