<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            {!! Html::style('css/app.css') !!}
    </head>
    <body>
        @yield('content')
        {!! Html::script('js/all.js') !!}
        <script type="text/javascript">
        var files;
        $("#file_upload input[type=file]").on('change', prepareUpload);
        function prepareUpload(event) {
            files = event.target.files
        }

        $('#file_upload').on('submit', uploadFiles);
            // Catch the form submit and upload the files
            function uploadFiles(event) {
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening
                var data = new FormData();
                 data.append("_token", $("input[name=_token").val())
                $.each(files, function(key, value){
                    console.log("key: "+key+"/value"+value)
                    data.append("file", value);
                });

                //data = data.join('&')
                console.log(data)

                $.ajax({
                    url: '/fileParse',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR) {
                        //console.log(data)
                        /*if(typeof data.error === 'undefined') {
                            // Success so call function to process the form
                            submitForm(event, data);
                        }
                        else {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                        }*/
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
            }
        $(document).foundation();
        var elem = new Foundation.Accordion($(".accordion"));
        </script>
    </body>
</html>