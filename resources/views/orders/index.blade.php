<x-app-layout>
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5 ">
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
            <div class="flex flex-col items-end">
                <form action="{{ route('order.list') }}" method="GET">
                    <select name="status" id="basicSelect" class="form-control w-full mt-2"
                        onchange="this.form.submit()">
                        <option selected="Selected" disabled="disabled" value="none"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">Filter Orders
                        </option>
                        <option value="all" class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            All
                        </option>
                        <option value="completed"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Completed
                        </option>
                        <option value="cancelled"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Cancelled
                        </option>
                        <option value="pending" class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Pending
                        </option>
                        <option value="Processing"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Processing
                        </option>
                        <option value="Failed" class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Failed
                        </option>
                        <option value="Refunded"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Refunded
                        </option>
                        <option value="Payment_pending"
                            class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">
                            Payment Pending
                        </option>
                    </select>
            </div>
            </form>
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
                                            <td class="table-td ">
                                                {{ $order->user->name ?? ($order->user->email ?? 'N/A') }}</td>
                                            <td class="table-td ">
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
                                            </td>
                                            <td class="table-td ">{{ $order->grand_total }}</td>
                                            <td class="table-td ">{{ $order->items_count }}</td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <a href="{{ route('order.show', $order->id) }}" class="action-btn"
                                                        type="button">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </a>
                                                    <a href="{{ route('order.invoice', $order->id) }}" target="_blank"
                                                        class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:document"></iconify-icon>
                                                    </a>

                                                    <form action="{{ route('order.destroy', $order->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn delete-btn"
                                                            onclick="return confirm('Are you sure? You want to delete this order')">
                                                            <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                        </button>
                                                    </form>
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
