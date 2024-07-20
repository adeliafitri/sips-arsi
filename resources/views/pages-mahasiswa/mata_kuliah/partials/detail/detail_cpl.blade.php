<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 10px">No</th>
            <th>Kode CPL</th>
            <th>Jenis CPL</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $datas)
        <tr>
            <td>{{ $startNumber++ }}</td>
            <td>{{ $datas->kode_cpl }}</td>
            <td>{{ $datas->jenis_cpl }}</td>
            <td>{{ $datas->deskripsi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<ul class="pagination pagination-sm mb-2 float-right">
    <div class="float-right">
        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>
</ul>
