<div class="table-responsive" id="tabel-datatugas">
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th style="width: 10px">No</th>
                <th>Waktu Pelaksanaan</th>
                <th>Kode CPL</th>
                <th>Kode CPMK</th>
                <th>Kode Sub CPMK</th>
                <th>Bobot Soal</th>
                <th>Bentuk Soal</th>
                <th style="width: 75px">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php $no = $startNumber; @endphp
            @foreach ($groupedData as $bentukSoal => $group)
                @foreach ($group['items'] as $index => $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->waktu_pelaksanaan }}</td>
                        <td>{{ $datas->kode_cpl }}</td>
                        <td>{{ $datas->kode_cpmk }}</td>
                        <td>{{ $datas->kode_subcpmk }}</td>
                        <td>{{ $datas->bobot_soal }}%</td>

                        @if ($index === 0)
                            <td rowspan="{{ $group['count'] }}">{{ $bentukSoal }}</td>
                        @endif

                        <td>
                            <div id="nilai-tugas-{{ $datas->id_nilai }}"> {{ $datas->nilai }} </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="px-3 pt-3 d-flex justify-content-end">
        {!! $data->links('pagination::bootstrap-4') !!}
    </div>
</div>
{{-- @section('script')
<script>
    function editNilai(id){
        Swal.fire({
        title: "Anda Yakin?",
        text: "Ubah Nilai Tugas",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, ubah!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-nilai-tugas-button-' + id).submit();

            }
        });

        }
</script>
@endsection --}}
