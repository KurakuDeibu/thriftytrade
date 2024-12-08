<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Transaction Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #f4f4f4;
            padding: 10px;
            font-weight: bold;
        }

        .section-content {
            padding: 10px;
        }

        .user-info {
            display: flex;
            margin-bottom: 20px;
        }

        .user-info>div {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
    </style>

</head>

<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td width="100%" align="center">
                    <h1>Transaction Details Report</h1>
                    <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Product Information</div>
        <div class="section-content">
            <strong>Product Name:</strong> {{ $selectedOffer->product->prodName }}<br>
            <strong>Category:</strong> {{ $selectedOffer->product->category->categName ?? 'No Category' }}<br>
            <strong>Original Price:</strong> &#8369;{{ number_format($selectedOffer->product->prodPrice, 2) }}
        </div>
    </div>

    <div class="user-info">
        <div>
            <strong>Seller Information</strong><br>
            Name: {{ $selectedOffer->product->author->name }}<br>
            Email: {{ $selectedOffer->product->author->email }}
        </div>
        <div>
            <strong>Buyer Information</strong><br>
            Name: {{ $selectedOffer->user->name }}<br>
            Email: {{ $selectedOffer->user->email }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Transaction Details</div>
        <div class="section-content">
            <strong>Status:</strong>
            <span class="status-badge">{{ ucfirst($selectedOffer->status) }}</span><br>
            <strong>Accepted Offer Price:</strong> &#8369;{{ number_format($selectedOffer->offer_price, 2) }}<br>
            <strong>Meetup Location:</strong> {{ $selectedOffer->meetup_location ?? 'Not specified' }}<br>
            <strong>Meetup Time:</strong>
            {{ \Carbon\Carbon::parse($selectedOffer->meetup_time)->format('M d, Y h:i A') }}<br>
            <strong>Date Completed:</strong>
            @if ($selectedOffer->status == 'completed')
                {{ \Carbon\Carbon::parse($selectedOffer->updated_at)->format('M d, Y h:i A') }}
            @else
                Not applicable
            @endif
        </div>
    </div>
</body>

</html>
