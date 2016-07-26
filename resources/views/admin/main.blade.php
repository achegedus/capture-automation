<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill CAPture Admin</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="http://ecbc-laravel.dev/js/chosen.jquery.min.js"></script>
    
    <link rel="stylesheet" href="http://ecbc-laravel.dev/css/chosen.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"         crossorigin="anonymous">

</head>
    
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
    
</style>    
    

    
    <script type="text/javascript">
        $(function() {
            $(".chzn-select").chosen();
        });
    </script>
    
    
<div class="container">
    <div id="select_div" class="row">
        <h3 class="title">Bill CAPture Admin</h3>
        <select class="chzn-select" style="width:500px">
            @foreach ($clientList as $client)
                <option value="{{ $client->clientID }}">{{ $client->clientName }}</option>
            @endforeach    
        </select>
    </div>
</div>    
    
    
    
    
    

</html>
