@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Akun</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Akun
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
                            Total Admin
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['admin']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Total Pengurus
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['pengurus']), 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>

        </div>

        <section class="section mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Akun | Password Default : parkiranku</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-akun">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nomor HP</th>
                                    <th>Role</th>
                                    <th>Usaha</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $foundBusi = false;
                                @endphp
                                @forelse ($data['all'] as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $item->role }}</td>
                                        @foreach ($data['business'] as $busi)
                                            @if ($busi->uuid == $item->business_uuid)
                                                <td><a class="badge bg-primary"
                                                        href="{{ route('Admin.Business.Edit', $busi->uuid) }}">{{ $busi->business_name }}</a>
                                                </td>
                                                @php
                                                    $foundBusi = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($foundBusi == false)
                                            <td>
                                                <p class="badge bg-secondary m-0">Tidak ada</p>
                                            </td>
                                        @endif
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                                        @if ($item->role == 'Admin')
                                            <td>
                                                <p class="badge bg-secondary m-0">Tidak ada</p>
                                            </td>
                                        @else
                                            <td><a class="badge bg-info"
                                                    href="{{ route('Admin.User.Edit', $item->uuid) }}">Edit</a></td>
                                        @endif
                                    </tr>
                                    @php
                                        $foundBusi = false;
                                    @endphp
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
        showTb('akun');
    </script>
@endsection
