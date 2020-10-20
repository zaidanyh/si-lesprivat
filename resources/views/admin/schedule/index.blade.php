@extends('layouts.main')

@push('head')
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
@endpush

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal</h1>
    </div>

    <div id="calendar">

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('schedule.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ubah Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="form-group">
                        <label for="date_edit">Tanggal</label>
                        <input type="text" class="form-control datetimepicker-input" id="date_edit" name="date"
                            data-toggle="datetimepicker" data-target="#date_edit" />
                        <script type="text/javascript">
                            $(function () {
                                $('#date_edit').datetimepicker({
                                    format: 'Y-MM-DD'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="start_time_edit">Jam Mulai</label>
                        <input type="text" class="form-control datetimepicker-input" id="start_time_edit"
                            name="start_time" data-toggle="datetimepicker" data-target="#start_time_edit" />
                        <script type="text/javascript">
                            $(function () {
                                $('#start_time_edit').datetimepicker({
                                    format: 'HH:mm:ss'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="end_time_edit">Jam Selesai</label>
                        <input type="text" class="form-control datetimepicker-input" id="end_time_edit" name="end_time"
                            data-toggle="datetimepicker" data-target="#end_time_edit" />
                        <script type="text/javascript">
                            $(function () {
                                $('#end_time_edit').datetimepicker({
                                    format: 'HH:mm:ss'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="student_id_edit">Nama Siswa</label>
                        <select class="form-control" id="student_id_edit" name="student_id">
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher_subject_id_edit">Guru dan Mapel</label>
                        <select class="form-control" id="teacher_subject_id_edit" name="teacher_subject_id">
                            @foreach ($teacher_subjects as $teacher_subject)
                            <option value="{{ $teacher_subject->id }}">
                                {{ $teacher_subject->teacher->name . ' - ' .  $teacher_subject->subject->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('schedule.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date_add">Tanggal</label>
                        <input type="text" class="form-control datetimepicker-input" id="date_add" name="date"
                            data-toggle="datetimepicker" data-target="#date_add" />
                        <script type="text/javascript">
                            $(function () {
                                $('#date_add').datetimepicker({
                                    format: 'Y-MM-DD'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="start_time_add">Jam Mulai</label>
                        <input type="text" class="form-control datetimepicker-input" id="start_time_add"
                            name="start_time" data-toggle="datetimepicker" data-target="#start_time_add" />
                        <script type="text/javascript">
                            $(function () {
                                $('#start_time_add').datetimepicker({
                                    format: 'HH:mm:ss'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="end_time_add">Jam Selesai</label>
                        <input type="text" class="form-control datetimepicker-input" id="end_time_add" name="end_time"
                            data-toggle="datetimepicker" data-target="#end_time_add" />
                        <script type="text/javascript">
                            $(function () {
                                $('#end_time_add').datetimepicker({
                                    format: 'HH:mm:ss'
                                });
                            });

                        </script>
                    </div>
                    <div class="form-group">
                        <label for="student_id">Nama Siswa</label>
                        <select class="form-control" id="student_id" name="student_id">
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher_subject_id">Guru dan Mapel</label>
                        <select class="form-control" id="teacher_subject_id" name="teacher_subject_id">
                            @foreach ($teacher_subjects as $teacher_subject)
                            <option value="{{ $teacher_subject->id }}">
                                {{ $teacher_subject->teacher->name . ' - ' .  $teacher_subject->subject->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
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
                @foreach($schedules as $schedule) {
                    id: '{{ $schedule->id }}',
                    title: '{{ $schedule->title }}',
                    start: '{{ $schedule->start }}',
                    end: '{{ $schedule->end }}',
                    student: '{{ $schedule->student }}',
                    teacher: '{{ $schedule->teacher }}',
                    color: '{{ $schedule->color }}',
                },
                @endforeach
            ],
            dayClick: function (date, jsEvent, view) {
                $('#date_add').val(moment(date).format('YYYY-MM-DD'));
                $('#start_time_add').val(moment(date).format('HH:mm:ss'));
                $('#end_time_add').val(moment(date).format('HH:mm:ss'));
                $('#addModal').modal();
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#id').val(calEvent.id);
                $('#date_edit').val(moment(calEvent.start).format('YYYY-MM-DD'));
                $('#start_time_edit').val(moment(calEvent.start).format('HH:mm:ss'));
                $('#end_time_edit').val(moment(calEvent.end).format('HH:mm:ss'));
                $("#student_id_edit").val(calEvent.student).change();
                $("#teacher_subject_id_edit").val(calEvent.teacher).change();
                $('#editModal').modal();
            }
        });
    });

</script>
@endpush
