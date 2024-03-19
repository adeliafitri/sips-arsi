<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 10px">No</th>
            <th>Kode Sub CPMK</th>
            <th>Bentuk Soal</th>
            <th>Bobot Soal</th>
            <th>Waktu Pelaksanaan</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $datas)
        <tr>
            <td>{{ $startNumber++ }}</td>
            <td>{{ $datas->kode_subcpmk }}</td>
            <td>{{ $datas->bentuk_soal }}</td>
            <td>{{ $datas->bobot_soal }}</td>
            <td>{{ $datas->waktu_pelaksanaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>