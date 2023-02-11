@extends('Layouts.dashboard')

@section('dashboard_style')
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Mesin</h3>
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

        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    @csrf

                    <input type="hidden" name="business_uuid" value="{{ $business->uuid }}">

                    <div class="form-group">
                        <label for="">ID Mesin (Tidak bisa dirubah)</label>
                        <input type="text" name="uuid" id="" class="form-control" readonly
                            value="{{ $data->uuid }}">
                    </div>

                    <div class="form-group">
                        <label for="machine_name">Nama Mesin</label>
                        <input type="text" name="machine_name" id="machine_name" class="form-control" required
                            value="{{ $data->machine_name }}">
                    </div>

                    <div class="form-group">
                        <label for="total_sensor">Total Sensor</label>
                        <p class="text-muted">Request pada Admin untuk penambahan atau pengurangan sensor</p>
                        <input type="number" name="total_sensor" id="total_sensor" readonly
                            value="{{ $data->total_sensor }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="price_each_sensor">Harga</label>
                        <input type="number" name="price_each_sensor" id="price_each_sensor" required
                            value="{{ $data->price_each_sensor }}" class="form-control">
                    </div>

                    <div class="form-group text-end mt-3">
                        <button type="submit" class="btn btn-primary">Perbarui Data Mesin</button>
                        <a href="{{ route('Pengurus.Machine.All') }}" class="btn btn-danger">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('dashboard_script')
    @include('Layouts.sweetalert2')
@endsection
