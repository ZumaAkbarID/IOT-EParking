@extends('Layouts.dashboard')

@section('dashboard_style')
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard {{ Auth::user()->role }}</h3>
                </div>
            </div>
        </div>

        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Pengunjung Usaha
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format(count($trafic['all']), 0, ',', '.') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-building-check"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Pendapatan</h6>
                                        <input type="hidden" name="" id="money_all"
                                            value="{{ $report['money_all'] }}">
                                        <h6 class="font-extrabold mb-0">
                                            Rp. <span
                                                id="money_all_holder">{{ number_format($report['money_all'], 0, ',', '.') }}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-building-add"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Mesin</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($machine['total'], 0, ',', '.') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Sensor</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($machine['total_sensor'], 0, ',', '.') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pengunjung Usaha pada tahun {{ date('Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('dashboard_script')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Pusher.logToConsole = true;

        let uuid = "{{ Auth::user()->business_uuid }}";

        let money_all = $('#money_all').val();

        var pusher = new Pusher('077a1f50c5eac9602b7b', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('update-pengurus');

        channel.bind('event-pengurus-' + uuid, function(response) {
            let data = JSON.parse(response.json);
            $('#used_' + data.machine_id).val(data.inside);

            let money_all = parseInt($('#money_all').val());

            money_all += parseInt(data.amount);

            $('#money_all_holder').empty();
            $('#money_all_holder').html(new Intl.NumberFormat('en-DE').format(money_all));
            $('#money_all').val(money_all);
        });
    </script>
    <script src="{{ asset('/') }}assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
        var optionsProfileVisit = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [{
                name: "Jumlah",
                data: [
                    @for ($i = 0; $i < 12; $i++)
                        {{ $trafic['monthly'][$i] }},
                    @endfor
                ],
            }, ],
            colors: "#435ebe",
            xaxis: {
                categories: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember",
                ],
            },
        }

        var chartProfileVisit = new ApexCharts(
            document.querySelector("#chart-profile-visit"),
            optionsProfileVisit
        );

        chartProfileVisit.render();
    </script>
@endsection
