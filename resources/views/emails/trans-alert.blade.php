@extends('layouts.client-email')


@section('top_content')
    <h6>Thank you for using EnergyCAP Bill CAPture!</h6>
    <p style="margin-top:10px;"><?php echo $clientName; ?>,</p>
    <?php
    if ($type == 'Live Transactions' && $subType == 'Pace') {
        $msg = "Our records indicate that you are on pace to exceed your contracted number of <b>$type</b> by the end of the current processing year. If this trend continues and an overage occurs, a charge will be assessed at the rate specified in your Bill CAPture contract. <p>As of today, you are <b>$daysUsedPercentage%</b> into the current processing period and have used <b>$transUsedPercentage%</b> of your contracted number of <b>$type</b>.<p>To review processing statistics, please log into your <a href = \"http://billcapture.energycap.com/login\">Bill CAPture upload account</a> and click on the “Stats” tab. If you have any questions or would like to turn off this alert, please <a href=\"http://support.energycap.com/index.php?/Tickets/Submit\">contact us</a>.</p>";
    }
    else {
        $msg = "Our records indicate that you have exceeded your contracted number of <b>$type</b>. <b>(Contracted = $totalContracted | Actual = $actualUsage)</b>  At the end of the current processing year ($renewal), a charge will be assessed for this overage at the rate specified in your Bill CAPture contract. <p>To review processing statistics, please log into your <a href = \"http://billcapture.energycap.com/login\">Bill CAPture upload account</a> and click on the “Stats” tab. If you have any questions or would like to turn off this alert, please <a href=\"http://support.energycap.com/index.php?/Tickets/Submit\">contact us</a>.</p>";
    }
    ?>

    <p style="margin-top:10px;"><?php echo $msg; ?></p>
@endsection


