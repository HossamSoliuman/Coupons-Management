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
