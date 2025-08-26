@extends('layouts.layout-admin')

@section('content')

    <div class="row min-vh-74">
        <div class="col-12 px-lg-4 px-0">
            <div class="card my-4 px-0">
                <!-- Card header -->
                <div class="card-header-custom">
                    <div>
                        <h5>Daftar Pengunjung</h5>
                        <p class="text-sm">
                            Statistik untuk link <a target="_blank" href="{{ url($detail['short_url']) }}">{{ url($detail['short_url']) }}</a>
                        </p>
                    </div>
                </div>

                <div class="card-body px-0">
                    <!-- Stats Section -->
                    <div class="stats-section">
                        <div class="stats-card">
                            <h6>Total Pengunjung Unik</h6>
                            <h4>{{ $visitorCount }}</h4>
                        </div>
                        <div class="stats-card">
                            <h6>Total Jumlah Klik</h6>
                            <h4>{{ $clickCount }}</h4>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="filters-section">
                        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-3">
                            <!-- Country Filter -->
                            <div class="filter-group">
                                <label for="country-filter" class="filter-label d-none d-md-block">Negara:</label>
                                <select name="country" onchange="this.form.submit()" class="filter-select">
                                    <option value="">Semua Negara</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country }}" @if($selectedCountry == $country->country) selected @endif>
                                            {{ $country->country }} ({{ $country->total_visitors }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Time Filter -->
                            <div class="filter-group">
                                <label for="time-filter" class="filter-label d-none d-md-block">Waktu:</label>
                                <select name="time_filter" onchange="this.form.submit()" class="filter-select">
                                    <option value="">Semua Waktu</option>
                                    <option value="24h" @if(request('time_filter') == '24h') selected @endif>24 Jam Terakhir</option>
                                    <option value="7d" @if(request('time_filter') == '7d') selected @endif>7 Hari Terakhir</option>
                                    <option value="1m" @if(request('time_filter') == '1m') selected @endif>1 Bulan Terakhir</option>
                                    <option value="1y" @if(request('time_filter') == '1y') selected @endif>1 Tahun Terakhir</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Two-column layout for chart and table -->
                    <div class="row px-lg-4 px-4">
                        <!-- Chart View (Left Column) -->
                        <div class="col-12 col-md-6 mb-4 mb-md-0">
                            <div class="card p-3">
                                <h6 class="text-center mb-3">Tren Kunjungan Harian</h6>
                                <div id="chart"></div>
                            </div>
                        </div>

                        <!-- Table View (Right Column) -->
                        <div class="col-12 col-md-6 px-0">
                            <div class="table-container px-0">
                                <table class="table" id="category-list">
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center">No</th> -->
                                            <th class="text-center">IP</th>
                                            <th class="text-center">Negara</th>
                                            <th class="text-center">Jumlah Klik</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($list as $index => $item)
                                            <tr>
                                                <!-- <td data-label="No" class="text-sm text-center">{{ $index + 1 }}</td> -->
                                                <td data-label="IP" class="text-center text-truncate">{{ $item['ip'] }}</td>
                                                <td data-label="Negara" class="text-center text-truncate">{{ $item['country'] }}</td>
                                                <td data-label="Jumlah Klik" class="text-center">{{ $item['visitor_count'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center text-muted" colspan="6">
                                                    Tidak ada data pengunjung.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-container">
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        function onChangeStatus(id) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const url = '/admin/link/status'
            const data = {
                id: id
            };

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function () {
                if (xhr.status === 200) {

                } else {
                    alert('Request failed. Returned status of ' + xhr.status);
                }
            };
            xhr.send(JSON.stringify(data));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dailyVisitorsData = {!! json_encode($dailyVisitors) !!};

            const categories = dailyVisitorsData.map(item => item.date);
            const seriesData = dailyVisitorsData.map(item => item.count);

            const options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                series: [{
                    name: 'Total Klik',
                    data: seriesData
                }],
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Klik'
                    },
                    labels: {
                        formatter: function(value) {
                            return parseInt(value);
                        }
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    colors: ['#3b5998']
                },
                markers: {
                    size: 4,
                    colors: ['#3b5998'],
                    strokeColors: '#fff',
                    hover: {
                        size: 6
                    }
                },
                grid: {
                    show: false
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endsection
