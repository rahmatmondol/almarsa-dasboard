<x-app-layout>
    <div class="py-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Customer Profile Header -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <img class="h-24 w-24 rounded-full border-4 border-white object-cover"
                        src="{{ $customer->image ?? asset('assets/images/avatar.jpg') }}"
                        alt="{{ $customer->name ?? 'Customer' }}">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $customer->first_name }} {{ $customer->last_name }}
                        </h1>
                        <p class="text-blue-100 mt-1">Customer since
                            {{ \Carbon\Carbon::parse($customer->created_at)->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-3 divide-x divide-gray-200 -mt-px">
                <div class="p-6 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $customer->orders->count() }}</p>
                    <p class="text-sm font-medium text-gray-500">Total Orders</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-2xl font-bold text-gray-900">OMR
                        {{ number_format($customer->orders->sum('grand_total'), 2) }}</p>
                    <p class="text-sm font-medium text-gray-500">Total Spent</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ round($customer->orders->avg('count')) }}</p>
                    <p class="text-sm font-medium text-gray-500">Avg. Items per Order</p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                    Contact Information
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">Email:</span>
                        <a href="mailto:{{ $customer->email }}"
                            class="text-blue-600 hover:text-blue-800">{{ $customer->email }}</a>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">Phone:</span>
                        <a href="tel:{{ $customer->phone }}"
                            class="text-blue-600 hover:text-blue-800">{{ $customer->phone }}</a>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Address
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">Address:</span>
                        <span class="text-gray-900">{{ $customer->address }}</span>
                    </div>
                    @if ($customer->address2)
                        <div class="flex items-center">
                            <span class="text-gray-500 w-20">Address 2:</span>
                            <span class="text-gray-900">{{ $customer->address2 }}</span>
                        </div>
                    @endif
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">City:</span>
                        <span class="text-gray-900">{{ $customer->city }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">Country:</span>
                        <span class="text-gray-900">{{ strtoupper($customer->country) }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-20">Postal:</span>
                        <span class="text-gray-900">{{ $customer->postal_code }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Account Details
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="text-gray-500 w-24">Customer ID:</span>
                        <span class="text-gray-900">#{{ $customer->id }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-24">Joined:</span>
                        <span
                            class="text-gray-900">{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-24">Last Updated:</span>
                        <span
                            class="text-gray-900">{{ \Carbon\Carbon::parse($customer->updated_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-24">Status:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Details -->
        @if ($customer->cart && $customer->cart->items->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Current Cart</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $customer->cart->items->sum('quantity') }} items in
                            cart</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Subtotal: <span class="font-medium text-gray-900">OMR
                                {{ number_format($customer->cart->sub_total, 2) }}</span></p>
                        @if ($customer->cart->discount > 0)
                            <p class="text-sm text-red-500">Discount: -OMR
                                {{ number_format($customer->cart->discount, 2) }}</p>
                        @endif
                        <p class="text-base font-medium text-gray-900">Total: OMR
                            {{ number_format($customer->cart->grand_total, 2) }}</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customer->cart->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ $item->image }}"
                                                alt="{{ $item->name }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        OMR {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        OMR {{ number_format($item->sub_total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Wishlist Details -->
        @if ($customer->wishlist && $customer->wishlist->items->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Wishlist</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $customer->wishlist->items->count() }} items saved for
                        later</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Added On</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customer->wishlist->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ $item->image }}"
                                                alt="{{ $item->name }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        OMR {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Order History -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Order History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($customer->orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $order->status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($order->status === 'completed'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->count }} items
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    OMR {{ number_format($order->grand_total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('order.show', $order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
