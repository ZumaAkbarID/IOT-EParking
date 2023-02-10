@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Laporan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Laporan
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
                            Total Usaha
                        </h6>
                        <h6 class="font-extrabold mb-0">{{ number_format(count($data['business_all']), 0, '.', ',') }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body py-4-5 text-center">
                        <h6 class="text-muted font-semibold">
                            Total Pemasukan Semua Usaha {{ date('Y') }}
                        </h6>
                        <h6 class="font-extrabold mb-0">Rp. {{ number_format($data['yearly_report']), 0, '.', ',' }}</h6>
                    </div>
                </div>
            </div>

        </div>

        <section class="section mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Pemasukan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tb-laporan">
                            <thead>
                                <tr>
                                    <th>Nama Usaha</th>
                                    <th>Nomor HP</th>
                                    <th>Role</th>
                                    <th>Usaha</th>
                                    <th>Didaftarkan Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ([] as $item)
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
        showTb('laporan');
    </script>
@endsection
