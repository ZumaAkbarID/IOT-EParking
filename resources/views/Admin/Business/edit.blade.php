@extends('Layouts.dashboard')

@section('dashboard_style')
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Data Usaha</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Usaha
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $data->uuid }}">

                    <div class="form-group">
                        <label for="business_name">Nama Bisnis</label>
                        <input type="text" name="business_name" id="business_name" class="form-control" required
                            value="{{ $data->business_name }}">
                    </div>

                    <div class="form-group">
                        <label for="business_description">Deskripsi Bisnis</label>
                        <textarea name="business_description" id="business_description" class="form-control" required>{{ $data->business_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="business_address">Alamat Bisnis</label>
                        <textarea name="business_address" id="business_address" class="form-control" required>{{ $data->business_address }}</textarea>
                    </div>

                    <div class="form-group mt-5">
                        <img src="{{ asset('storage') . '/' . $data->business_thumbnail }}" width="300" class="img-fluid"
                            id="thumbnail">
                    </div>

                    <div class="form-group">
                        <label for="business_thumbnail">Foto Usaha</label>
                        <input type="file" name="business_thumbnail" id="business_thumbnail" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <p class="text-muted">Jika ingin merubah ke aktif. pastikan sudah input mesin & menguji setidaknya
                            1x.</p>
                        <select name="status" id="status" required class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="aktif" @if ($data->status == 'aktif') selected @endif>Aktif</option>
                            <option value="non-aktif" @if ($data->status == 'non-aktif') selected @endif>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="form-group text-end mt-3">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('Admin.Business.All') }}" class="btn btn-danger">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('dashboard_script')
    @include('Layouts.sweetalert2')
    <script>
        $('#business_thumbnail').change(function() {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#thumbnail').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
