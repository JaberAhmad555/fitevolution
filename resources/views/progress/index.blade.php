<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            My Progress
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Monthly Duration Chart -->
            <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white">Total Workout Duration (Last 6 Months)</h3>
                <canvas id="durationChart" class="mt-4"></canvas>
            </div>

            <!-- Monthly Count Chart -->
            <div class="bg-gray-800/90 backdrop-blur-sm shadow-2xl sm:rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white">Total Workouts Logged (Last 6 Months)</h3>
                <canvas id="countChart" class="mt-4"></canvas>
            </div>

        </div>
    </div>

    {{-- SCRIPT to render the charts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartLabels = @json($chartLabels);

            // Duration Chart
            const durationCtx = document.getElementById('durationChart').getContext('2d');
            new Chart(durationCtx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Minutes',
                        data: @json($durationData),
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });

            // Count Chart
            const countCtx = document.getElementById('countChart').getContext('2d');
            new Chart(countCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Workouts',
                        data: @json($countData),
                        backgroundColor: 'rgba(139, 92, 246, 0.2)',
                        borderColor: 'rgba(139, 92, 246, 1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });
        });
    </script>
</x-app-layout>