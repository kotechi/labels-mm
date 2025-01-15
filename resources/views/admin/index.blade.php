<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      eCommerce Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Only the scroll bar */
    ::-webkit-scrollbar {
        width: .5rem;
        height: .5rem;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,.15);
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0,0,0,.3);
    }
      </style>
</head>



  <body class="relative bg-yellow-50 overflow-hidden max-h-screen">
    <header class="fixed right-0 top-0 left-60 bg-yellow-50 py-3 px-4 h-16">
      <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
          <div>
            <button type="button" class="flex items-center focus:outline-none rounded-lg text-gray-600 hover:text-yellow-600 focus:text-yellow-600 font-semibold p-2 border border-transparent hover:border-yellow-300 focus:border-yellow-300 transition">
              <span class="inline-flex items-center justify-center w-6 h-6 text-gray-600 text-xs rounded bg-white transition mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
              </span>
              <span class="text-sm">Archive</span>
            </button>
          </div>
          <div class="text-lg font-bold">Today's Plan</div>
          <div>
            <button type="button" class="flex items-center focus:outline-none rounded-lg text-gray-600 hover:text-yellow-600 focus:text-yellow-600 font-semibold p-2 border border-transparent hover:border-yellow-300 focus:border-yellow-300 transition">
              <span class="text-sm">This week</span>
              <span class="inline-flex items-center justify-center w-6 h-6 text-gray-600 text-xs rounded bg-white transition ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
              </span>
            </button>
          </div>
        </div>
      </div>
    </header>
  
    <aside class="fixed inset-y-0 left-0 bg-white shadow-md max-h-screen w-60">
      <div class="flex flex-col justify-between h-full">
        <div class="flex-grow">
          <div class="px-4 py-6 text-center border-b">
            <h1 class="text-xl font-bold leading-none"><span class="text-yellow-700">Task Manager</span> App</h1>
          </div>
          <div class="p-4">
            <ul class="space-y-1">
              <li>
                <a href="javascript:void(0)" class="flex items-center bg-yellow-200 rounded-xl font-bold text-sm text-yellow-900 py-3 px-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="text-lg mr-4" viewBox="0 0 16 16">
                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"/>
                  </svg>Plan
                </a>
              </li>
              <li>
                <a href="javascript:void(0)" class="flex bg-white hover:bg-yellow-50 rounded-xl font-bold text-sm text-gray-900 py-3 px-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="text-lg mr-4" viewBox="0 0 16 16">
                    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z"/>
                  </svg>Task list
                </a>
              </li>
              <li>
                <a href="javascript:void(0)" class="flex bg-white hover:bg-yellow-50 rounded-xl font-bold text-sm text-gray-900 py-3 px-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="text-lg mr-4" viewBox="0 0 16 16">
                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                  </svg>Projects
                </a>
              </li>
              <li>
                <a href="javascript:void(0)" class="flex bg-white hover:bg-yellow-50 rounded-xl font-bold text-sm text-gray-900 py-3 px-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-lg mr-4" viewBox="0 0 16 16">
                    <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                  </svg>Tags
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="p-4">
          <button type="button" class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="" viewBox="0 0 16 16">
              <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1h8zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
            </svg>
          </button> <span class="font-bold text-sm ml-2">Logout</span>
        </div>
      </div>
    </aside>
  
    <main class="ml-60 pt-16 max-h-screen overflow-auto">
      <div class="px-6 py-8">
        <div class="max-w-4xl mx-auto">
          <div class="bg-white rounded-3xl p-8 mb-5">
            <h1 class="text-3xl font-bold mb-10">Messaging ID framework development for the marketing branch</h1>
            <div class="flex items-center justify-between">
              <div class="flex items-stretch">
                <div class="text-gray-400 text-xs">Members<br>connected</div>
                <div class="h-100 border-l mx-4"></div>
                <div class="flex flex-nowrap -space-x-3">
                  <div class="h-9 w-9">
                    <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?background=random">
                  </div>
                  <div class="h-9 w-9">
                    <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?background=random">
                  </div>
                </div>
              </div>
              <div class="flex items-center gap-x-2">
                <button type="button" class="inline-flex items-center justify-center h-9 px-3 rounded-xl border hover:border-gray-400 text-gray-800 hover:text-gray-900 transition">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chat-fill" viewBox="0 0 16 16">
                    <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z"/>
                  </svg>
                </button>
                <button type="button" class="inline-flex items-center justify-center h-9 px-5 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition">
                  Open
                </button>
              </div>
            </div>
  
            <hr class="my-10">
  
            <div>
              <table id="pesananTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500">
                       <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Name Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Jumlah Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nomor Whatsapp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pesanans as $pesanan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->id_pesanan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->name_product }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->total_harga }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->jumlah_product }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nomor_whatsapp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('pesanans.destroy', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
              <div>
                <h2 class="text-2xl font-bold mb-4">Earnings</h2>
                <div class="flex gap-4 mb-4">
                  <select id="earningsPeriod" class="px-4 py-2 bg-gray-200 rounded">
                    <option value="daily">Daily</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                  </select>
                  <div id="totalEarnings" class="px-4 py-2 bg-gray-100 rounded">Total: {{$totalMonthlyEarnings}}</div>
                </div>
                <div id="navigationButtons" class="flex gap-4 mb-4">
                  <button id="prevPeriod" class="px-4 py-2 bg-gray-200 rounded">Previous</button>
                  <button id="nextPeriod" class="px-4 py-2 bg-gray-200 rounded">Next</button>
                </div>
                <canvas id="earningsChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $('#pesananTable').DataTable();


        $('.dataTables_length').addClass('mb-4');
        $('.dataTables_filter').addClass('mb-4');
      });

      $('.delete-button').on('click', function() {
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('earningsChart').getContext('2d');
        let earningsChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: @json($months),
            datasets: [
              {
                label: 'Pendapatan',
                data: @json($monthlyEarnings),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
              },
              {
                label: 'Modal',
                data: @json($monthlyModal),
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
              },
              {
                label: 'Total Penghasilan',
                data: @json($monthlyTotalPenghasilan),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        const totalEarningsElement = document.getElementById('totalEarnings');
        const earningsPeriodElement = document.getElementById('earningsPeriod');
        const prevPeriodButton = document.getElementById('prevPeriod');
        const nextPeriodButton = document.getElementById('nextPeriod');

        let currentMonth = new Date().getMonth() + 1;
        let currentYear = new Date().getFullYear();

        function fetchData(period, month, year) {
          $.ajax({
            url: '{{ route("admin.index") }}',
            method: 'GET',
            data: {
              period: period,
              month: month,
              year: year
            },
            success: function(response) {
              updateChart(response.labels, response.data, response.label, response.totalEarnings);
            }
          });
        }

        function updateChart(labels, data, label, totalEarnings) {
          earningsChart.data.labels = labels;
          earningsChart.data.datasets[0].data = data.pendapatan;
          earningsChart.data.datasets[1].data = data.modal;
          earningsChart.data.datasets[2].data = data.totalPenghasilan;
          earningsChart.data.datasets[0].label = label;
          earningsChart.update();

          totalEarningsElement.textContent = `Total: ${totalEarnings}`;
        }

        earningsPeriodElement.addEventListener('change', function() {
          const period = earningsPeriodElement.value;
          fetchData(period, currentMonth, currentYear);
        });

        prevPeriodButton.addEventListener('click', function() {
          const period = earningsPeriodElement.value;
          if (period === 'daily') {
            if (currentMonth === 1) {
              currentMonth = 12;
              currentYear--;
            } else {
              currentMonth--;
            }
          } else if (period === 'monthly') {
            currentYear--;
          }
          fetchData(period, currentMonth, currentYear);
        });

        nextPeriodButton.addEventListener('click', function() {
          const period = earningsPeriodElement.value;
          if (period === 'daily') {
            if (currentMonth === 12) {
              currentMonth = 1;
              currentYear++;
            } else {
              currentMonth++;
            }
          } else if (period === 'monthly') {
            currentYear++;
          }
          fetchData(period, currentMonth, currentYear);
        });

        fetchData('monthly', currentMonth, currentYear);
      });
    </script>
  </body>
</html>
