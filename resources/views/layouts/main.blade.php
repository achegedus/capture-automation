<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EnergyCAP Bill CAPture</title>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/css/theme.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/css/chosen.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"         crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.6/js/jquery.tablesorter.widgets.js"></script>

    <style type="text/css" media="screen">
        body {
            padding-top: 140px;
            padding-bottom: 40px;
        }

        .bodyText p {
            font-size: 16px;
            line-height: 1.5;
        }

        .bodyText ul {
            margin-left: 400px;
        }

        .bodyText ul li {
            font-size: 16px;
            line-height: 1.9;
        }

        .navbar1 {
            min-height: 80px;
        }

        .navbar2 {
            min-height: 30px;
            background-image: none;
            border: none;
            background-color: #C1CD21;
            top: 80px;
        }

        .navbar2 .navbar-text {
            margin-top: 5px;
            margin-bottom: 5px;
            color: white;
        }

        #subMenu {
            margin-top: 20px;
        }

        .jumbotronButton {
            background-color: #388BD5;
            border: none;
            background-image: none;
            color: white;
            text-shadow: none;
        }

        .bottomBar {
            margin-top: 100px;
            border-radius: 0;
        }

        .footerTextWhite {
            color: white;
        }

        .footerTextGreen {
            color: #C1CD21;
        }

        #clientList {
            width: 100%;
        }

        .spacer {
            margin-top: 40px; /* define margin as you see fit */
        }
    </style>

    @yield('script')
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top navbar1" role="navigation">
    <div class="container">
        <a target="_blank" class="navbar-brand" href="http://www.energycap.com">
            <img alt="Brand" src="http://cdn2.hubspot.net/hub/313940/file-318329326-png/logo_(1).png?t=1414524075044">
        </a>
    </div>
</nav>
<nav class="navbar navbar-inverse navbar-fixed-top navbar2" role="navigation">
    <div class="container">
        <div>
            <p class="navbar-text navbar-right"></p>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>


<nav class="navbar navbar-inverse navbar-fixed-bottom bottomBar" role="navigation">
    <div class="container">
        <div style="float: left">
            <p class="navbar-text navbar-right footerTextWhite">©2016 <span class="footerTextGreen">EnergyCAP, Inc.</span></p>
        </div>
        <div align="center" style="float: right; padding-top: 11px;" class="energycap-social">
            <table>
                <tbody>
                <tr>
                    <td><a href="https://www.facebook.com/EnergyCAP"><img src="http://info.energycap.com/hs-fs/hubfs/images/socialMedia/facebook24.png?t=1434479471493&amp;width=24" width="24" alt=""          style="margin: 0px 6px 0px 0px;"></a></td>
                    <td><a href="https://twitter.com/#!/energycap"><img src="http://info.energycap.com/hs-fs/hubfs/images/socialMedia/twitter24.png?t=1434479471493&amp;width=24" width="24" alt="" style="margin: 0px 6px 0px 0px;"></a></td>
                    <td><a href="http://www.slideshare.net/EnergyCAP"><img src="http://info.energycap.com/hs-fs/hubfs/images/socialMedia/slideshare24.png?t=1434479471493&amp;width=24" width="24" alt=""></a>      </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</nav>

</body>
</html>
