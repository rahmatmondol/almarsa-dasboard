<x-app-layout>
    <div class="space-y-5">

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customer details</h4>
                </div>
                <div class="card-body p-6">

                    <!-- BEGIN: Message -->

                    <div class="block">
                        <img src="{{ $user->image ?? asset('assets/images/all-img/avater2.png') }}" alt="profile"
                            class="w-20 h-20 rounded-full">
                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Email:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">First Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->first_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Last Name:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->last_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Address:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->address ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Address 2:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->address2 ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">City:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->city ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Country:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->country ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Postal Code:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->postal_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 dark:text-slate-300 text-sm  mb-1">Phone:</p>
                            <p class="text-slate-800 dark:text-slate-400 text-xxl font-medium">
                                {{ $user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <!-- END: Message  -->

                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="xl:col-span-12 lg:col-span-12 col-span-12">
                <div class="card">
                    <div class="card-header noborder">
                        <h4 class="card-title ">Orders</h4>
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
                                                    Id
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    Date
                                                </th>
                                                 <th scope="col" class=" table-th ">
                                                    Subtotal
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    Quantity
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    Grand Total
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    Status
                                                </th>
                                                <th scope="col" class=" table-th ">
                                                    ACTION
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                            @foreach ($user->orders as $item)
                                                <tr>
                                                    <td class="table-td">#{{ $item->id }}</td>
                                                    <td class="table-td ">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </td>
                                                     <td class="table-td ">
                                                        {{ $item->sub_total }}
                                                    </td>
                                                    <td class="table-td">{{ $item->items->count() }}</td>
                                                    <td class="table-td ">
                                                        {{ $item->grand_total }}
                                                    </td>
                                                    <td class="table-td ">
                                                        {{ $item->status }}
                                                    </td>
                                                    <td class="table-td">
                                                        <a href="{{ route('order.show', $item->id) }}" class="action-btn"
                                                            type="button">
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
        </div>
    </div>

</x-app-layout>
