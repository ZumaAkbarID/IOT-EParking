@extends('Layouts.guest')

@section('guest_content')
    <div class="container">

        <h3 class="mt-3">Informasi {{ $place }}</h3>

        <section class="row mt-0">

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Parkiran Tersedia</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center">{{ number_format($available, 0, '.', ',') }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Parkiran Terpakai</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center">{{ number_format($total - $available, 0, '.', ',') }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Jumlah Pakiran Tersedia</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center">{{ number_format($total, 0, '.', ',') }}</h2>
                    </div>
                </div>
            </div>

        </section>

        <section>
            {{-- misal data adalah  --}}
            @php
                $data = [
                    'place_1' => rand(0, 1),
                    'place_2' => rand(0, 1),
                    'place_3' => rand(0, 1),
                ];
            @endphp

            <div class="row">
                <div class="col-4">

                    <table class="table table-bordered">
                        <tr>
                            <td></td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        @for ($i = 1; $i <= count($data); $i++)
                            <tr>
                                <td>Car {{ $i }}</td>
                                <td>: {{ $data['place_' . $i] == 1 ? 'Dipakai' : 'Kosong' }}</td>
                            </tr>
                        @endfor
                    </table>

                    <table class="table table-bordered">
                        <tr>
                            <td></td>
                        </tr>
                    </table>

                </div>

                <div class="col-4">

                    <table class="table table-bordered">
                        <tr>
                            <td></td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <tr>
                            <td></td>
                        </tr>
                    </table>

                </div>
            </div>

        </section>

    </div>
@endsection

@section('guest_script')
    <script src="/build/assets/app-0ee73409.js"></script>
@endsection
