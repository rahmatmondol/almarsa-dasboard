<x-app-layout>
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <div class="flex justify-between space-x-2 items-center">
            <ul class="m-0 p-0 list-none">
                <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                    <a href="{{ route('dashboard') }}">
                        <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                        <iconify-icon icon="heroicons-outline:chevron-right"
                            class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                    </a>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    Oreders</li>
            </ul>
        </div>
    </div>
    <!-- END: BreadCrumb -->

    <div class=" space-y-5">
        <div class="card">
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                    <span class=" col-span-8  hidden"></span>
                    <span class="  col-span-4 hidden"></span>
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table
                                class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                <thead class=" bg-slate-200 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class=" table-th ">
                                            Id
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Order Date
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Customer
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Status
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            total
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Items
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="table-td ">#{{ $order->id }}</td>
                                            <td class="table-td ">
                                                {{ $order->created_at->diffForHumans() }}
                                            </td>
                                            <td class="table-td ">{{ $order->user->name }}</td>
                                            <td class="table-td ">{{ $order->status }}</td>
                                            <td class="table-td ">{{ $order->grand_total }}</td>
                                            <td class="table-td ">{{ $order->items_count }}</td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <a href="{{ route('order.show', $order->id) }}"
                                                        class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
