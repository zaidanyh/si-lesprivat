@extends('layouts.main')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
    integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"
    integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg=="
    crossorigin="anonymous"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
    integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g=="
    crossorigin="anonymous" />

<style>
    #mapid {
        height: 300px;
    }

</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Guru</h1>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4 p-2">
                        <img src="{{ $teacher->photo }}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher->name }}</h5>
                            <p class="card-text">Email : {{ $teacher->email }}</p>
                            <p class="card-text">Telepon : {{ $teacher->phone }}</p>
                            <a href="{{ route('teacher.attendance.print', $teacher) }}"
                                class="btn btn-primary mt-3">Rekap
                                Absen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">Alamat : {{ $teacher->address }}</p>
                    <p class="card-text">Tanggal Lahir: {{ $teacher->birth_date }}</p>
                    <p class="card-text">Pendidikan: {{ $teacher->education }}</p>
                    <p class="card-text">IPK: {{ $teacher->gpa }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md">
                        <div class="card-body">
                            <h5 class="card-title">Mata Pelajaran</h5>
                            <ul class="list-group list-group-horizontal">
                                @foreach ($teacher->subjects as $subject)
                                <li class="list-group-item">
                                    {{ $subject->name . ' ' . $subject->stage }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('teacher_subject.edit', $teacher) }}"
                                class="btn btn-primary mt-3">Ubah</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            Peta
        </div>
        <div class="card-body">
            <div id="mapid"></div>
            <script>
                const mymap = L.map('mapid').setView(['{{ $teacher->latitude }}', '{{ $teacher->longitude }}'], 17);
                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1IjoiZHdpLXJpZmFsZGk0MTI5OSIsImEiOiJja2JsdDRnd2MxYzh4Mnhsc25ndXZwcjQyIn0.vYl2V9F_D-qdVwc0IMg6zA'
                }).addTo(mymap);

                L.marker(['{{ $teacher->latitude }}', '{{ $teacher->longitude }}']).addTo(mymap);

            </script>
        </div>
    </div>
</div>
@endsection
