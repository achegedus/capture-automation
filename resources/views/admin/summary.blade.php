<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill Capture Client Summary</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body class="container">

    <div class="row">
        <div class='col-xs-6'>
            <h1>Processing Summary</h1>
            <table class="table">
                <tr>
                    <th></th>
                    <th>Live Transactions</th>
                    <th>Historical Transactions</th>
                    <th>Meters</th>
                </tr>
                <tr>
                    <td>Contracted</td>
                    <td>{{ $transactions[0]->proposedVolume_livebills }}</td>
                    <td>{{ $transactions[0]->proposedVolume_histbills }}</td>
                    <td>{{ $transactions[0]->proposedVolume_accts }}</td>
                </tr>
                <tr>
                    <td>Actual</td>
                    <td>{{ $transactions[0]->actual_livebills }}</td>
                    <td>{{ $transactions[0]->actual_histbills }}</td>
                    <td>{{ $transactions[0]->actual_newAccounts }}</td>
                </tr>
                <tr>
                    <td>Remaining</td>
                    <td>{{ $transactions[0]->remaining_livebills }}</td>
                    <td>{{ $transactions[0]->remaining_histbills }}</td>
                    <td>{{ $transactions[0]->remaining_newAccounts }}</td>
                </tr>
                <tr>
                    <td>Used</td>
                    <td>{{ $transactions[0]->percentage_livebills * 100 }}%</td>
                    <td>{{ $transactions[0]->percentage_histbills * 100 }}%</td>
                    <td>{{ $transactions[0]->percentage_newAccounts * 100 }}%</td>
                </tr>
            </table>

        </div>

        <div class="col-xs-6">
            <h1>Renewal Detail</h1>
            <table class="table">
              <tr>
                <th> Renewal Date </th>
                <th> Days until Renewal </th>
                <th> % into Period </th>


              </tr>
              <tr>

                <td> {{ $client->ECMA_renew->toDateString() }}</td>
                <td>
                     {{ $transactions[0]->days_ecmaRenewal }}
                </td>
                <td>
                     {{ $ecmapercent }}
                </td>

              </tr>

            </table>
        </div>
    </div>

    <h1>Monthly Detail</h1>
    <table class="table">
      <tr>
        <th>
          Year
        </th>
        <th>
          Month
        </th>
        <th>
          Transaction Type
        </th>
        <th>
          Count
        </th>
        <th>
          Unit Cost
        </th>
        <th>
          Subtotal
        </th>


          @foreach ($monthly as $item)
          <tr>
          <td>

            {{ $item->year }}


          </td>
          <td>
            {{ $item->month }}
          </td>
          <td>
            {{ $item->transactionType }}
          </td>
          <td>
            {{ $item->total }}
          </td>
          <td>
            {{ $item->unitCost }}
          </td>
          <td>
            {{ $item->subtotal }}
          </td>
          </tr>

          @endforeach
        </tr>


      </tr>
    </table>

    <h1>Batch Detail</h1>
    <table class="table">
      <tr>
        <th>
          Filename
        </th>
        <th>
          Batch Code
        </th>
        <th>
          Uploaded
        </th>
        <th>
          Processed
        </th>
        <th>
          Transaction Type
        </th>
        <th>
          Count
        </th>

        @foreach ($batch as $item)
        <tr>
          <td>
            {{ $item->fileName }}
          </td>
          <td>
            {{ $item->batchCode }}
          </td>
          <td>
            {{ $item->uploadTimestamp }}
          </td>
          <td>
            {{ $item->processDate }}
          </td>
          <td>
            {{ $item->transactionType }}
          </td>
          <td>
            {{ $item->total }}
          </td>
        </tr>
        @endforeach

      </tr>


    </table>


</body>
</html>
