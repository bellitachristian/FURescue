@extends("Admin.main")
@section("header")
View Documents
@endsection

@section("content")
<div class="card">
    <div class="card-body">
        @foreach($docs as $doc)
            <a href="{{route('viewownerdetails',$doc->petowner_id)}}"><button class="btn btn-secondary" type="button">Back</button></a>
            @if($doc->extension =="jpg" || $doc->extension =="jpeg" || $doc->extension =="png")
            <img src="{{asset('uploads/valid-documents/'.$doc->filename)}}" width="100%" height="600px" />
            @elseif($doc->extension == "pdf")
            <embed src="{{asset('uploads/valid-documents/'.$doc->filename)}}" type="application/pdf" width="100%" height="500px" />
            @elseif ($doc->extension == "docx")
            <iframe style="width: 900px; height: 900px;" src="http://docs.google.com/gview?url={{asset('uploads/valid-documents/'.$doc->filename)}}" height="240" width="320" frameborder="0"></iframe>
            @endif
        @endforeach
    </div>
</div>
@endsection


