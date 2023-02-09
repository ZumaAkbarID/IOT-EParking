<table class="table table-bordered table-hover" id="tb-{{ $parking->machine_uuid }}">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @php
            $map = json_decode($parking->map, true);
        @endphp
        @for ($i = 1; $i <= count($map); $i++)
            <tr>
                <td>Car {{ $i }}</td>
                <td>: {{ $map['place_' . $i] == 1 ? 'Dipakai' : 'Kosong' }}</td>
            </tr>
        @endfor
    </tbody>
</table>
