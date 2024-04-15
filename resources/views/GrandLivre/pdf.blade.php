<!-- pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>PDF Export</title>
    <style>
        /* Custom CSS styles for the PDF */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>General accounts</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debited Account</th>
                <th>Credited Account</th>
                <th>Amount</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $runningBalance = 0;
                $totalAmount = 0;
            @endphp
            @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->description }}</td>
                    <td>{{ $entry->compte_debit }}</td>
                    <td>{{ $entry->compte_credit }}</td>
                    <td>{{ $entry->montant }}</td>
                    <td>{{ $runningBalance += $entry->montant }}</td>
                </tr>
                @php
                    $totalAmount += $entry->montant;
                @endphp
            @endforeach
        </tbody>
    </table>

    <!-- Total amount -->
    <p class="total">Total Amount: {{ $totalAmount }}</p>
</body>
</html>
