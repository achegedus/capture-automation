@extends('layouts.admin')


@section('script')
    <script>
        $(document).ready(function () {

            $("#clientList").change(function () {
                var id = $(this).val();
                var image = "/images/loading.gif";
                $('#loader').html("<img class=\"loading-image\" src='" + image + "' />").show();
                $.ajax({
                    url: "/admin/summary/" + id,
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


        function onClick(value) {
            var image = "/images/loading.gif";
            var id = document.getElementById("clientList").value;
            $('#loader').html("<img class=\"loading-image\" src='" + image + "' />").show();
            $.ajax({
                url: "/admin/" + value + "/" + id,
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


        $(function () {
            $("#clientList").chosen();
        });
    </script>

@endsection


@section('content')

    <div id="select_div">
        <h3 class="title">Bill CAPture Admin</h3>
        <div class="row">
            <div class="col-md-7">
                <select data-placeholder="Select a client to view stats..." id="clientList" class="chosen-select">
                    <option></option>
                    @foreach ($clientList as $client)
                        <option value="{{ $client->clientID }}">{{ $client->clientName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4" id="loader">
                <!-- This is where the loader image will be displayed -->
            </div>
        </div>
    </div>

    <div id="subMenu">
        <ul class="nav nav-tabs">
            <li onclick="onClick('summary')" id="summary"><a data-toggle="tab" href="javascript:void(0);">Summary</a></li>
            <li onclick="onClick('history')" id="history"><a data-toggle="tab" href="javascript:void(0);">Upload History</a></li>
            <li onclick="onClick('settings')" id="settings"><a data-toggle="tab" href="javascript:void(0);">Edit Settings</a></li>
        </ul>
    </div>

    <div id="stats">
        <!-- This div is where ajax loads the response -->
    </div>

@endsection