<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill CAPture Admin</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="/js/chosen.jquery.min.js"></script>
    
    <link type="text/css" rel="stylesheet" href="/css/chosen.min.css">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"         crossorigin="anonymous">

</head>
<body class="container">
    
    <style>
        #select_div {
            float: left;
            width: auto;
            padding-top: 50px;
            padding-bottom: 50px;
        }
    
        h3 {
            color: black;
        }
        
        #loader {
            padding-left: 115px;
        }
        
    </style>    
    
    <script>
        $(document).ready(function() {
    
            $(".clientList").change(function() {
                var id=$(this).val();
//                var dataString = 'id='+ id;
//                alert(id); return false;
                var image = "/images/loading.gif";
                $('#loader').html("<img class=\"loading-image\" src='"+image+"' />").show();
                $.ajax({
                    url: "http://ecbc-laravel.dev/admin/summary/"+id,
                    type: "GET",
                    success: function (html) {
                        // success callback -- replace the div's innerHTML with
                        // the response from the server.
                        $('#loader').hide();
                        $('#stats').html(html);
                        $('#subMenu').show();
                    }
                });
            });
            
            // hides the submenu until a client is selected in the dropdown
            $('#subMenu').hide();
        });
    </script>
    
    <script type="text/javascript">
        function onClick(value) {
            var image = "/images/loading.gif";
            $('#loader').html("<img class=\"loading-image\" src='"+image+"' />").show();
        } 
    </script>    
        
    <script type="text/javascript">
        $(function() {
            $(".clientList").chosen();
        });
    </script>
    
    
    <div class="container">
        <div id="select_div" class="row">
            <h3 class="title">Bill CAPture Admin</h3>
            <select class="clientList" style="width:500px">
                <option value="">Select a client to view stats</option>
                @foreach ($clientList as $client)
                    <option value="{{ $client->clientID }}">{{ $client->clientName }}</option>
                @endforeach    
            </select>
        </div>
    </div>    

    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" id="loader">
<!--                This is where the loader image will be displayed-->
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>    
    
    <div class="container row">
        <div id="subMenu">
            <ul class="nav nav-tabs">
                <li class="active" onclick="onClick('summary')" id="summary"><a href="javascript:void(0);">Summary</a></li>
                <li onclick="onClick('history')" id="history"><a href="javascript:void(0);">Upload History</a></li>
                <li onclick="onClick('settings')" id="settings"><a href="javascript:void(0);">Edit Settings</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div id="stats" style="width:100%">
<!--            This div is where ajax loads the response -->
        </div>
    </div>   
    
    
    
</body>
</html>
