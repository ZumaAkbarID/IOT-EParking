@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Mesin</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Mesin
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Total Mesin
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['machine']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Total Sensor
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format($data['totalSensor'], 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('Admin.Machine.Add', $business->uuid) }}" class="btn btn-info">Tambah Mesin</a>
            </div>
        </div>

        <section class="section mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Usaha ID : {{ $business->uuid }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-mesin">
                            <thead>
                                <tr>
                                    <th>Mesin ID</th>
                                    <th>Nama Mesin</th>
                                    <th>Total Sensor</th>
                                    <th>Harga Setiap Sensor</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['machine'] as $item)
                                    <tr>
                                        <td>{{ $item->uuid }}</td>
                                        <td>{{ $item->machine_name }}</td>
                                        <td>{{ $item->total_sensor }}</td>
                                        <td>{{ number_format($item->price_each_sensor, 0, ',', '.') }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                                        <td><a href="{{ route('Admin.Machine.Edit', $item->uuid) }}">Edit</a></td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection

@section('dashboard_script')
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    @include('Layouts.sweetalert2')
    <script>
        function showTb(status) {
            $('#tb-' + status).DataTable({
                order: [],
                ordering: false,
                language: {
                    search: "Cari",
                    lengthMenu: "Tampilkan _MENU_ data",
                    emptyTable: "Data tidak ditemukan",
                    infoEmpty: "Tidak menampilkan data apapun",
                    infoFiltered: "difilter dari _MAX_ data",
                    zeroRecords: "Tidak ada data",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                },
            });
        }
        showTb('mesin');
    </script>
@endsection
