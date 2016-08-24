@extends('layouts.client-email')


@section('top_content')
    <br>
    <h6>Thank you for using EnergyCAP Bill CAPture!</h6>
    <p style="margin-top:10px;">{{ $client->clientName }},</p>
    <p style="margin-top:10px;">This is an overdue kickout reminder. The original kickout date was on <b>{{ $partnerFile->processDate }}</b>. Please fix the following error(s).</p>
    <p style="margin-top:10px;margin-bottom:0px">Original File Name: <b>{{ $partnerFile->fileName }}</b></p>
    <p style="margin-top:10px;">Reserved Batch Name: <b>{{ $partnerFile->batchCode }}</b></p>
    <p style="margin-top:10px;"><a href="http://billcapture.energycap.com/docs/display/BC/Bill+CAPture+-+Resolving+Kickouts">How do I resolve these kickouts?</a></p>
@endsection


@section('table_content')
    <?php
    // loop through kickout records
    foreach ($kickouts as $kickout) {
        $kickoutText = str_getcsv($kickout->kickoutText, "\n"); //parse the rows
        foreach ($kickoutText as &$Row) $Row = str_getcsv($Row); //parse the items in rows

        $hash = "";

        // acceptable columns:
        $usableColumnsHeaders = array('accountcode', 'startdate', 'enddate', 'metercode', 'duedate', 'statementdate', 'vendorcode', 'ratecode', 'controlcode');
        $usableColumnNumbers = array();

        // find usable columns
        for ($x = 0; $x < count($kickoutText[0]); $x++) {
            if ($kickoutText[0][ $x ] == 'CONTROLCODE') {
                $controlCode = $x; //identifies the element number for Control Code
            }
            if (in_array(strtolower($kickoutText[0][ $x ]), $usableColumnsHeaders) || (strpos($kickoutText[0][ $x ], "*") !== false && $kickoutText[0][ $x ] != "*END_OF_RECORD_MARKER")) //if( in_array(strtolower($kickoutText[0][$x]), $usableColumnsHeaders))
            {
                $usableColumnNumbers[] = $x;
            }
        }

        echo "<p><b style='color:red'>Error:</b> " . $kickout->kickoutInfo . "</p>";

        // generate Table
        echo "<table border='1' style='margin-bottom: 20px'>";
        // loop through kickoutText
        for ($i = 0; $i < count($kickoutText); $i++) {
            echo "<tr>";
            for ($j = 0; $j < count($kickoutText[ $i ]); $j++) {
                if (in_array($j, $usableColumnNumbers)) {
                    if ($i > 0) {
                        if ($j == $controlCode) {
                            $fileName = $kickoutText[ $i ][ $j ];
                            echo "<td><a href='".$client->billImageURL()."/".$fileName.".pdf'><img src=\"http://ecbc.energycap.com/images/Image-icon.png\" height=\"25\" width=\"25\" ></a></td>";
                        } else {
                            echo "<td style='font-size:11px; padding: 2px'>" . $kickoutText[ $i ][ $j ] . "</td>";
                        }
                    } else {
                        if ($kickoutText[ $i ][ $j ] == 'CONTROLCODE') {
                            echo "<th style='font-size:10px; padding: 2px'>IMAGE</th>";
                        } else {
                            echo "<th style='font-size:10px; padding: 2px'>" . $kickoutText[ $i ][ $j ] . "</th>";
                        }
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        $hash = $kickout->hash;
        $baseURL = url();
    }
    ?>
@endsection


@section('bottom_content')
    <p>Once you make the necessary corrections in EnergyCAP, you can
    resubmit the data for bill entry by clicking the reprocess
    button below. This button can only be clicked on once, so be
    sure to make corrections prior to clicking it.</p>
@endsection


@section('button_content')
    <table class="button">
        <tr>
            <td>
                <a href="{{ url('/kickout/reprocess/' . $hash) }}" ?>Reprocess</a>
            </td>
        </tr>
    </table>
@endsection

