{{-- resources/views/reports/chart.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="earningsChart" width="800" height="400"></canvas>
    <script>
        const ctx = document.getElementById('earningsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($pemasukan),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($pengeluaran),
                        borderColor: '#6A1E55',
                        backgroundColor: 'rgba(106, 30, 85, 0.2)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>