@extends('Layouts.guest')

@section('guest_content')
    <div class="content-wrapper container">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Selamat datang di E-Parking</h4>
            </div>
            {{-- <div class="card-body">
                <p class="">E-Parking adalah aplikasi berbasis web yang memudahkan pengunjung untuk mengecek
                    ketersediaan parkiran secara realtime sebelum mengunjungi lokasi.</p>
            </div> --}}
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h6 class="card-title">Cari Destinasi Parkir</h6>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">

                    <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari Lokasi">

                </div>
            </div>
        </div>

        <section id="place"></section>

    </div>
    </div>
@endsection

@section('guest_script')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#cari').keyup(() => {
                let cari = $('#cari').val();
                $.ajax({
                    type: "post",
                    url: "/ajax/cari/" + cari,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        cari: cari
                    },
                    success: function(data) {
                        if (data.status == true) {
                            $('#place').html(data.html);
                        } else {
                            alert(data.message);
                        }
                    },
                });
            });
        });
    </script>
@endsection
