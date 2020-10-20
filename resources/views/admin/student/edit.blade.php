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
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Siswa</h1>
    </div>

    <form action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nama Siswa</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $student->phone }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" value="{{ $student->address }}">
                <div id="mapid" class="mt-2"></div>
                <script>
                    const mymap = L.map('mapid').setView(['{{ $student->latitude }}', '{{ $student->longitude }}'], 17);
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom: 18,
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1,
                        accessToken: 'pk.eyJ1IjoiZHdpLXJpZmFsZGk0MTI5OSIsImEiOiJja2JsdDRnd2MxYzh4Mnhsc25ndXZwcjQyIn0.vYl2V9F_D-qdVwc0IMg6zA'
                    }).addTo(mymap);

                    mymap.on('click', onMapClick);

                    let marker = L.marker(['{{ $student->latitude }}', '{{ $student->longitude }}']).addTo(mymap);;

                    function onMapClick(e) {
                        if (marker != null) {
                            mymap.removeLayer(marker);
                        }
                        marker = L.marker(e.latlng).addTo(mymap);
                        $('#latitude').val(e.latlng.lat);
                        $('#longitude').val(e.latlng.lng);
                    }

                </script>
            </div>
        </div>
        <input type="hidden" class="form-control" id="latitude" name="latitude" value="{{ $student->latitude }}">
        <input type="hidden" class="form-control" id="longitude" name="longitude" value="{{ $student->longitude }}">
        <div class="form-group row">
            <label for="birth_date" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
                <input type="text" class="form-control datetimepicker-input" id="birth_date" name="birth_date"
                    data-toggle="datetimepicker" data-target="#birth_date" />
                <script type="text/javascript">
                    $(function () {
                        $('#birth_date').datetimepicker({
                            defaultDate: "{{ $student->birth_date }}",
                            format: 'Y-MM-DD'
                        });
                    });

                </script>
            </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <select class="form-control" id="gender">
                    @if ($student->gender == 'Laki-laki')
                    <option value="Laki-laki" selected>Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    @else
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan" selected>Perempuan</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-group row">
            <label for="education" class="col-sm-2 col-form-label">Kelas</label>
            <div class="col-sm-10">
                <select class="form-control" id="class" name="class">
                    <option value="{{ $student->class }}">{{ $student->class }}</option>
                    <option value="4 SD">4 SD</option>
                    <option value="5 SD">5 SD</option>
                    <option value="6 SD">6 SD</option>
                    <option value="7 SMP">7 SMP</option>
                    <option value="8 SMP">8 SMP</option>
                    <option value="9 SMP">9 SMP</option>
                    <option value="10 SMA">10 SMA</option>
                    <option value="11 SMA">11 SMA</option>
                    <option value="12 SMA">12 SMA</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="photo" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </form>
</div>
@endsection
