<script>
    $(document).ready(function () {

        $.tablesorter.themes.bootstrap = {
            // these classes are added to the table. To see other table classes available,
            // look here: http://getbootstrap.com/css/#tables
            table: 'table table-striped',
            caption: 'caption',
            // header class names
            header: '', // give the header a gradient background (theme.bootstrap_2.css)
            sortNone: '',
            sortAsc: '',
            sortDesc: '',
            active: '', // applied when column is sorted
            hover: '', // custom css required - a defined bootstrap style may not override other classes
            // icon class names
            icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
            iconSortNone: 'bootstrap-icon-unsorted', // class name added to icon when column is not sorted
            iconSortAsc: 'glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
            iconSortDesc: 'glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
            filterRow: '', // filter row class; use widgetOptions.filter_cssFilter for the input/select element
            footerRow: '',
            footerCells: '',
            even: '', // even row zebra striping
            odd: ''  // odd row zebra striping
        };

        // call the tablesorter plugin and apply the uitheme widget
        $("#uploadHist").tablesorter({
            theme: "bootstrap",
            widthFixed: true,
            headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
            widgets: ["uitheme", "zebra"],
            widgetOptions: {
                zebra: ["even", "odd"],
                filter_reset: ".reset",
                filter_cssFilter: "form-control",

            }
        })
    });
</script>

<h2>Bill Upload History</h2>
<table id="uploadHist">
    <thead class="thead-inverse">
        <tr>
            <th>Filename</th>
            <th>Upload Date</th>
            <th>Batch Code</th>
            <th>Last Activity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($history as $i)
        <tr>
            <td>{{ $i->fileName }}</td>
            <td>{{ $i->uploadTimestamp }}</td>

            @if ($i->partnerFile)
                <td>{{ $i->partnerFile->batchCode }}</td>
                <td>{{ $i->partnerFile->processDate }}</td>
                <td>@if ($i->isFileProcessed == 1 && $i->partnerFile->closed == 1)
                        Processed
                    @elseif ($i->partnerFile->kickedOut == 1 && $i->partnerFile->closed == 0)
                        Kicked Out
                    @elseif ($i->partnerFile->processed == 1 && $i->partnerFile->closed == 0)
                        Partial
                    @else
                        In Queue
                    @endif
                </td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
