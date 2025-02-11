<x-app-layout>
    <div class="space-y-5">

        <div class="grid xl:grid-cols-3 grid-cols-1 gap-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shipping Details</h4>
                    <div>...</div>
                </div>
                <div class="card-body p-6">

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_first_name }}
                                {{ $order->shipping_last_name }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping Address:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_address }},
                                {{ $order->shipping_address2 }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping City:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_city }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping Country:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_country }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping State:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_state ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping Postal Code:
                            </p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_postal_code }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Shipping Phone:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->shipping_phone }}</p>
                        </div>
                    </div>


                </div>
            </div>
            <!-- end task -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customer details</h4>
                    <div>...</div>
                </div>
                <div class="card-body p-6">

                    <!-- BEGIN: Message -->

                    <div class="block">
                        <img src="{{ $order->user->image ?? asset('assets/images/all-img/avater2.png') }}"
                            alt="profile" class="w-20 h-20 rounded-full">
                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Email:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">First Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->first_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Last Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->last_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Address:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->address ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Address 2:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->address2 ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">City:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->city ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Country:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->country ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Postal Code:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->postal_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Phone:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <!-- END: Message  -->

                </div>
            </div>
            <!-- end message -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activity</h4>
                    <div>...</div>
                </div>
                <div class="card-body p-6">

                    <!-- BEGIN: Activity Card -->


                    <ul class="relative ltr:pl-2 rtl:pr-2">


                        <li
                            class="ltr:border-l-2 rtl:border-r-2 border-slate-100 dark:border-slate-700 pb-4 
                 last:border-none ltr:pl-[22px] rtl:pr-[22px] relative before:absolute ltr:before:left-[-8px] 
                 rtl:before:-right-2 before:top-[0px] before:rounded-full before:w-4 before:h-4
                  before:bg-slate-900 dark:before:bg-slate-600 before:leading-[2px] 
                  before:content-[url('../images/all-img/ck.svg')]">
                            <div class="p-[10px] relative top-[-20px]">
                                <h2 class="text-sm font-medium dark:text-slate-400-900 mb-1 text-slate-600">
                                    Project start date
                                </h2>
                                <p class="text-xs capitalize dark:text-slate-400">
                                    Sep 20, 2021
                                </p>
                            </div>
                        </li>


                        <li
                            class="ltr:border-l-2 rtl:border-r-2 border-slate-100 dark:border-slate-700 pb-4 
                 last:border-none ltr:pl-[22px] rtl:pr-[22px] relative before:absolute ltr:before:left-[-8px] 
                 rtl:before:-right-2 before:top-[0px] before:rounded-full before:w-4 before:h-4
                  before:bg-slate-900 dark:before:bg-slate-600 before:leading-[2px] 
                  before:content-[url('../images/all-img/ck.svg')]">
                            <div class="p-[10px] relative top-[-20px]">
                                <h2 class="text-sm font-medium dark:text-slate-400-900 mb-1 text-slate-600">
                                    Project start date
                                </h2>
                                <p class="text-xs capitalize dark:text-slate-400">
                                    Sep 20, 2021
                                </p>
                            </div>
                        </li>


                        <li
                            class="ltr:border-l-2 rtl:border-r-2 border-slate-100 dark:border-slate-700 pb-4 
                 last:border-none ltr:pl-[22px] rtl:pr-[22px] relative before:absolute ltr:before:left-[-8px] 
                 rtl:before:-right-2 before:top-[0px] before:rounded-full before:w-4 before:h-4
                  before:bg-slate-900 dark:before:bg-slate-600 before:leading-[2px] 
                  before:content-[url('../images/all-img/ck.svg')]">
                            <div class="p-[10px] relative top-[-20px]">
                                <h2 class="text-sm font-medium dark:text-slate-400-900 mb-1 text-slate-600">
                                    Project start date
                                </h2>
                                <p class="text-xs capitalize dark:text-slate-400">
                                    Sep 20, 2021
                                </p>
                            </div>
                        </li>


                        <li
                            class="ltr:border-l-2 rtl:border-r-2 border-slate-100 dark:border-slate-700 pb-4 
                 last:border-none ltr:pl-[22px] rtl:pr-[22px] relative before:absolute ltr:before:left-[-8px] 
                 rtl:before:-right-2 before:top-[0px] before:rounded-full before:w-4 before:h-4
                  before:bg-slate-900 dark:before:bg-slate-600 before:leading-[2px] 
                  before:content-[url('../images/all-img/ck.svg')]">
                            <div class="p-[10px] relative top-[-20px]">
                                <h2 class="text-sm font-medium dark:text-slate-400-900 mb-1 text-slate-600">
                                    Project start date
                                </h2>
                                <p class="text-xs capitalize dark:text-slate-400">
                                    Sep 20, 2021
                                </p>
                            </div>
                        </li>


                        <li
                            class="ltr:border-l-2 rtl:border-r-2 border-slate-100 dark:border-slate-700 pb-4 
                 last:border-none ltr:pl-[22px] rtl:pr-[22px] relative before:absolute ltr:before:left-[-8px] 
                 rtl:before:-right-2 before:top-[0px] before:rounded-full before:w-4 before:h-4
                  before:bg-slate-900 dark:before:bg-slate-600 before:leading-[2px] 
                  before:content-[url('../images/all-img/ck.svg')]">
                            <div class="p-[10px] relative top-[-20px]">
                                <h2 class="text-sm font-medium dark:text-slate-400-900 mb-1 text-slate-600">
                                    Project start date
                                </h2>
                                <p class="text-xs capitalize dark:text-slate-400">
                                    Sep 20, 2021
                                </p>
                            </div>
                        </li>

                    </ul>
                    <!-- END: Activity Card -->
                </div>
            </div>
            <!-- end activity -->
        </div>


        <div class="grid grid-cols-12 gap-5">
            <div class="xl:col-span-8 lg:col-span-7 col-span-12">
                <div class="card">
                    <div class="card-header noborder">
                        <h4 class="card-title ">Products</h4>
                        <div>...</div>
                    </div>
                    <div class="card-body p-6">

                        <!-- BEGIN: Team Table -->

                        <div class="overflow-x-auto -mx-6">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden ">
                                    <table
                                        class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                        <thead class=" bg-slate-200 dark:bg-slate-700">
                                            <tr>

                                                <th scope="col" class=" table-th ">
                                                    NAME
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    PRICE
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    QUANTITY
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    TOTAL
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    ACTION
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td class="table-td">
                                                        <div class="flex items-center">
                                                            <div class="flex-none">
                                                                <div class="w-8 h-8 rounded-[100%] ltr:mr-3 rtl:ml-3">
                                                                    <img src="{{ $item->image }}"
                                                                        alt="{{ $item->name }}"
                                                                        class="w-full h-full rounded-[100%] object-cover">
                                                                </div>
                                                            </div>
                                                            <div class="flex-1 text-start">
                                                                <h4
                                                                    class="text-sm font-medium text-slate-600 whitespace-wrap">
                                                                    {{ $item->name }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="table-td">{{ $item->price }}</td>
                                                    <td class="table-td ">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="table-td">{{ $item->sub_total }}</td>
                                                    <td class="table-td">
                                                        <a href="{{ route('order.show', $order->id) }}"
                                                            class="action-btn" type="button">
                                                            <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END: Team table -->

                    </div>
                </div>
            </div>
            <div class="xl:col-span-4 lg:col-span-5 col-span-12">
                <div class="card h-full">
                    <div class="card-header">
                        <h4 class="card-title">Price Details</h4>
                    </div>
                    <div class="card-body p-6">
                        <div class="flex flex-col space-y-4 bg-god">
                            <div class="flex justify-between">
                                <span class="text-slate-600 dark:text-slate-300">Shipping Cost</span>
                                <span
                                    class="text-slate-600 dark:text-slate-300">${{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600 dark:text-slate-300">Sub Total</span>
                                <span
                                    class="text-slate-600 dark:text-slate-300">${{ number_format($order->sub_total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600 dark:text-slate-300">Discount</span>
                                <span
                                    class="text-slate-600 dark:text-slate-300">${{ number_format($order->discount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600 dark:text-slate-300">Grand Total</span>
                                <span
                                    class="text-slate-600 dark:text-slate-300">${{ number_format($order->grand_total, 2) }}</span>
                            </div>
                        </div>
                        <!-- END: FIles Card -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
