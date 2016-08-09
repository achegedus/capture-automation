@extends('layouts.main')

@section('content')

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
                    @if ($transactions)
                        <td>{{ $transactions->proposedVolume_livebills }}</td>
                        <td>{{ $transactions->proposedVolume_histbills }}</td>
                        <td>{{ $transactions->proposedVolume_accts }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Actual</td>
                    @if ($transactions)
                        <td>{{ $transactions->actual_livebills }}</td>
                        <td>{{ $transactions->actual_histbills }}</td>
                        <td>{{ $transactions->actual_newAccounts }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Remaining</td>
                    @if ($transactions)
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
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Used</td>
                    @if ($transactions)
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
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
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
                @if ($transactions)
                    @if ($transactions->days_ecmaRenewal < 0)
                        <tr>
                            <td class="redtext">{{ $client->ECMA_renew->toDateString() }}</td>
                            <td class="redtext">{{ $transactions->days_ecmaRenewal }}</td>
                            <td class="redtext">{{ $ecmapercent }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $client->ECMA_renew->toDateString() }}</td>
                            <td>{{ $transactions->days_ecmaRenewal }}</td>
                            <td>{{ $ecmapercent }}</td>
                        </tr> class=redtext
                    @endif
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
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

@endsection
