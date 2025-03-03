<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} - Almarsa</title>
    <style>
        @page {
            size: A5;
            margin: 0;
        }

        @media print {
            body {
                width: 148mm;
                height: 210mm;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; font-family: system-ui, -apple-system, sans-serif; background-color: rgb(249, 250, 251); width: 148mm; height: 210mm;">
    <div style="min-height: 210mm; padding: 0.75rem 0.5rem;">
        <div style="background-color: white; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <!-- Header -->
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h1 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #111827;">INVOICE</h1>
                        <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #4b5563;">
                            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div style="text-align: right;">
                        <div
                            style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; justify-content: flex-end;">
                            {{-- <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Almarsa" style="width: 2rem; height: 2rem;"> --}}
                            <span style="font-weight: 600;">Almarsa</span>
                        </div>
                        <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #4b5563;">info@almarsa-gourmet.com</p>
                    </div>
                </div>
            </div>

            <!-- Billing & Shipping Info -->
            <div style="padding: 1rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div>
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; font-weight: 600; color: #111827;">Shipping To
                    </h2>
                    @if ($order->address)
                        <div style="color: #4b5563; font-size: 0.75rem;">
                            @if ($order->address->building_name)
                                <p style="margin: 0 0 0.25rem 0; font-weight: 500;">Building Name:
                                    {{ $order->address->building_name }}</p>
                            @endif
                            @if ($order->address->apartment_number)
                                <p style="margin: 0;">Apartment Number: {{ $order->address->apartment_number }}</p>
                            @endif
                            @if ($order->address->house_number)
                                <p style="margin: 0;">House Number: {{ $order->address->house_number }}</p>
                            @endif
                            @if ($order->address->street)
                                <p style="margin: 0;">Street: {{ $order->address->street }}</p>
                            @endif
                            @if ($order->address->block)
                                <p style="margin: 0;">Block: {{ $order->address->block }}</p>
                            @endif
                            @if ($order->address->way)
                                <p style="margin: 0;">Way: {{ $order->address->way }}</p>
                            @endif
                            <p style="margin: 0;">Phone: {{ $order->address->phone }}</p>
                        </div>
                    @endif

                </div>
                <div>
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; font-weight: 600; color: #111827;">Invoice
                        Details</h2>
                    <div style="color: #4b5563; font-size: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span>Invoice Date:</span>
                            <span>{{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Status:</span>
                            <span
                                style="background-color: #fef3c7; color: #92400e; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; text-transform: capitalize;">{{ $order->status }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div style="padding: 1rem;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.75rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.5rem;">Item</th>
                            <th style="text-align: center; padding: 0.5rem;">Qty</th>
                            <th style="text-align: right; padding: 0.5rem;">Price</th>
                            <th style="text-align: right; padding: 0.5rem;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                            style="width: 2rem; height: 2rem; border-radius: 0.25rem; object-fit: cover;">
                                        <span style="font-weight: 500; color: #111827;">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td style="text-align: center; padding: 0.5rem;">{{ $item->quantity }}</td>
                                <td style="text-align: right; padding: 0.5rem;">{{ number_format($item->price, 2) }}
                                </td>
                                <td style="text-align: right; padding: 0.5rem;">
                                    {{ number_format($item->sub_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div style="padding: 1rem; background-color: rgb(249, 250, 251); border-radius: 0 0 0.25rem 0.25rem;">
                <div style="max-width: 12rem; margin-left: auto;">
                    <div style="font-size: 0.75rem;">
                        <div
                            style="display: flex; justify-content: space-between; color: #4b5563; margin-bottom: 0.5rem;">
                            <span>Subtotal</span>
                            <span> OMR {{ $order->sub_total }}</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; color: #4b5563; margin-bottom: 0.5rem;">
                            <span>Shipping</span>
                            <span> OMR {{ $order->shipping_cost }}</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; color: #4b5563; margin-bottom: 0.5rem;">
                            <span>Discount</span>
                            <span>- OMR {{ $order->discount }}</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-weight: 600; color: #111827; padding-top: 0.5rem; border-top: 1px solid #e5e7eb;">
                            <span>Total</span>
                            <span> OMR {{ $order->grand_total }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
