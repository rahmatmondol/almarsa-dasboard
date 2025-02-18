<x-app-layout>
    <div class="py-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Placed on
                            {{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y') }}</p>
                        <!-- Action Buttons -->

                    </div>
                    <div class="flex flex-col gap-2">
                        @if ($order->status == 'processing')
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-primary-500 bg-primary-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @elseif ($order->status == 'completed')
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500 bg-success-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @elseif ($order->status == 'cancelled')
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-danger-500 bg-danger-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @elseif ($order->status == 'refunded')
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-warning-500 bg-warning-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @elseif ($order->status == 'failed')
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-danger-500 bg-danger-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @else
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-secondary-500 bg-secondary-500">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                        <a href="{{ route('order.invoice', $order->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Download Invoice
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Management Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Order Status</h2>
                <form action="{{ route('order.update', $order->id) }}" method="GET" class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Select New Status</label>
                        <select id="status" name="status"
                            class="mt-2 block w-full pl-3 p-4 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded
                            </option>
                            <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="payment_pending"
                                {{ $order->status === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center items-center px-4 py-2 border text-sm font-medium rounded-md shadow-sm bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                    <div class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <div class="py-6 flex items-center">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                                <div class="ml-4 flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                    <div class="mt-1 flex items-center text-sm text-gray-500">
                                        <span>Qty: {{ $item->quantity }}</span>
                                        <span class="mx-2">•</span>
                                        <span>${{ number_format($item->price, 2) }} each</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        ${{ number_format($item->sub_total, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900">${{ number_format($order->sub_total, 2) }}
                            </dd>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Discount</dt>
                                <dd class="text-sm font-medium text-red-600">-${{ number_format($order->discount, 2) }}
                                </dd>
                            </div>
                        @endif
                        @if ($order->shipping_cost > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    ${{ number_format($order->shipping_cost, 2) }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between border-t border-gray-200 pt-4">
                            <dt class="text-base font-medium text-gray-900">Total</dt>
                            <dd class="text-base font-medium text-gray-900">
                                ${{ number_format($order->grand_total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 p-6">
                    <h2 class="text-xl font-bold text-white mb-1">Customer Information</h2>
                    <p class="text-indigo-100">Shipping and Billing Details</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shipping Address -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Shipping Address</h3>
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Name:</span>
                                    <span class="font-medium text-gray-900">{{ $order->shipping_first_name }}
                                        {{ $order->shipping_last_name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Address:</span>
                                    <span class="font-medium text-gray-900">{{ $order->shipping_address }}</span>
                                </div>
                                @if ($order->shipping_address2)
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-24">Address 2:</span>
                                        <span class="font-medium text-gray-900">{{ $order->shipping_address2 }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">City:</span>
                                    <span class="font-medium text-gray-900">{{ $order->shipping_city }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Postal Code:</span>
                                    <span class="font-medium text-gray-900">{{ $order->shipping_postal_code }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Country:</span>
                                    <span
                                        class="font-medium text-gray-900 uppercase">{{ $order->shipping_country }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                                    </rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Billing Information</h3>
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Name:</span>
                                    <span class="font-medium text-gray-900">{{ $user->first_name }}
                                        {{ $user->last_name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Email:</span>
                                    <span class="font-medium text-gray-900">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Phone:</span>
                                    <span class="font-medium text-gray-900">{{ $user->phone }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Address:</span>
                                    <span class="font-medium text-gray-900">{{ $user->address }}</span>
                                </div>
                                @if ($user->address2)
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-24">Address 2:</span>
                                        <span class="font-medium text-gray-900">{{ $user->address2 }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">City:</span>
                                    <span class="font-medium text-gray-900">{{ $user->city }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Postal Code:</span>
                                    <span class="font-medium text-gray-900">{{ $user->postal_code }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500 w-24">Country:</span>
                                    <span class="font-medium text-gray-900 uppercase">{{ $user->country }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
