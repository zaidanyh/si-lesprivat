@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Mapel</h1>
    </div>

    <form action="{{ route('subject.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nama Mapel</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="stage" class="col-sm-2 col-form-label">Jenjang</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="stage" name="stage" value="{{ $subject->stage }}">
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
