@extends('layouts.layout')
@section('title')
    <title>Admin | Sales Report </title>
@endsection

@section('content')
<div class="container bg-white shadow rounded m-4 p-4 ">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Sales Report</h2>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid ">
        <!-- Small boxes (Stat box) -->
        <div class="row ">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$totalOrders}}</h3>

                <p>Total Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3>{{$totalSales}}</h3>

                <p>Total Sales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-success text-white">
            <div class="inner">
              <h3>{{$dailySales}}<sup style="font-size: 20px"></sup></h3>

              <p>Today Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-warning text-white">
            <div class="inner">
              <h3>{{$weeklySales}}<sup style="font-size: 20px"></sup></h3>

              <p>This Week Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$monthlySales}}<sup style="font-size: 20px"></sup></h3>

              <p>This Month sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{$yearlySales}}<sup style="font-size: 20px"></sup></h3>

              <p>This Year sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row d-flex justify-content-center">
            <section class="col-lg-8 connectedSortable ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i> Sales Report
                        </h3>
                        <select id="salesFilter" class="form-control w-25 float-right">
                            <option value="daily" {{ $range == 'daily' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ $range == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ $range == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ $range == 'year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px; max-height: 300px; overflow: hidden;">
                            <!-- Pass initial data from Laravel to JavaScript -->
                            <canvas id="salesChart" 
                                data-labels='@json($labels)' 
                                data-sales='@json($salesData->pluck("total_sales"))'>
                            </canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- /.row (main row) -->
      {{-- </div><!-- /.container-fluid --> --}}
    </section>
    <!-- /.content -->

  </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let ctx = document.getElementById('salesChart').getContext('2d');
    let salesChart;

    // Get initial data from Laravel
    let initialLabels = JSON.parse(document.getElementById('salesChart').dataset.labels);
    let initialSales = JSON.parse(document.getElementById('salesChart').dataset.sales);

    function updateChart(labels, salesData) {
        if (salesChart) {
            salesChart.destroy(); // Destroy the old chart before creating a new one
        }

        salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Initialize the chart with data from Laravel
    updateChart(initialLabels, initialSales);

    // Fetch and update the chart on filter change
    document.getElementById('salesFilter').addEventListener('change', function() {
        fetch(`/get-sales-data?range=${this.value}`)
            .then(response => response.json())
            .then(data => {
                updateChart(data.labels, data.sales);
            })
            .catch(error => console.error('Error fetching sales data:', error));
    });
});
</script>
@endpush