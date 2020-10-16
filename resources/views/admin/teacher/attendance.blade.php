<!DOCTYPE html>
<html>

<head>
    <title>Rekap Absensi Guru</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        h1 {
            text-align: center;
        }

    </style>

    <h1>Rekap Absensi</h1>
    <p class="mt-4">Nama : {{ $teacher->name }}</p>
    <p>Alamat : {{ $teacher->address }}</p>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Mengajar</th>
                <th>Jam Absen Masuk</th>
                <th>Jam Absen Keluar</th>
                <th>Siswa</th>
                <th>Mapel</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $attendance->teaching_date }}</td>
                <td>{{ $attendance->attendance_time }}</td>
                <td>{{ $attendance->leave_time }}</td>
                <td>{{ $attendance->schedule->student->name }}</td>
                <td>{{ $attendance->schedule->teacher_subject->subject->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
