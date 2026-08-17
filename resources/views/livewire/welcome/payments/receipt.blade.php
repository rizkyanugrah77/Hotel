<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Booking Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin-bottom: 5px;
        }

        .header p {
            color: #777;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px 0;
            vertical-align: top;
        }

        .label {
            width: 35%;
            color: #777;
        }

        .value {
            font-weight: bold;
        }

        .total {
            border-top: 2px solid #333;
            margin-top: 20px;
            padding-top: 15px;
        }

        .paid {
            color: #16a34a;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="flex flex-row items-center justify-center gap-2">
            {{-- <div class="qr" style="text-align: center;">
                <img src="{{ QrCode::size(50)->generate($payment->booking->booking_code) }}" alt="QR Code">
            </div> --}}
            <x-application-logo class="flex h-10 w-auto" />

            <div class="flex flex-col">
                <span class="font-bold text-xl">Sitio Tio Resort</span>
                <span class="text-sm text-gray-500">Booking Receipt</span>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="section-title">
            Informasi Pemesanan
        </div>

        <table class="flex flex-col w-full">

            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="value">
                    {{ ucfirst($payment->payment_method) }}
                </td>
            </tr>
            <tr class="flex w-full items-center justify-between">
                <td class="label w-1/2 text-left">Kode Pemesanan</td>
                <td class="value w-1/2 text-right">
                    {{ $payment->booking->booking_code ?? $payment->booking->id }}
                </td>
            </tr>


            <tr>
                <td class="label">Order ID</td>
                <td class="value">
                    {{ $payment->order_id }}
                </td>
            </tr>
            <tr>
                <td class="label">Status Pembayaran</td>
                <td class="paid">
                    {{ $payment->transaction_status }}
                </td>
            </tr>



        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Informasi Menginap
        </div>

        <table>
            <tr>
                <td class="label">Tipe Kamar</td>
                <td class="value">
                    {{ $payment->booking->room->name }}
                </td>
            </tr>

            <tr>
                <td class="label">Check-in</td>
                <td class="value">
                    {{ $payment->booking->check_in->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Check-out</td>
                <td class="value">
                    {{ $payment->booking->check_out->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Total Guests</td>
                <td class="value">
                    {{ $payment->booking->total_guests }} Guests
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Guest Information
        </div>

        <table>
            <tr>
                <td class="label">Name</td>
                <td class="value">
                    {{ $payment->booking->user->name }}
                </td>
            </tr>

            <tr>
                <td class="label">Email</td>
                <td class="value">
                    {{ $payment->booking->user->email }}
                </td>
            </tr>

            <tr>
                <td class="label">Phone</td>
                <td class="value">
                    {{ $payment->booking->user->phone }}
                </td>
            </tr>
        </table>
    </div>

    <div class="total">
        <table>
            <tr>
                <td>
                    <strong>Total Payment</strong>
                </td>

                <td style="text-align: right;">
                    <strong>
                        Rp {{ number_format($payment->booking->total_price, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for choosing Sitio Tio Resort.</p>
        <p>This receipt was generated electronically.</p>
    </div>

</body>

</html>
