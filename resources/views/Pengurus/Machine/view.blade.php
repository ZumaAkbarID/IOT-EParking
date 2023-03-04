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
                                <a href="/{{ strtolower(Auth::user()->role) }}">Dashboard</a>
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

        <section class="section mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Usaha ID : {{ Auth::user()->business_uuid }}</h4>
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
                                        <td><a class="badge bg-info"
                                                href="{{ route('Pengurus.Machine.Edit', $item->uuid) }}">Edit</a> | <a
                                                class="badge bg-danger" href="#"
                                                onclick="deleteMachine('{{ $item->uuid }}')">Hapus</a></td>
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

        function deleteMachine(uuid) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mesin akan terhapus, namun laporan keuangan akan tetap ada",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "/pengurus/machine/delete/" + uuid,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            uuid: uuid
                        },
                        success: function(data) {
                            if (data.status == true) {
                                let timerInterval;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil dihapus!',
                                    html: 'auto refresh dalam <b></b> milidetik.',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const b = Swal.getHtmlContainer().querySelector(
                                            'b');
                                        timerInterval = setInterval(() => {
                                            b.textContent = Swal.getTimerLeft()
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    }
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: data.message
                                });
                            }
                        },
                    });
                }
            })
        }
    </script>
@endsection
