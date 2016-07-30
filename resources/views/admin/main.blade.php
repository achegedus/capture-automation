<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill CAPture Admin</title>
    
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/css/theme.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/css/chosen.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"         crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/js/jquery.tablesorter.widgets.js"></script>

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
            
            $("#clientList").change(function() {
                var id=$(this).val();
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
                        
                        // makes the summary tab active again when a different client is selected from the dropdown
                        $('#summary').addClass('active');
                        $('#history').removeClass('active');
                        $('#settings').removeClass('active');
                    }
                });
            });
            
            // hides the submenu until a client is selected in the dropdown
            $('#subMenu').hide();
            $('#summary').addClass('active');
        });
    </script>
    
    <script type="text/javascript">
        function onClick(value) {
            var image = "/images/loading.gif";
            var id = document.getElementById("clientList").value;
            $('#loader').html("<img class=\"loading-image\" src='"+image+"' />").show();
            $.ajax({
                url: "http://ecbc-laravel.dev/admin/"+value+"/"+id,
                type: "GET",
                success: function (html) {
                    // success callback -- replace the div's innerHTML with
                    // the response from the server.
                    $('#loader').hide();
                    $('#stats').html(html);
                    $('#subMenu').show();
                    
                    // handles which tab is active in the submenu
                    if (value == "summary") {
                        $('#summary').addClass('active');
                        $('#history').removeClass('active');
                        $('#settings').removeClass('active');
                    }
                    else if (value == "history") {
                        $('#history').addClass('active');
                        $('#summary').removeClass('active');
                        $('#settings').removeClass('active');                        
                    }
                    else if (value == "settings") {
                        $('#settings').addClass('active');
                        $('#history').removeClass('active');
                        $('#summary').removeClass('active');                        
                    }
                }
            });            
        } 
    </script>    
        
    <script type="text/javascript">
        $(function() {
            $("#clientList").chosen();
        });
    </script>
    
    
    <div class="container">
        <div id="select_div" class="row">
            <h3 class="title">Bill CAPture Admin</h3>
            <select id="clientList" style="width:500px">
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
                <li onclick="onClick('summary')" id="summary"><a data-toggle="tab" href="javascript:void(0);">Summary</a></li>
                <li onclick="onClick('history')" id="history"><a data-toggle="tab" href="javascript:void(0);">Upload History</a></li>
                <li onclick="onClick('settings')" id="settings"><a data-toggle="tab" href="javascript:void(0);">Edit Settings</a></li>
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
