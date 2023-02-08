@extends('Layouts.guest')

@section('guest_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('guest_content')
    <div class="container">

        <h3 class="mt-3 mb-4">Informasi {{ $place }}</h3>

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
                    'place_4' => rand(0, 1),
                    'place_5' => rand(0, 1),
                    'place_6' => rand(0, 1),
                    'place_7' => rand(0, 1),
                    'place_8' => rand(0, 1),
                    'place_9' => rand(0, 1),
                    'place_10' => rand(0, 1),
                    'place_11' => rand(0, 1),
                    'place_12' => rand(0, 1),
                    'place_13' => rand(0, 1),
                    'place_14' => rand(0, 1),
                    'place_15' => rand(0, 1),
                ];
                $countedData = count($data);
                $dataTable = round($countedData / 3);
            @endphp

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered" id="parkiran-tb">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @for ($i = 1; $i <= count($data); $i++)
                                        <tr>
                                            <td>Car {{ $i }}</td>
                                            <td>: {{ $data['place_' . $i] == 1 ? 'Dipakai' : 'Kosong' }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

        </section>

    </div>
@endsection

@section('guest_script')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        // Pusher.logToConsole = true;

        $(document).ready(function() {
            $('#parkiran-tb').DataTable();
        });

        var pusher = new Pusher('077a1f50c5eac9602b7b', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('message');

        channel.bind('ParkiranUpdate', function(data) {
            console.log(JSON.stringify(data));
        });
    </script>
@endsection
