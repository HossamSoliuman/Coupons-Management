<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Usage Details PDF</title>
    <style>
        /* Define your styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h1>{{ $shop->name }}</h1>
    <h2>Codes Usage Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Code Name</th>
                <th>Unit Cost</th>
                <th>Used Times</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($codesUsage as $codeUsage)
                <tr>
                    <td>{{ $codeUsage['code_name'] }}</td>
                    <td>{{ $codeUsage['unit_cost'] }}</td>
                    <td>{{ $codeUsage['used_times'] }}</td>
                    <td>{{ $codeUsage['total_cost'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align: center;">Total</td>
                <td>
                    @php
                        $totalUsedTimes = array_sum(array_column($codesUsage, 'used_times'));
                        echo $totalUsedTimes;
                    @endphp
                </td>

                <td>
                    @php
                        $totalCost = array_sum(array_column($codesUsage, 'total_cost'));
                        echo $totalCost;
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Offer Usage Details</h2>
    <table>
        <thead>
            <tr>
                <th>Phone</th>
                <th>Code Name</th>
                <th>Offer Name</th>
                <th>Amount</th>
                <th>Max Usage Times</th>
                <th>Used Times</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offersUsagesDetails as $offerDetails)
                <tr>
                    <td>{{ $offerDetails->phone_number }}</td>
                    <td>{{ $offerDetails->offer->code->name }}</td>
                    <td>{{ $offerDetails->offer->name }}</td>
                    <td>{{ $offerDetails->offer->amount }}</td>
                    <td>{{ $offerDetails->offer->max_usage_times }}</td>
                    <td>{{ $offerDetails->offer->used_times }}</td>
                    <td>{{ $offerDetails->created_at->format('Y M d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
