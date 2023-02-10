@extends('Layouts.dashboard')

@section('dashboard_style')
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Akun</h3>
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

        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    @csrf

                    <input type="hidden" name="uuid" value="{{ $data->uuid }}">

                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" id="" class="form-control" required
                            value="{{ $data->name }}">
                    </div>

                    <div class="form-group">
                        <label for="">Nomor HP</label>
                        <input type="text" name="phone_number" id="" class="form-control" required
                            value="{{ $data->phone_number }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru (abaikan jika tidak ingin merubah)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group text-end mt-3">
                        <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        <a href="{{ route('Admin.User.All') }}" class="btn btn-danger">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('dashboard_script')
    @include('Layouts.sweetalert2')
@endsection
