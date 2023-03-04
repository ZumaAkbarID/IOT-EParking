@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Usaha</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Usaha
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
                            Status Aktif
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['aktif']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Status Non-Aktif
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['non-aktif']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Aktif</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-aktif">
                            <thead>
                                <tr>
                                    <th>Form Pengajuan</th>
                                    <th>Akun Bisnis</th>
                                    <th>Nama Bisnis</th>
                                    <th>Foto Bisnis</th>
                                    <th>Deskripsi Bisnis</th>
                                    <th>Alamat Bisnis</th>
                                    <th>Mesin Sensor</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['aktif'] as $item)
                                    <tr>
                                        <td><a class="badge bg-primary"
                                                href="{{ route('Admin.Submission.Edit', $item->submission_uuid) }}">Lihat
                                                Form</a></td>
                                        <td>
                                            @foreach ($account as $acc)
                                                @if ($acc->business_uuid == $item->uuid)
                                                    <a class="badge bg-primary"
                                                        href="{{ route('Admin.User.Edit', $acc->uuid) }}">{{ $acc->name }}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $item->business_name }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                                                class="img-fluid" width="200">
                                        </td>
                                        <td>{{ $item->business_description }}</td>
                                        <td>{{ $item->business_address }}</td>
                                        <td><a class="badge bg-primary"
                                                href="{{ route('Admin.Machine.View', $item->uuid) }}">Lihat Mesin</a></td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td><a class="badge bg-info"
                                                href="{{ route('Admin.Business.Edit', $item->uuid) }}">Edit</a></td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Non-Aktif</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-non-aktif">
                            <thead>
                                <tr>
                                    <th>Form Pengajuan</th>
                                    <th>Nama Bisnis</th>
                                    <th>Foto Bisnis</th>
                                    <th>Deskripsi Bisnis</th>
                                    <th>Alamat Bisnis</th>
                                    <th>Mesin Sensor</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['non-aktif'] as $item)
                                    <tr>
                                        <td><a class="badge bg-primary"
                                                href="{{ route('Admin.Submission.Edit', $item->submission_uuid) }}">Lihat
                                                Form</a></td>
                                        <td>{{ $item->business_name }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                                                class="img-fluid" width="200">
                                        </td>
                                        <td>{{ $item->business_description }}</td>
                                        <td>{{ $item->business_address }}</td>
                                        <td><a class="badge bg-primary"
                                                href="{{ route('Admin.Machine.View', $item->uuid) }}">Lihat Mesin</a></td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td><a class="badge bg-info"
                                                href="{{ route('Admin.Business.Edit', $item->uuid) }}">Edit</a></td>
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
        showTb('aktif');
        showTb('non-aktif');
    </script>
@endsection
