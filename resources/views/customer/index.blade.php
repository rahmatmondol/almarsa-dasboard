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
                    Customers</li>
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
                                            Image
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Name
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Email
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Phone
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Orders
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Spend
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Registered
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="table-td ">#{{ $user->id }}</td>
                                            <td class="table-td">
                                                <span class="flex">
                                                    <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                        <img src="{{ $user->icon ?? asset('assets/images/post/t-3.png') }}"
                                                            class="object-cover w-full h-full rounded-full">
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="table-td ">{{ $user->name ?? 'N/A' }}</td>
                                            <td class="table-td ">{{ $user->email ?? 'N/A' }}</td>
                                            <td class="table-td ">{{ $user->phone ?? 'N/A' }}</td>
                                            <td class="table-td ">{{ $user->orders->count() ?? 'N/A' }}</td>
                                            <td class="table-td ">{{ $user->total_spent ?? 'N/A' }}</td>

                                            <td class="table-td ">
                                                {{ $user->created_at->diffForHumans() }}
                                            </td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <a href="{{ route('customer.show', $user->id) }}" class="action-btn"
                                                        type="button">
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
