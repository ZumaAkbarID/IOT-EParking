@extends('Layouts.guest')

@section('guest_content')
    <div class="content-wrapper container">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12">
                <div class="card my-5">
                    <div class="card-header">
                        <h6 class="card-title">Login</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="phone">Nomor HP</label>
                                <input type="text" name="phone" id="phone" class="form-control" required
                                    placeholder="08xxx">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group text-center mb-3">
                                <button type="submit" class="w-50 btn btn-primary">Login</button>
                            </div>

                        </form>

                        <div class="">
                            <p>Lupa password? <a href="">Hubungi Admin</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

@section('guest_script')
    @include('Layouts.sweetalert2')
@endsection
