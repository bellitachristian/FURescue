<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                <form action="{{route('dropzone')}}" id="dropzoneform" class="dropzone" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="text" name="name" id ="input-id">
                </form>
                    <button type="submit" id="submit-all">Upload</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
</body>
</html>
<script>
    Dropzone.options.dropzoneform = {
    autoProcessQueue: false,
    addRemoveLinks: true,

    init: function () {
        
        var myDropzone = this;
        $("#submit-all").click(function (e) {
            e.preventDefault();
            myDropzone.processQueue();
        });
        this.on('sending', function(file, xhr, formData) 
          {
           formData.append("name", document.getElementById('input-id').value);
        });

    }
}

</script>
