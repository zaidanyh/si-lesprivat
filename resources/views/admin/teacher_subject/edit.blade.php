@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Mapel Guru</h1>
    </div>

    <form action="{{ route('teacher_subject.update', $teacher) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Guru</label>
            <input type="hidden" class="form-control" id="teacher_id" name="teacher_id" value="{{ $teacher->id }}"
                readonly>
            <input type="text" class="form-control" id="name" value="{{ $teacher->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="subject">Mata Pelajaran</label>
            @php
            $data = [];
            foreach ($teacher->subjects as $tsubject) {
            $data[] = $tsubject->id;
            }
            @endphp
            @foreach ($subjects as $subject)
            @if (in_array($subject->id, $data))
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $subject->id }}" id="subject_id"
                    name="subject_ids[]" checked>
                <label class="form-check-label ml-2" for="subject_id">
                    {{ $subject->name . ' ' . $subject->stage }}
                </label>
            </div>
            @else
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $subject->id }}" id="subject_id"
                    name="subject_ids[]">
                <label class="form-check-label ml-2" for="subject_id">
                    {{ $subject->name . ' ' . $subject->stage }}
                </label>
            </div>
            @endif
            @endforeach
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </form>
</div>
@endsection
