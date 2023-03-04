@extends('Layouts.guest')

@section('guest_content')
    <div class="content-wrapper container">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Selamat datang di E-Parking</h4>
            </div>
            <div class="card-body">
                <p class="">E-parking merupakan solusi penerapan manajemen parkir yang menyeluruh dan terintegrasi.
                    Layanan E-Parking hadir sebagai inovasi solusi terbaru untuk menyelesaikan permasalahan masyarakat dalam
                    pelayanan parkir kendaraan, diharapkan E-parking dapat mempersingkat waktu untuk mencari lokasi slot
                    parkir yang kosong dan informasi jumlah slot lokasi parkir kosong secara cepat, realtime dan dapat
                    dengan mudah diakses dari manapun dan kapanpun.</p>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h6 class="card-title">Cari Destinasi Parkir</h6>
            </div>
            <div class="card-body">
                <div class="form-group">

                    <input type="search" name="cari" id="cari" class="form-control" placeholder="Cari Lokasi">
                    <p class="text-muted" id="searchMin">Ketikan minimal 2 huruf</p>

                </div>
            </div>
        </div>

        <section id="place"></section>

    </div>
    </div>
@endsection

@section('guest_script')
    <script src="{{ asset('/') }}assets/js/search.js"></script>
@endsection
