<!DOCTYPE html>
<html>
<head>
    <title>Contract Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .contract-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .contract-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .contract-id {
            font-size: 18px;
            color: #666;
        }
        .contract-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .contract-details th, .contract-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .signatures {
    margin-top: 50px;
    text-align: center;
}

.signature-box {
    width: 200px;
    height: 100px;
    border: 1px solid #ddd;
    display: inline-block;
}

.signature-box:first-child {
    margin-right: 20px;
}

.signature-box:last-child {
    margin-left: 20px;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="contract-header">
            <div class="contract-title">Contract Details</div>
            <div class="contract-id">Contract ID: {{ $contract->id }}</div>
        </div>
        <table class="contract-details">
            <tbody>
                <tr>
                    <th>Start Date</th>
                    <td>{{ $contract->start_date }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ $contract->end_date }}</td>
                </tr>
                <tr>
                    <th>Contract Terms</th>
                    <td>{{ $contract->contract_terms }}</td>
                </tr>
                <tr>
                    <th>Payment Terms</th>
                    <td>{{ $contract->payment_terms }}</td>
                </tr>
                <tr>
                    <th>Ordered Quantity</th>
                    <td>{{ $contract->ordered_quantity }}</td>
                </tr>
                <tr>
                    <th>Unit Price</th>
                    <td>{{ $contract->unit_price }}</td>
                </tr>
            </tbody>
        </table>
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-label">Supplier Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-label">Enterprise Signature</div>
            </div>
        </div>
    </div>
</body>
</html>

