@extends('Layouts.guest')

@section('guest_content')
    <div class="content-wrapper container mb-5">

        <div class="row justify-content-center">
            <div class="col-lg-8 col-sm-12">
                <div class="card my-5">
                    <div class="card-header">
                        <h6 class="card-title">Kirim Pengajuan Usaha</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="submiter_name"></label>
                                <input type="text" name="submiter_name" id="submiter_name" placeholder="Nama Pengaju"
                                    class="form-control" required value="{{ old('submiter_name') }}">
                            </div>

                            <div class="form-group">
                                <label for="submiter_phone_number"></label>
                                <input type="text" name="submiter_phone_number" id="submiter_phone_number"
                                    placeholder="Nomor WA" class="form-control" required
                                    value="{{ old('submiter_phone_number') }}">
                            </div>

                            <div class="form-group">
                                <label for="business_name"></label>
                                <input type="text" name="business_name" id="business_name" placeholder="Nama Usaha"
                                    class="form-control" required value="{{ old('business_name') }}" minlength="2">
                            </div>

                            <div class="form-group">
                                <label for="business_description"></label>
                                <textarea name="business_description" id="business_description" placeholder="Deskripsi Usaha" class="form-control"
                                    required>{{ old('business_description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="business_address"></label>
                                <textarea name="business_address" id="business_address" placeholder="Alamat Usaha" class="form-control" required>{{ old('business_address') }}</textarea>
                            </div>

                            <div class="form-group mt-3 text-center">
                                <img src="https://via.placeholder.com/640x427" alt="" class="img-fluid"
                                    id="thumbnail">
                            </div>

                            <div class="form-group">
                                <label for="business_thumbnail"></label>
                                <input type="file" name="business_thumbnail" id="business_thumbnail" class="form-control"
                                    required>
                            </div>

                            <div class="form-group text-center mb-3">
                                <button type="submit" class="w-50 btn btn-primary">Kirim Pengajuan</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('guest_script')
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
