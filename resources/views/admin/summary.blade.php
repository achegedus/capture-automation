<div class="row">
    <div class='col-xs-6'>
        <h2>Processing Summary</h2>
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Live Transactions</th>
                <th>Historical Transactions</th>
                <th>Meters</th>
            </tr>
            @if ($transactions)
            <tr>
                <td>Contracted</td>
                <td>{{ $transactions->proposedVolume_livebills }}</td>
                <td>{{ $transactions->proposedVolume_histbills }}</td>
                <td>{{ $transactions->proposedVolume_accts }}</td>
            </tr>
            <tr>
                <td>Actual</td>
                <td>{{ $transactions->actual_livebills }}</td>
                <td>{{ $transactions->actual_histbills }}</td>
                <td>{{ $transactions->actual_newAccounts }}</td>
            </tr>
            <tr>
                <td>Remaining</td>
                @if ($transactions->remaining_livebills < 0)
                    <td class="redtext">{{ $transactions->remaining_livebills }}</td>
                @else
                    <td>{{ $transactions->remaining_livebills }}</td>
                @endif
                @if ($transactions->remaining_histbills < 0)
                    <td class="redtext">{{ $transactions->remaining_histbills }}</td>
                @else
                    <td>{{ $transactions->remaining_histbills }}</td>
                @endif
                @if ($transactions->remaining_newAccounts < 0)
                    <td class="redtext">{{ $transactions->remaining_newAccounts }}</td>
                @else
                    <td>{{ $transactions->remaining_newAccounts }}</td>
                @endif
            </tr>
            <tr>
                <td>Used</td>
                @if (($transactions->percentage_livebills * 100) > 100)
                    <td class="redtext">{{ $transactions->percentage_livebills * 100 }}%</td>
                @else
                    <td>{{ $transactions->percentage_livebills * 100 }}%</td>
                @endif
                @if (($transactions->percentage_histbills * 100) > 100)
                    <td class="redtext">{{ $transactions->percentage_histbills * 100 }}%</td>
                @else
                    <td>{{ $transactions->percentage_histbills * 100 }}%</td>
                @endif
                @if (($transactions->percentage_newAccounts * 100) > 100)
                    <td class="redtext">{{ $transactions->percentage_newAccounts * 100 }}%</td>
                @else
                    <td>{{ $transactions->percentage_newAccounts * 100 }}%</td>
                @endif
            </tr>
            @else
                <tr>
                    <td>Contracted</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Actual</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Remaining</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Used</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="col-xs-6">
        @if ($client->invoiceSchedule == 'ECMA')
        <h2>Renewal Detail</h2>
        <table class="table table-striped">
            <tr>
                <th> Renewal Date</th>
                <th> Days until Renewal</th>
                <th> % into Period</th>
            </tr>
            @if ($transactions)
                <tr>
                    @if ($transactions->days_ecmaRenewal < 0)
                        <td class="overage"> {{ $client->ECMA_renew->toDateString() }}</td>
                        <td class="overage"> {{ $transactions->days_ecmaRenewal }} </td>
                        <td class="overage"> {{ $ecmapercent }} </td>
                    @else
                        <td> {{ $client->ECMA_renew->toDateString() }} </td>
                        <td> {{ $transactions->days_ecmaRenewal }} </td>
                        <td> {{ $ecmapercent }} </td>
                    @endif
                </tr>
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </table>
        @endif
    </div>
</div>


<h2>Monthly Detail</h2>
<i class="icon-question-sign" data-toggle="tooltip" title="Each batch processed in the current renewal period"><span class="glyphicon glyphicon-question-sign"></i>

<table class="table table-striped">
    <tr>
        <th>Year</th>
        <th>Month</th>
        <th>Transaction Type</th>
        <th>Count</th>
        <th>Unit Cost</th>
        <th>Subtotal</th>
    </tr>

    @foreach ($monthly as $item)
        <tr>
            <td>{{ $item->year }}</td>
            <td>{{ $item->month }}</td>
            <td>{{ $item->transactionType }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->unitCost }}</td>
            <td>{{ $item->subtotal }}</td>
        </tr>
    @endforeach
</table>


<h2>Batch Detail</h2>
<table class="table table-striped">
    <tr>
        <th>Filename</th>
        <th>Batch Code</th>
        <th>Uploaded</th>
        <th>Processed</th>
        <th>Transaction Type</th>
        <th>Count</th>
    </tr>

    @foreach ($batch as $item)
        <tr>
            <td>{{ $item->fileName }}</td>
            <td>{{ $item->batchCode }}</td>
            <td>{{ $item->uploadTimestamp }}</td>
            <td>{{ $item->processDate }}</td>
            <td>{{ $item->transactionType }}</td>
            <td>{{ $item->total }}</td>
        </tr>
    @endforeach
</table>