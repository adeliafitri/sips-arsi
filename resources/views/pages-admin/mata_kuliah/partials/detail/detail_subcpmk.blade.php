<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 10px">No</th>
            <th>Kode CPMK</th>
            <th>Kode Sub CPMK</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $datas)
        <tr>
            <td>{{ $startNumber++ }}</td>
            <td>{{ $datas->kode_cpmk }}</td>
            <td>{{ $datas->kode_subcpmk }}</td>
            <td>{{ $datas->deskripsi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>