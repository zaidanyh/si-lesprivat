@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('student.create') }}" class="btn btn-primary mb-3">Tambah</a>
            <div class="table-responsive">
                <table class="table table-bordered student-table" id="student-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Jenjang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#student-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/json/student',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'stage',
                    name: 'stage'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

</script>
@endpush
