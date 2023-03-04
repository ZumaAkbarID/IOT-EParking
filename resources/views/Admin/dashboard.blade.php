@extends('Layouts.dashboard')

@section('dashboard_content')
    <div class="page-heading">
        <h3>Dashboard {{ Auth::user()->role }}</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
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
                                            Pengunjung E-Parking
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($trafic['e-parking'], 0, ',', '.') }}</h6>
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
                                        <h6 class="text-muted font-semibold">Total Usaha</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format(count($business['all']), 0, ',', '.') }}</h6>
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
                                        <h6 class="text-muted font-semibold">Total Pengajuan</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($business['submission'], 0, ',', '.') }}</h6>
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
                                        <h6 class="text-muted font-semibold">Total Pengurus</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($user['pengurus'], 0, ',', '.') }}
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
                                <h4>Pengunjung E-Parking pada tahun {{ date('Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pengajuan Usaha Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Nama Bisnis</th>
                                                <th>Nama Pengaju</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($business['submission_latest'] as $item)
                                                <tr>
                                                    <td class="col-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-md">
                                                                <img
                                                                    src="{{ asset('/storage') . '/' . $item->business_thumbnail }}" />
                                                            </div>
                                                            <p class="font-bold ms-3 mb-0">{{ $item->business_name }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="col-auto">
                                                        <p class="mb-0">
                                                            <a class="badge bg-primary"
                                                                href="{{ route('Admin.User.Edit', $item->submiter_phone_number) }}">{{ $item->submiter_name }}</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'approved')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif($item->status == 'review')
                                                            <span class="badge bg-info">Sedang Direview</span>
                                                        @else
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="badge bg-info"
                                                            href="{{ route('Admin.Submission.Edit', $item->uuid) }}">Edit</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">
                                    {{ !is_null(Auth::user()->business_uuid) ? $business['this_account']->business_name : '' }}
                                </h6>
                                <h6 class="text-muted mb-0">{{ Auth::user()->role }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>3 Peringkat Usaha</h4>
                        <p class="text-muted">dengan pengunjung web terbanyak</p>
                    </div>
                    <div class="card-body">

                        @forelse ($trafic['single'] as $item)
                            @if (!is_null($item->business_uuid))
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width: 10px">
                                                <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            @foreach ($business['all'] as $busi)
                                                @if ($busi->uuid == $item->business_uuid)
                                                    <h5 class="mb-0 ms-3">{{ $busi->business_name }}</h5>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">{{ number_format($item->count, 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width: 10px">
                                            <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Tidak ada data</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="chart-europe"></div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('dashboard_script')
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
