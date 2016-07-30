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
                @if ($transactions[0]->remaining_livebills < 0)
                    <td class="overage">{{ $transactions[0]->remaining_livebills }}</td>
                @else
                    <td>{{ $transactions[0]->remaining_livebills }}</td>
                @endif
                @if ($transactions[0]->remaining_histbills < 0)
                    <td class="overage">{{ $transactions[0]->remaining_histbills }}</td>
                @else
                    <td>{{ $transactions[0]->remaining_histbills }}</td>
                @endif
                @if ($transactions[0]->remaining_newAccounts < 0)
                    <td class="overage">{{ $transactions[0]->remaining_newAccounts }}</td>
                @else
                    <td>{{ $transactions[0]->remaining_newAccounts }}</td>
                @endif
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
        <h2>Renewal Detail</h2>
        <table class="table table-striped">
            <tr>
                <th> Renewal Date</th>
                <th> Days until Renewal</th>
                <th> % into Period</th>
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

<h2>Monthly Detail</h2>
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
</table>