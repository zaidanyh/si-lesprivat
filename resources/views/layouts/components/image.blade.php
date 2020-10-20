@if (isset($teacher))    
<img src="{{ $teacher->photo }}" border="0" width="90" class="img-rounded" align="center" />
@elseif (isset($student))
<img src="{{ $student->photo }}" border="0" width="90" class="img-rounded" align="center" />
@endif