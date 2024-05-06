<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 10px">No</th>
            <th>Kode CPL</th>
            <th>Bobot Soal</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        {{-- @php
            $no = 1;
        @endphp --}}
        @foreach ($data as $key =>  $datas)
        <tr>
            <td>{{ $key+ 1 }}</td>
            <td>{{ $datas->kode_cpl }}</td>
            <td>{{ $datas->bobot_soal }}%</td>
            <td>{{ round($datas->total_nilai, 1) }}</td>
        </tr>
        {{-- @php
            $no++;
        @endphp --}}
        @endforeach
    </tbody>
</table>
