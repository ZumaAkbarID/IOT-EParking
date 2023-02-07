@extends('Layouts.guest')

@section('guest_content')
    <div class="container">

        <h1 class="mt-3 mb-0">Informasi {{ $place }}</h1>

        <section class="row mt-0">

            <div class="col-lg-4 col-sm-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Parkiran Tersedia</h4>
                    </div>
                    <div class="card-body">
                        <p class="">{{ number_format($available, 0, '.', ',') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Parkiran Terpakai</h4>
                    </div>
                    <div class="card-body">
                        <p class="">{{ number_format($total - $available, 0, '.', ',') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Jumlah Pakiran Tersedia</h4>
                    </div>
                    <div class="card-body">
                        <p class="">{{ number_format($total, 0, '.', ',') }}</p>
                    </div>
                </div>
            </div>

        </section>

        <section>
            TABEL
        </section>

    </div>
@endsection
