@extends('layouts.admin')


<!DOCTYPE html>
<html>
<head>
    <meta charset=="utf-8">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>  <!-- js for the add files area /-->
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
    <!-- <script>
    var Dropzone = require("enyo-dropzone");
    Dropzone.autoDiscover = false;
  </script> -->

    <style>
        html, body {
        height: 100%;
        }
        #actions {
        margin: 2em 0;
        }


        /* Mimic table appearance */
        div.table {
        display: table;
        }
        div.table .file-row {
        display: table-row;
        }
        div.table .file-row > div {
        display: table-cell;
        vertical-align: top;
        border-top: 1px solid #ddd;
        padding: 8px;
        }
        div.table .file-row:nth-child(odd) {
        background: #f9f9f9;
        }



        /* The total progress gets shown by event listeners */
        #total-progress {
        opacity: 0;
        transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
        opacity: 0;
        transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
        display: none;
        }
        #previews .file-row .start {
        display: none;
        }
        /*#previews .file-row .cancel {
        display: none;
        }*/
        #previews .file-row .progress {
        display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start {
          display: none;
        }
        #previews .file-row.dz-success .cancel {
        display: none;
        }
        #previews .file-row.dz-success .delete {
        display: none;
        }


    </style>

</head>
<body>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="container" id="container">


    <div id="actions" class="row">

        <div class="col-lg-8">
          <h2> EnergyCAP Bill CAPture </h2>
            <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add Zip files...</span>
        </span>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
            </button>
        </div>

        <div class="col-lg-5">
            <!-- The global file processing state -->
        <span class="fileupload-process">
          <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          </div>
        </span>
        </div>

    </div>








    <div class="table table-striped files" id="previews">

        <div id="template" class="file-row">


            <!-- This is used as the file preview template -->
            <div>
                <span class="preview"><img data-dz-thumbnail /></span>
            </div>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
                <button data-dz-remove class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
                <button data-dz-remove class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
            </div>
        </div>

    </div>

    <script>
                // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
          url: "/process_upload", // Set the url
          thumbnailWidth: 80,
          thumbnailHeight: 80,
          parallelUploads: 20,
          maxFilesize: 2048, // MB
          acceptedFiles: ".zip",
          previewTemplate: previewTemplate,
          autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: "#previews", // Define the container to display the previews
          clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        });

        myDropzone.on("addedfile", function(file) {
        //  Hookup the start button
          check_duplicate(file);
          //alert(file.name);
          file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
          document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file) {
          // Show the total progress bar when upload starts
          document.querySelector("#total-progress").style.opacity = "1";
          // And disable the start button
          file.previewElement.querySelector(".start").setAttribute("disabled", "enabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
          document.querySelector("#total-progress").style.opacity = "0";
          location.reload();
        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
          myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
          myDropzone.removeAllFiles(true);
        };

            // $.getJSON('/list_upload', function(data) {
            //   $.each(data, function(key,value){
            //     var mockFile = { name: value.name, size: value.size, date: value.date };
            //     myDropzone.options.addedfile.call(myDropzone, mockFile);
            //
            //
            //
            //     });
            //
            //   });

            function check_duplicate(file){

              $.ajax({
                //The URL to process the request


                'url' : '/check_duplicates/'+file.name,
                //The type of request, also known as the "method" in HTML forms
                //Can be 'GET' or 'POST'
                  'type' : 'GET',
                //Any post-data/get-data parameters
                //This is optional
                  'data' : {


                  },
                //The response from the server
                  'success' : function(data) {
                  //You can use any jQuery/JavaScript here!!!
                    if (data != "false") {
                      alert(file.name + " " + data);
                      //return removeFile(file);
                      var _ref;
                      return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                    }
                  }
                });

           }



    </script>  <!-- js for the add files area /-->



</div>
<div class=container id=container>
    <div class="col-lg-12">
    <h2>Bill Upload History</h2>
    <table class="table table-striped">
      <tr>

          <th>Filename</th>
          <th>Upload Date</th>
          <th>Batch Code</th>
          <th>Last Activity</th>
          <th>Status</th>
      </tr>

          @foreach ($data as $item)
          <tr>
              <td>{{ $item->fileName }}</td>
              <td>{{ $item->uploadTimestamp }}</td>
              <td>{{ $item->partnerFile->batchCode }}</td>
              <td>{{ $item->partnerFile->processDate }}</td>
              <td>@if ($item->isFileProcessed == 1 && $item->partnerFile->closed == 1)
                      Processed
                  @elseif ($item->partnerFile->kickedOut == 1 && $item->partnerFile->closed == 0)
                      Kicked Out
                  @elseif ($item->partnerFile->processed == 1 && $item->partnerFile->closed == 0)
                      Partial
                  @else
                      In Queue
                  @endif
              </td>

          </tr>
          @endforeach


    </table>
  </div>
</div>





</body>
</html>
