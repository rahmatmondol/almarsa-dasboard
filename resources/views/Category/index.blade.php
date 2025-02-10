<x-app-layout>
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route('dashboard') }}">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                Categories</li>
        </ul>
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
                                            icon
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Name
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Parent
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            product count
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Status
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="table-td ">#{{ $category->id }}</td>
                                            <td class="table-td">
                                                <span class="flex">
                                                    <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                        <img src="{{ $category->image ?? asset('assets/images/post/t-3.png') }}"
                                                            class="object-cover w-full h-full rounded-full">
                                                    </span>
                                                </span>
                                            </td>
                                              <td class="table-td">
                                                <span class="flex">
                                                    <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                        <img src="{{ $category->icon ?? asset('assets/images/post/t-3.png') }}"
                                                            class="object-cover w-full h-full rounded-full">
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="table-td ">{{ $category->name }}</td>
                                            <td class="table-td ">
                                                @if ($category->parent_id)
                                                    {{ $category->parent->name }}
                                                @else
                                                    <span class="text-xs text-slate-500">No Parent</span>
                                                @endif
                                            </td>

                                            <td class="table-td ">{{ $category->product_count }}</td>

                                            <td class="table-td ">
                                                @if ($category->status)
                                                    <div
                                                        class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500  bg-success-500">
                                                        Active
                                                    </div>
                                                @else
                                                    <div
                                                        class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-danger-500  bg-danger-500">
                                                        Inactive
                                                    </div>
                                                @endif

                                            </td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <a href="{{ route('category.show', $category->id) }}"
                                                        class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </a>
                                                    <a href="{{ route('category.edit', $category->id) }}"
                                                        class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </a>
                                                    <form action="{{ route('category.destroy', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            onclick="return confirm('Are you sure? You want to delete this category')"
                                                            class="action-btn delete-btn" type="submit">
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
