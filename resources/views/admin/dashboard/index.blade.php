@extends('layouts.layout')
@section('title')
    <title>Admin | Dashboard </title>
@endsection

@section('content')
<div class="container bg-white shadow rounded m-4 p-4 ">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Dashboard</h2>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row ">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
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
          <div class="col-lg-3 col-6">
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

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$products}}<sup style="font-size: 20px"></sup></h3>

                <p>Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-cube"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$categories}}<sup style="font-size: 20px"></sup></h3>

                <p>Categories</p>
              </div>
              <div class="icon">
                <i class="ion ion-grid"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info ">
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
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
            <section class="col-lg-10 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i> Sales
                        </h3>
                        
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id="revenue-chart"
                                 style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
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
    document.addEventListener("DOMContentLoaded", function () {
        var salesData = @json($salesData);
        var labels = salesData.map(item => item.date);
        var sales = salesData.map(item => item.total_sales);

        // Revenue Chart (Area)
        var revenueCtx = document.getElementById('revenue-chart-canvas').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: sales,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Sales Chart (Donut)
        var salesCtx = document.getElementById('sales-chart-canvas').getContext('2d');
        new Chart(salesCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales Distribution',
                    data: sales,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush