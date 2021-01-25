<div class="media">
    @if (Storage::disk('students')->has($student->image))
        <a class="pull-left" href="{{url("/profile/".$student->id)}}">
            <div class="col-md-6">
                <img class="media-object" alt=""
                     src="{{url("/student/".$student->image."/view")}}" width="120" height="120">
            </div>
        </a>
    @else
        <a class="pull-left" href="{{url("/profile/".$student->id)}}">
            <div class="col-md-6">
            <img class="media-object" alt="{{$student->first_name}}" src="{{url("/student/mm.jpg/view")}}"
                 width="120" height="120">
                </div>
        </a>
    @endif
    <div class="media-body">
        <h4 class="media-heading"><a href="{{url("/profile/".$student->id)}}">{{$student->getName()}}</a></h4>
        <p>{{$student->student_id}}</p>
        <p>{{$student->getClass()}}</p>
    </div>
</div>
