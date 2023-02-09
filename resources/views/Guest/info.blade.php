@extends('Layouts.guest')

@section('guest_style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <style>
        .dataTables_filter input {
            color: white;
            background-color: black;

        }

        select[name="parkiran-tb_length"] {
            color: white;
            background-color: black;

        }

        .dataTables_length select option {
            color: black;
        }
    </style>
@endsection

@section('guest_content')
    <input type="hidden" name="" id="uuid" value="{{ $uuid }}">
    <input type="hidden" name="" id="total" value="{{ $data['total'] }}">

    @foreach ($machines as $machine)
        <input type="hidden" name="" id="used_{{ $machine->uuid }}" value="{{ $data['used_' . $machine->uuid] }}">
    @endforeach

    <div class="content-wrapper container">

        <h3 class="mt-3 mb-4">Informasi {{ $place }}</h3>

        <section class="row mt-0">

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Parkiran Tersedia</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center" id="placeholder_available">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Parkiran Terpakai</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center" id="placeholder_used">{{ $data['used'] }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h4 class="card-title">Jumlah Pakiran</h4>
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <h2 class="text-center">{{ $data['total'] }}</h2>
                    </div>
                </div>
            </div>

        </section>

        <section>

            <div class="row">

                @foreach ($machines as $machine)
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Parkiran : {{ $machine->machine_name }}</h5>
                                <div class="table-responsive" id="holder-tb-{{ $machine->uuid }}">

                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

        </section>

    </div>
@endsection

@section('guest_script')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        // Pusher.logToConsole = true;

        let uuid = $('#uuid').val();

        function dataTb(machine_id) {
            $('#tb-' + machine_id).DataTable({
                order: [],
                ordering: false,
                language: {
                    search: "Cari",
                    lengthMenu: "Tampilkan _MENU_ data",
                    emptyTable: "Data tidak ditemukan",
                    infoEmpty: "Tidak menampilkan data apapun",
                    infoFiltered: "difilter dari _MAX_ data",
                    zeroRecords: "Tidak ada data",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                },
            });
        }

        function getTb(uuid, machine_id) {
            $.ajax({
                type: "post",
                url: "/ajax/table/" + uuid + "/" + machine_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    uuid: uuid,
                    machine_id: machine_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#holder-tb-' + machine_id).html();
                        $('#holder-tb-' + machine_id).html(data.html);
                        dataTb(machine_id);
                    } else {
                        alert(data.message);
                    }
                },
            });
        }

        @foreach ($machines as $machine)
            getTb(uuid, "{{ $machine->uuid }}");
        @endforeach

        let total = $('#total').val();
        let used = 0;

        @foreach ($machines as $machine)
            used += parseInt($('#used_{{ $machine->uuid }}').val());
        @endforeach

        $('#placeholder_available').empty();
        $('#placeholder_available').html(total - used);

        $('#placeholder_used').empty();
        $('#placeholder_used').html(used);

        var pusher = new Pusher('077a1f50c5eac9602b7b', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('update-parkiran');

        channel.bind('event-parkiran-' + $('#uuid').val(), function(response) {
            console.log(response);
            let data = JSON.parse(response.json);
            if (data.sender == 'sensor') {
                $('#used_' + data.machine_id).val(data.inside);

                let total = $('#total').val();
                let used = 0;

                @foreach ($machines as $machine)
                    used += parseInt($('#used_{{ $machine->uuid }}').val());
                @endforeach

                $('#placeholder_available').empty();
                $('#placeholder_available').html(total - used);

                $('#placeholder_used').empty();
                $('#placeholder_used').html(used);

                let uuid = $('#uuid').val();

                getTb(uuid, data.machine_id);
            }
        });
    </script>
@endsection
