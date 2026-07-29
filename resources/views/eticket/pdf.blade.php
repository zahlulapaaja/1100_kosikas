<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>eTicket - {{ $data['pnr'] }}</title>
    <style>
        @page { margin: 30px 35px; }
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 11px;
            color: #222;
        }
        .header {
            border-bottom: 3px solid #0d3b66;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .agency-name {
            font-size: 20px;
            font-weight: bold;
            color: #0d3b66;
            margin: 0;
        }
        .agency-tagline {
            font-size: 11px;
            color: #555;
            margin: 0 0 4px 0;
        }
        .doc-title {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        .disclaimer {
            background-color: #f2f5f9;
            border: 1px solid #d7e0ea;
            padding: 8px 10px;
            font-size: 9.5px;
            color: #333;
            margin-bottom: 14px;
        }
        .section-title {
            background-color: #0d3b66;
            color: #fff;
            padding: 5px 8px;
            font-size: 11.5px;
            font-weight: bold;
            margin-bottom: 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cdd6e0;
            padding: 5px 6px;
            font-size: 10px;
            text-align: left;
        }
        table.data-table th {
            background-color: #eaf0f7;
            font-weight: bold;
        }
        .info-row td {
            padding: 3px 0;
            font-size: 10.5px;
        }
        .info-label {
            color: #666;
            width: 140px;
        }
        .fare-box {
            border: 1px solid #cdd6e0;
            padding: 10px;
        }
        .fare-total {
            font-size: 14px;
            font-weight: bold;
            color: #0d3b66;
        }
        .fare-note {
            font-size: 9px;
            color: #777;
        }
        .footer-note {
            margin-top: 20px;
            font-size: 9px;
            color: #888;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <table style="width:100%; border:none; margin-bottom:6px;">
        <tr>
            <td style="border:none; width:60%;">
                <p class="agency-name">{{ strtoupper($data['agency_name']) }}</p>
                <p class="agency-tagline">{{ $data['agency_tagline'] }}</p>
            </td>
            <td style="border:none; width:40%; vertical-align:top;">
                <p class="doc-title">eTicket Itinerary / Receipt</p>
            </td>
        </tr>
    </table>

    <div class="disclaimer">
        This is an eTicket itinerary. To enter the airport and for check-in, you must present this itinerary receipt
        along with Official Government issued photo identification such as passport, identity card or Indonesian KTP.
    </div>

    <table style="width:100%; border:none; margin-bottom: 12px;">
        <tr class="info-row">
            <td style="border:none; width:50%;">
                <span class="info-label">Booking Reference (PNR)</span> :
                <strong>{{ strtoupper($data['pnr']) }}</strong>
            </td>
            <td style="border:none; width:50%;">
                <span class="info-label">Tanggal Diterbitkan</span> :
                <strong>{{ \Carbon\Carbon::parse($data['issued_date'])->translatedFormat('d M Y') }}</strong>
            </td>
        </tr>
    </table>

    <p class="section-title">Flight Details</p>
    <table class="data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Flight</th>
                <th>Departure Date</th>
                <th>Depart - Arrive</th>
                <th>Sub-Class</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['flights'] as $i => $flight)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $flight['flight_no'] }}<br><small>{{ $flight['airline'] }}</small></td>
                    <td>{{ \Carbon\Carbon::parse($flight['departure_date'])->translatedFormat('d M Y') }}</td>
                    <td>
                        {{ $flight['origin_city'] }} ({{ strtoupper($flight['origin_code']) }}) {{ $flight['dep_time'] }} &rarr;
                        {{ $flight['destination_city'] }} ({{ strtoupper($flight['destination_code']) }}) {{ $flight['arr_time'] }}
                    </td>
                    <td>{{ $flight['subclass'] ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="section-title">Passenger Details</p>
    <table class="data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Penumpang</th>
                <th>Tipe</th>
                <th>No. Identitas</th>
                <th>No. Tiket</th>
                <th>Bagasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['passengers'] as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p['title'] }} {{ $p['name'] }}</td>
                    <td>{{ $p['type'] }}</td>
                    <td>{{ $p['id_number'] }}</td>
                    <td>{{ $p['ticket_number'] }}</td>
                    <td>{{ $p['baggage'] ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="section-title">Fare Details</p>
    <div class="fare-box">
        <p class="fare-note">{{ $data['fare_note'] ?: 'Includes Base Fare, Taxes, Fees and Surcharges' }}</p>
        <p class="fare-total">Total Fare {{ strtoupper($data['currency']) }}
            {{ number_format($data['total_fare'], 0, ',', '.') }}
        </p>
    </div>

    <div class="footer-note">
        E-Ticket ini dibuat secara elektronik dan sah tanpa tanda tangan basah. Simpan dokumen ini untuk keperluan check-in.
    </div>

</body>
</html>
