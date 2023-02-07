@extends('Layouts.guest')

@section('guest_content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Selamat datang di E-Parking</h4>
            </div>
            <div class="card-body">
                <p class="">E-Parking adalah aplikasi ini akwakwkawkakw. Lorem ipsum, dolor sit amet consectetur
                    adipisicing elit. Nesciunt, tempore exercitationem ut, illo incidunt eligendi officiis, blanditiis
                    vitae quisquam praesentium dolore hic sed. Voluptates blanditiis debitis, adipisci nobis ex harum
                    accusantium aliquid quam reiciendis, tempora, odio porro qui error laboriosam voluptate omnis
                    ratione quibusdam distinctio suscipit. Rem quia quo labore?</p>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h6 class="card-title">Cari Destinasi Parkir</h6>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">

                    <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari Lokasi">

                </div>
            </div>
        </div>

        <section id="place"></section>

    </div>
@endsection

@section('guest_script')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#cari').keyup(() => {
                let cari = $('#cari').val();
                $.ajax({
                    type: "post",
                    url: "/search/" + cari,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        cari: cari
                    },
                    success: function(data) {
                        if (data.status == true) {
                            console.log(data.message);
                            $('#place').html(data.html);
                        } else {
                            alert(data.message);
                        }
                    },
                });
            });
        });
    </script>
@endsection
