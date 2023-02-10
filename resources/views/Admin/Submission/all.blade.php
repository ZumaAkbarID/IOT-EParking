@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pengajuan Usaha</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pengajuan Usaha
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Status Review
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['review']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Status Diterima
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['approved']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Status Ditolak
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['rejected']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Review</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-review">
                            <thead>
                                <tr>
                                    <th>Nama Pengaju</th>
                                    <th>Nomor HP Pengaju</th>
                                    <th>Nama Bisnis</th>
                                    <th>Foto Bisnis</th>
                                    <th>Deskripsi Bisnis</th>
                                    <th>Alamat Bisnis</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['review'] as $item)
                                    <tr>
                                        <td>{{ $item->submiter_name }}</td>
                                        <td>{{ $item->submiter_phone_number }}</td>
                                        <td>{{ $item->business_name }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                                                class="img-fluid" width="200">
                                        </td>
                                        <td>{{ $item->business_description }}</td>
                                        <td>{{ $item->business_address }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td><a href="{{ route('Admin.Submission.Edit', $item->uuid) }}">Edit</a></td>
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
                    <h4 class="card-title">Data Diterima</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-approved">
                            <thead>
                                <tr>
                                    <th>Nama Pengaju & Akun</th>
                                    <th>Nomor HP Pengaju</th>
                                    <th>Nama Bisnis</th>
                                    <th>Foto Bisnis</th>
                                    <th>Deskripsi Bisnis</th>
                                    <th>Alamat Bisnis</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Diperbarui Pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['approved'] as $item)
                                    <tr>
                                        <td><a
                                                href="{{ route('Admin.User.Edit', $item->submiter_phone_number) }}">{{ $item->submiter_name }}</a>
                                        </td>
                                        <td>{{ $item->submiter_phone_number }}</td>
                                        <td>{{ $item->business_name }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                                                class="img-fluid" width="200">
                                        </td>
                                        <td>{{ $item->business_description }}</td>
                                        <td>{{ $item->business_address }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
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
                    <h4 class="card-title">Data Review</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-rejected">
                            <thead>
                                <tr>
                                    <th>Nama Pengaju</th>
                                    <th>Nomor HP Pengaju</th>
                                    <th>Nama Bisnis</th>
                                    <th>Foto Bisnis</th>
                                    <th>Deskripsi Bisnis</th>
                                    <th>Alamat Bisnis</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['rejected'] as $item)
                                    <tr>
                                        <td>{{ $item->submiter_name }}</td>
                                        <td>{{ $item->submiter_phone_number }}</td>
                                        <td>{{ $item->business_name }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                                                class="img-fluid" width="200">
                                        </td>
                                        <td>{{ $item->business_description }}</td>
                                        <td>{{ $item->business_address }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                                        <td><a href="{{ route('Admin.Submission.Edit', $item->uuid) }}">Edit</a></td>
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
        showTb('review');
        showTb('approved');
        showTb('rejected');
    </script>
@endsection
