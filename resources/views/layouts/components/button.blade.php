@if (isset($teacher))
<a href="{{ route('teacher.show', $teacher) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
<a href="{{ route('teacher.edit', $teacher) }}" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
<a href="#" class="btn btn-sm btn-danger btn-circle" data-toggle="modal" data-target="#deleteTeacherModal"><i class="fas fa-trash"></i></a>
<div class="modal fade" id="deleteTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Data?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Delete" if you want to delete the current data.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="event.preventDefault();
            document.getElementById('delete-teacher-form').submit();">Delete</a>
            <form id="delete-teacher-form" action="{{ route('teacher.destroy', $teacher) }}" method="POST" class="d-none">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</div>
@elseif (isset($student))
<a href="{{ route('student.show', $student) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
<a href="{{ route('student.edit', $student) }}" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
<a href="#" class="btn btn-sm btn-danger btn-circle" data-toggle="modal" data-target="#deleteStudentModal"><i class="fas fa-trash"></i></a>
<div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Data?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Delete" if you want to delete the current data.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="event.preventDefault();
            document.getElementById('delete-student-form').submit();">Delete</a>
            <form id="delete-student-form" action="{{ route('student.destroy', $student) }}" method="POST" class="d-none">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</div>
@elseif (isset($subject))
<a href="{{ route('subject.edit', $subject) }}" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
<a href="#" class="btn btn-sm btn-danger btn-circle" data-toggle="modal" data-target="#deleteSubjectModal"><i class="fas fa-trash"></i></a>
<div class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Data?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Delete" if you want to delete the current data.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="event.preventDefault();
            document.getElementById('delete-subject-form').submit();">Delete</a>
            <form id="delete-subject-form" action="{{ route('subject.destroy', $subject) }}" method="POST" class="d-none">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</div>
@endif