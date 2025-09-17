   {{-- <x-tech-layout>
   <x-slot name="header">
<!--written on 15.05.2025-->
        @include('admin.layouts.header')
         </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
        <!--head begins-->

            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
     <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


    <!-- Left Column -->
    <div class="flex flex-col gap-6">
      <!-- Overview -->
      <div class="p-4 mt-6 bg-white shadow rounded-2xl">
    <h2 class="mb-4 text-xl font-semibold">Project Stages Overview</h2>
    <canvas id="projectsBarChart" height="100"></canvas>

</div>


      <!-- Upcoming Measurements -->
      <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold">Upcoming Measurements</h2>
          <button class="px-3 py-1 text-sm text-purple-700 border border-purple-700 rounded-full">View All</button>
        </div>
        <div class="space-y-4">
    @forelse($projects as $project)
        @php
            $start = \Carbon\Carbon::parse($project['start_time']);
            $end = \Carbon\Carbon::parse($project['end_time']);
            $duration = $start->diffForHumans($end, true);
        @endphp

        <div class="py-2 pl-4 border-l-4 border-orange-500 rounded bg-gray-50">
            <h3 class="font-medium">{{ $project['project_name'] }}</h3>
            <p class="text-sm text-gray-600">{{ $project['start_time'] }} - {{ $project['end_time'] }}</p>
            <p class="text-sm text-gray-600">👤 {{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">{{ $duration }} - 📍 {{ $project['location'] }}</p>
        </div>
    @empty
        <p class="text-gray-500">No measurement stage projects assigned yet.</p>
    @endforelse
</div>

      </div>



    </div>


    <!-- Right Column -->
    <div class="flex flex-col gap-6">


      <!-- Recent Activities -->
      <div class="p-6 mt-8 bg-white rounded-lg shadow">
        <h2 class="mb-4 text-lg font-semibold">Recent Activities</h2>
        <div class="space-y-4">
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=1" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">New Build</span></p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=2" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">Smiths Residence</span></p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=3" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">Johnson Remodel</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
           </div>
    </div>

    <!-- Chart.js CDN (in your head section or layout) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('projectsBarChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                // label: 'Projects by Stage',
                data: @json($chartData),
                backgroundColor: [
                    '#FF7300', // measurement - blue
                    '#0065D2',  // design - green
                    '#14BA6D',  // production - yellow
                    '#9747FF'   // installation - red
                ],
                borderColor: [
                    '#FF7300',
                    '#0065D2',
                    '#14BA6D',
                    '#9747FF'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

</main>
</x-tech-layout>

 --}}














<x-tech-layout>
   <x-slot name="header">
<!--written on 15.05.2025-->
        @include('admin.layouts.header')
         </x-slot>










  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- 2-column responsive grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

      <!-- LEFT COLUMN -->
      <div class="space-y-6">


<!-- OVERVIEW -->
<section id="overview" class="bg-white border border-gray-200 shadow-sm rounded-2xl">
  <div class="px-6 pt-6">
    <h2 class="text-lg font-semibold">Overview</h2>
    <p class="mt-1 text-4xl font-semibold">
      <span id="ov-total">0</span>
      <span class="text-base font-normal text-gray-600">projects</span>
    </p>
  </div>

  <!-- Segmented bar -->
  <div class="px-6 mt-4">
    <div class="w-full h-3 overflow-hidden bg-gray-100 rounded-full" role="img" aria-label="Projects by stage">
      <div id="ov-bar" class="flex h-full"><!-- segments injected --></div>
    </div>
  </div>

  <!-- Legend -->
  <div id="ov-legend" class="grid grid-cols-2 gap-4 px-6 py-5 sm:grid-cols-4"><!-- items injected --></div>
</section>

{{-- Render function (drop once on the page) --}}


<div class="px-4 py-5 space-y-4 sm:px-6">
  @forelse($upcoming as $m)
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
      <div class="flex">
        <div class="w-1.5 rounded-l-xl {{ $m->stripe }}"></div>
        <div class="flex-1 p-4">
          <div class="flex items-start justify-between">
            <h3 class="text-base font-semibold">{{ $m->project_name }}</h3>
          </div>

          <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-700">
            <div class="flex items-center gap-2">
              {{-- calendar/clock --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>{{ $m->when }}</span>
            </div>

            <div class="flex items-center gap-2">
              {{-- user --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <span>{{ $m->client_name }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="p-6 text-sm text-center text-gray-500 border border-gray-300 border-dashed rounded-xl">
      No upcoming measurements.
    </div>
  @endforelse
</div>



{{--
        <!-- UPCOMING MEASUREMENTS -->
        <section class="bg-white border border-gray-200 shadow-sm rounded-2xl">
          <div class="flex items-center justify-between px-6 pt-6">
            <h2 class="text-lg font-semibold">Upcoming Measurements</h2>
            <button class="text-sm rounded-full border px-4 py-1.5 hover:bg-gray-50">View All</button>
          </div>

          <div class="px-4 py-5 space-y-4 sm:px-6">
            <!-- Item -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
              <div class="flex">
                <div class="w-1.5 rounded-l-xl bg-orange-500"></div>
                <div class="flex-1 p-4">
                  <div class="flex items-start justify-between">
                    <h3 class="text-base font-semibold">New Build</h3>
                  </div>
                  <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-700">
                    <div class="flex items-center gap-2">
                      <!-- clock -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <span>2:30 PM – 5:30 PM</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <!-- user -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      <span>Chris Laventher</span>
                    </div>
                    <div class="ml-auto text-sm text-gray-500">3 hours 0 minutes</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
              <div class="flex">
                <div class="w-1.5 rounded-l-xl bg-green-500"></div>
                <div class="flex-1 p-4">
                  <div class="flex items-start justify-between">
                    <h3 class="text-base font-semibold">Smith Residence</h3>
                  </div>
                  <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-700">
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <span>2:30 PM – 5:30 PM</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      <span>Maple Street, West Legon</span>
                    </div>
                    <div class="ml-auto text-sm text-gray-500">3 hours 0 minutes</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
              <div class="flex">
                <div class="w-1.5 rounded-l-xl bg-blue-500"></div>
                <div class="flex-1 p-4">
                  <div class="flex items-start justify-between">
                    <h3 class="text-base font-semibold">New Build</h3>
                  </div>
                  <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-700">
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <span>2:30 PM – 5:30 PM</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      <span>Chris Laventher</span>
                    </div>
                    <div class="ml-auto text-sm text-gray-500">3 hours 0 minutes</div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>
 --}}
      </div>



      <!-- RIGHT COLUMN -->
      <div class="space-y-6">
        <!-- RECENT ACTIVITIES -->
        <section class="bg-white border border-gray-200 shadow-sm rounded-2xl">
          <div class="px-6 pt-6">
            <h2 class="text-lg font-semibold">Recent Activities</h2>
          </div>

          <div class="px-4 py-5 divide-y sm:px-6">
            <!-- Activity item -->
            <div class="flex items-center gap-3 py-3">
              <img src="https://i.pravatar.cc/64?img=1" class="object-cover w-10 h-10 rounded-full shadow ring-2 ring-white" alt="">
              <div class="min-w-0">
                <div class="text-sm">
                  <span class="font-medium">Chris Laventher</span>
                  <span class="text-gray-600"> uploaded a file in </span>
                  <a href="#" class="font-medium text-purple-700 hover:underline">New Build</a>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3 py-3">
              <img src="https://i.pravatar.cc/64?img=11" class="object-cover w-10 h-10 rounded-full shadow ring-2 ring-white" alt="">
              <div class="min-w-0">
                <div class="text-sm">
                  <span class="font-medium">Chris Laventher</span>
                  <span class="text-gray-600"> uploaded a file in </span>
                  <a href="#" class="font-medium text-purple-700 hover:underline">Smiths Residence</a>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3 py-3">
              <img src="https://i.pravatar.cc/64?img=15" class="object-cover w-10 h-10 rounded-full shadow ring-2 ring-white" alt="">
              <div class="min-w-0">
                <div class="text-sm">
                  <span class="font-medium">Chris Laventher</span>
                  <span class="text-gray-600"> uploaded a file in </span>
                  <a href="#" class="font-medium text-purple-700 hover:underline">Johnson Remodel</a>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3 py-3">
              <img src="https://i.pravatar.cc/64?img=5" class="object-cover w-10 h-10 rounded-full shadow ring-2 ring-white" alt="">
              <div class="min-w-0">
                <div class="text-sm">
                  <span class="font-medium">Chris Laventher</span>
                  <span class="text-gray-600"> uploaded a file in </span>
                  <a href="#" class="font-medium text-purple-700 hover:underline">New Build</a>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3 py-3">
              <img src="https://i.pravatar.cc/64?img=21" class="object-cover w-10 h-10 rounded-full shadow ring-2 ring-white" alt="">
              <div class="min-w-0">
                <div class="text-sm">
                  <span class="font-medium">Chris Laventher</span>
                  <span class="text-gray-600"> uploaded a file in </span>
                  <a href="#" class="font-medium text-purple-700 hover:underline">New Build</a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>




    </div>
  </main>


  <script>
  function renderOverview(segments, totalOverride = 0) {
    const $total  = document.getElementById('ov-total');
    const $bar    = document.getElementById('ov-bar');
    const $legend = document.getElementById('ov-legend');

    const sum = segments.reduce((s, x) => s + (Number(x.count) || 0), 0);
    const total = Number(totalOverride) > 0 ? Number(totalOverride) : sum;

    $total.textContent = total;

    // compute widths that sum to exactly 100%
    const widths = [];
    if (total <= 0) {
      for (let i = 0; i < segments.length; i++) widths.push(0);
    } else {
      let remaining = 1000; // tenths of a percent
      segments.forEach((seg, i) => {
        const w = (i < segments.length - 1)
          ? Math.round((seg.count / total) * 1000)
          : remaining;
        widths.push(Math.max(0, w));
        remaining -= (i < segments.length - 1) ? w : 0;
      });
    }

    // bar
    $bar.innerHTML = '';
    segments.forEach((seg, i) => {
      const pct = widths[i] / 10;
      const el = document.createElement('div');
      el.className = `${seg.color} h-full transition-[width] duration-500`;
      el.style.width = pct + '%';
      el.title = `${seg.label}: ${seg.count} (${pct.toFixed(1)}%)`;
      $bar.appendChild(el);
    });

    // legend
    $legend.innerHTML = '';
    segments.forEach((seg, i) => {
      const pct = widths[i] / 10;
      const li = document.createElement('div');
      li.className = 'flex items-center gap-2';
      li.innerHTML = `
        <span class="h-2.5 w-2.5 rounded-full ${seg.color}"></span>
        <span class="text-sm">${seg.label}</span>
        <span class="ml-auto text-sm text-gray-500" title="${pct.toFixed(1)}%">${seg.count}</span>
      `;
      $legend.appendChild(li);
    });
  }
</script>

{{-- Inject server data + call render --}}
<script>
  const overviewData   = @json($overviewData, JSON_NUMERIC_CHECK);
  const totalOverride  = @json($totalAssigned);
  document.addEventListener('DOMContentLoaded', () => {
    renderOverview(overviewData, totalOverride);
  });
</script>


</x-tech-layout>
