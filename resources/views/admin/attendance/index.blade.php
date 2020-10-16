@extends('layouts.main')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>

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
        <h1 class="h3 mb-0 text-gray-800">Absensi</h1>
    </div>

    <div id="calendar">

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mapid" class="mt-2"></div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <script>
                    const mymap = L.map('mapid').setView([-7.947670, 112.615980], 17);
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom: 18,
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1,
                        accessToken: 'pk.eyJ1IjoiZHdpLXJpZmFsZGk0MTI5OSIsImEiOiJja2JsdDRnd2MxYzh4Mnhsc25ndXZwcjQyIn0.vYl2V9F_D-qdVwc0IMg6zA'
                    }).addTo(mymap);

                    $('#detailModal').on('shown.bs.modal', function () {
                        mymap.invalidateSize();
                        mymap.panTo(new L.LatLng(lat, lng));
                        const marker = L.marker([lat, lng]).addTo(mymap);
                        marker.bindPopup("Keterangan").openPopup();
                    });

                </script>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
    integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listMonth'
            },
            eventLimit: true,
            events: [
                @foreach($attendances as $attendance) {
                    title: '{{ $attendance->title }}',
                    start: '{{ $attendance->start }}',
                    latitude: '{{ $attendance->latitude }}',
                    longitude: '{{ $attendance->longitude }}',
                    color: '{{ $attendance->color }}',
                },
                @endforeach
            ],
            eventClick: function (calEvent, jsEvent, view) {
                $('#start_time').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                $('#finish_time').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                window.lat = calEvent.latitude;
                window.lng = calEvent.longitude;
                $('#detailModal').modal();
            }
        });
    });

</script>
@endpush
