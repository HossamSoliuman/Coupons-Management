<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Usage Details PDF</title>
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
    <h1>{{ $code->name }}</h1>
    <p> Total used times: {{ $code->used_times }} </p>
    <p> Cost per code : {{ $code->unit_cost }} </p>
    <p> Total cost: {{ $code->used_times * $code->unit_cost }} </p>
    <table>
        <thead>
            <tr>
                <th>Shop Name</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Max Usage Times</th>
                <th>Used Times</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offersUsagesDetails as $offerDetails)
                <tr>
                    <td>{{ $offerDetails->offer->shop->name }}</td>
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
