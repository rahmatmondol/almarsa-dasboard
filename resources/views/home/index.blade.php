<x-app-layout>
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4
            class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
            Home page setting</h4>

    </div>

    <div class="grid xl:grid-cols-1 grid-cols-1 gap-6 h-auto">
        <form method="POST" id="banner-form">
            @csrf
            <!-- Basic Inputs -->
            <div class="card xl:col-span-1">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Banner Seetins</div>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-4">
                        <div class="input-area">
                            <label for="title" class="form-label">title</label>
                            <input id="title" name="title" type="text" value="{{ $home->title ?? '' }}"
                                class="form-control" placeholder="title">
                        </div>
                        <div class="input-area">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{{ $home->description ?? '' }}</textarea>
                        </div>
                        
                        <div class="input-area image_area">
                            <label for="icon" class="form-label">Icon</label>
                            <input id="icon" name="icon" type="file" class="form-control">
                            <div class="mt-4 relative preview-conteiner">
                                @if ($home && $home->icon)
                                    <img class="preview" src="{{ $home->icon }}" style="max-width: 200px;">
                                @else
                                    <img class="preview" style="max-width: 200px; display: none;">
                                @endif
                                <button type="button" style="display: none;"
                                    class="delete-image btn-danger p-1 rounded-full text-white absolute top-0 right-0">x</button>
                            </div>
                        </div>

                        <div class="input-area image_area">
                            <label for="image" class="form-label">Background Image</label>
                            <input id="image" name="image" type="file" class="form-control">
                            <div class="mt-4 relative preview-conteiner">
                                @if ($home && $home->image)
                                    <img class="preview" src="{{ $home->image }}" style="max-width: 200px;">
                                @else
                                    <img class="preview" style="max-width: 200px; display: none;">
                                @endif
                                <button type="button" style="display: none;"
                                    class="delete-image btn-danger p-1 rounded-full text-white absolute top-0 right-0">x</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="grid xl:grid-cols-3 grid-cols-1 gap-6 h-auto mt-6">

        <div class="card xl:col-span-2">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Home category list</div>
                    </div>
                </header>

                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <thead class=" border-t border-slate-100 dark:border-slate-800">
                                        <tr>
                                            <th scope="col" class=" table-th ">
                                                Id
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Name
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Image
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Category name
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Products
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Status
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="home-list"
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card xl:col-span-1">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white" id="list-title">Add category</div>
                    </div>
                </header>

                {{-- add new --}}
                <div id="add-list">
                    <form method="POST" id="list-form">
                        <div class="card-text h-full space-y-4">
                            @csrf
                            <div class="input-area">
                                <label for="list_title" class="form-label">Title</label>
                                <input id="list_title" name="title" type="text" class="form-control">
                                <input id="list_id" name="id" type="hidden" class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="category_id" class="form-label">Select Category</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="" class="dark:bg-slate-700" selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area image_area">
                                <label for="list_iconge" class="form-label">List Icon</label>
                                <input id="list_iconge" name="icon" type="file" class="form-control">
                                <div class="mt-4 relative preview-conteiner">
                                    <img class="preview" style="max-width: 200px; display: none;">
                                    <button type="button" style="display: none;"
                                        class="delete-image btn-danger p-1 rounded-full text-white absolute top-0 right-0">x</button>
                                </div>
                            </div>

                            <div class="input-area">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1" class="dark:bg-slate-700">Active</option>
                                    <option value="0" class="dark:bg-slate-700">Inactive</option>
                                </select>
                            </div>

                            <div class="input-area">
                                <button type="submit" class="btn btn-primary save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- update  --}}
                <div id="update-form" style="display: none;">
                    <form method="POST" id="update-list">
                        <div class="card-text h-full space-y-4">
                            @csrf
                            <div class="input-area">
                                <label for="list_title" class="form-label">Title</label>
                                <input id="list_title" name="title" type="text" class="form-control">
                                <input id="list_id" name="id" type="hidden" class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="update_category_id" class="form-label">Select Category</label>
                                <select id="update_category_id" name="category_id" class="form-control">
                                    <option value="" class="dark:bg-slate-700" selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area image_area">
                                <label for="list_iconge" class="form-label">List Icon</label>
                                <input id="list_iconge" name="icon" type="file" class="form-control">
                                <div class="mt-4 relative preview-conteiner">
                                    <img class="preview" style="max-width: 200px; display: none;">
                                    <button type="button" style="display: none;"
                                        class="delete-image btn-danger p-1 rounded-full text-white absolute top-0 right-0">x</button>
                                </div>
                            </div>

                            <div class="input-area">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1" class="dark:bg-slate-700">Active</option>
                                    <option value="0" class="dark:bg-slate-700">Inactive</option>
                                </select>
                            </div>

                            <div class="input-area">
                                <button type="submit" class="btn btn-success update">Update</button>
                                <button type="submit" class="btn btn-warning cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // jquery 
        $(document).ready(function($) {

            let homeLists = [];

            // defult image
            $('.image_area').each(function() {
                const input = $(this).find('input[type="file"]')[0];
                if (input && input.files.length > 0) {
                    const file = input.files[0];
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const imgElement = $(this).find('.preview');
                        imgElement.attr('src', event.target.result).show();
                        $(this).find('.delete-image').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Image preview
            $(document).on('change', '.image_area input[type="file"]', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const imgElement = $(e.target).closest('.image_area').find('.preview');
                        imgElement.attr('src', event.target.result).show();
                        $(e.target).closest('.image_area').find('.delete-image').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // delete image
            $(document).on('click', '.delete-image', function(e) {
                const imgElement = $(e.target).closest('.image_area').find('.preview');
                imgElement.attr('src', '').hide();
                $(e.target).closest('.image_area').find('.delete-image').hide();
                $(e.target).closest('.image_area').find('input[type="file"]').val('');
            })

            // get home list
            const homeList = () => {
                let lists;
                $.ajax({
                    type: 'GET',
                    url: '{{ route('home.list') }}',
                    success: function(res) {
                        if (res.data.length > 0) {
                            homeLists = res.data;
                            $.each(res.data, function(index, value) {
                                let status;
                                if (value.status) {
                                    status = ` <div class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500  bg-success-500">
                                                    Active
                                                </div>`;
                                } else {
                                    status = ` <div class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-danger-500  bg-danger-500">
                                                    Inactive
                                                </div>`;
                                }

                                lists += `<tr>
                                            <td class="table-td ">#${value.id}</td>
                                            <td class="table-td ">${value.title}</td>
                                            <td class="table-td ">
                                             <span class="flex">
                                                    <span class="w-10 h-10 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                        <img src="${value.icon ?? ''}"
                                                            class="object-cover w-full h-full rounded-full">
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="table-td ">${value.category?.name}</td>
                                            <td class="table-td ">${value.category?.product_count}</td>
                                            <td class="table-td ">
                                                ${status}
                                            </td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <button class="action-btn list-edit" data-id="${value.id}" type="button">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </button>
                                                     <button class="action-btn list-delete" data-id="${value.id}" type="button">
                                                        <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>`;
                            });
                            $('#home-list').html(lists);
                        }

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            homeList();

            // Submit Form
            $('#banner-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('home.store') }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message,
                        });
                        console.error(xhr.responseText);
                    }
                });
            });

            // list form
            $('#list-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('home.list.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#list-form')[0].reset();
                            $('#list-form').find('.preview').hide();
                            $('#list-form').find('.delete-image').hide();
                            homeList();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    }
                });
            });

            // list edit
            $(document).on('click', '.list-edit', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let list = homeLists.find(item => item.id == id);
                if (list) {
                    $('#update-form').find('input[name="title"]').val(list.title);
                    $('#update_category_id').val(list.category_id);
                    $('#status').val(list.status ? 1 : 0);
                    $('#update-form').find('.preview').attr('src', list.icon);
                    $('#update-form').find('.preview').show();
                    $('#update-form').find('.delete-image').show();
                    $('#update-form').find('input[name="id"]').val(list.id);
                    $('#add-list').hide();
                    $('#update-form').show();
                    $('#list-title').text('Update List');
                }
            });

            // list cancel
            $(document).on('click', '.cancel', function(e) {
                e.preventDefault();
                $('#add-list').show();
                $('#update-form').hide();
                $('#list-title').text('Add List');
            })

            // list delete
            $(document).on('click', '.list-delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('home.list.delete') }}",
                            type: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                    });
                                    homeList();
                                }
                            }
                        });
                    }
                });
            });

            // list update
            $('#update-list').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('home.list.update') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#add-list').show();
                            $('#update-form').hide();
                            $('#list-title').text('Add List');
                            homeList();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    }
                });
            });

        });
    </script>
</x-app-layout>
