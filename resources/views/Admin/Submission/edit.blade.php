@extends('Layouts.dashboard')

@section('dashboard_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
@endsection

@section('dashboard_content')
    <div class="page-heading">
        <div class="page-title mb-5">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Data Pengajuan Usaha</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Admin.Dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pengajuan Usaha
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
                        <label for="submiter_name">Nama Pengaju</label>
                        <input type="text" name="submiter_name" id="submiter_name" class="form-control" required
                            value="{{ $data->submiter_name }}">
                    </div>

                    <div class="form-group">
                        <label for="submiter_phone_number">Nomor HP Pengaju</label>
                        <input type="text" name="submiter_phone_number" id="submiter_phone_number" class="form-control"
                            required value="{{ $data->submiter_phone_number }}">
                    </div>

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
                        <img src="{{ asset('storage') . '/' . $data->business_thumbnail }}" width="300"
                            class="img-fluid">
                    </div>

                    <div class="form-group">
                        <label for="business_thumbnail">Foto Usaha</label>
                        <input type="file" name="business_thumbnail" id="business_thumbnail" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <p class="text-muted">Usaha status review yang sudah dirubah tidak bisa menjadi review lagi</p>
                        <select name="status" id="status" required class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="approved" @if ($data->status == 'approved') selected @endif>Diterima</option>
                            <option value="rejected" @if ($data->status == 'rejected') selected @endif>Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group" id="reject-reason">
                        <label for="reject_reason">Alasan Ditolak</label>
                        <textarea name="reject_reason" id="reject_reason" class="form-control">{{ $data->reject_reason }}</textarea>
                    </div>

                    <div class="form-group text-end mt-3">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('Admin.Submission') }}" class="btn btn-danger">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('dashboard_script')
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    @include('Layouts.sweetalert2')
    <script>
        $('#reject-reason').hide();

        $('#status').on('change', function() {
            let status = $('#status').val();

            if (status == 'rejected') {
                $('#reject-reason').show();
                $('#reject_reason').attr('required', 'required');
            } else {
                $('#reject-reason').hide();
                $('#reject_reason').removeAttr('required');
            }
        });
    </script>
@endsection
