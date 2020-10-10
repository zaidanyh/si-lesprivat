@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Absensi</h1>
    </div>

    <div id="calendar">

    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Edit Appointment</h4>

                Start time:
                <br />
                <input type="text" class="form-control" name="start_time" id="start_time">

                End time:
                <br />
                <input type="text" class="form-control" name="finish_time" id="finish_time">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="button" class="btn btn-primary" id="appointment_update" value="Save">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"
    integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            eventColor: '#0984e3',
            eventTextColor: '#dfe6e9',
            events: [
                @foreach($attendances as $attendance) {
                    title: '{{ $attendance->schedule->teacher_subject->teacher->name }}',
                    start: '{{ $attendance->teaching_date . ' ' . $attendance->attendance_time }}',
                },
                @endforeach
            ],
            eventClick: function(calEvent, jsEvent, view) {
                $('#start_time').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                $('#finish_time').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                $('#detailModal').modal();
                console.log('clicked')
            }
        });
    });

</script>
@endpush
