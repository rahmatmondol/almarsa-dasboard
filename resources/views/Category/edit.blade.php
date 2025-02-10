<x-app-layout>
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4
            class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
            Edit Category</h4>

    </div>
    <form id="category-form">
        <div class="grid xl:grid-cols-3 grid-cols-1 gap-6 h-auto">
            <!-- Basic Inputs -->
            @csrf
            <div class="card xl:col-span-2">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Category Details</div>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-4">
                        <div class="input-area">
                            <label for="name" class="form-label">Category Name</label>
                            <input id="name" name="name" type="text" class="form-control"
                                placeholder="Category Name" value="{{ $category->name }}">
                        </div>
                        <div class="input-area">
                            <label for="description" class="form-label">Category Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{{ $category->description }}</textarea>
                        </div>
                        <div class="input-area">
                            <label for="select" class="form-label">Parent Category</label>
                            <select id="select" name="parent_id" class="form-control">
                                <option value="" class="dark:bg-slate-700">Root</option>
                                @foreach ($categories as $value)
                                    @if ($value->id == $category->id)
                                        @continue
                                    @endif
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-area">
                            <label for="image" class="form-label">Category icon</label>
                            <input id="icon" name="icon" type="file" class="form-control"
                                onchange="iconPreview(event)">
                            @if ($category->icon)
                                <div class="mt-4 relative">
                                    <img id="icon-preview" src="{{ $category->icon }}" style="max-width: 200px;">
                                    <button type="button" style="display: none;"
                                        class="delete-icon-btn btn-danger p-1 rounded-full text-white absolute top-0 right-0"
                                        onclick="deleteIcon()">x</button>
                                </div>
                            @endif
                        </div>
                        <div class="input-area">
                            <label for="image" class="form-label">Category Image</label>
                            <input id="image" name="image" type="file" class="form-control"
                                onchange="previewImage(event)">
                            @if ($category->image)
                                <div class="mt-4 relative">
                                    <img id="image-preview" src="{{ $category->image }}" style="max-width: 100%;">
                                    <button type="button" style="display: none;"
                                        class="delete-image-btn btn-danger p-1 rounded-full text-white absolute top-0 right-0"
                                        onclick="deleteImage()">x</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card xl:col-span-1">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Category Information</div>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-4">

                        <div class="input-area">
                            <label for="collection_id" class="form-label">Product Count</label>
                            <input id="product_count" name="product_count" value="{{ $category->product_count }}"
                                type="text" class="form-control" readonly>
                        </div>

                        <div class="input-area">
                            <label for="collection_id" class="form-label">Select Wix Collection</label>
                            <select id="collection_id" name="collection_id" class="form-control">
                                <option value="" class="dark:bg-slate-700" selected>Select Collection</option>
                            </select>
                        </div>

                        <div class="input-area">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="1" class="dark:bg-slate-700">Active</option>
                                <option value="0" class="dark:bg-slate-700">Inactive</option>
                            </select>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>


    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#image-preview').attr('src', reader.result).show();
            };
            reader.readAsDataURL(event.target.files[0]);
            $('.delete-image-btn').show();
        }

        function deleteImage() {
            $('#image-preview').attr('src', '').hide();
            $('#icon').val('');
            $('.delete-image-btn').hide();
        }

        function iconPreview(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#icon-preview').attr('src', reader.result).show();
            };
            reader.readAsDataURL(event.target.files[0]);
            $('.delete-icon-btn').show();
        }

        function deleteIcon() {
            $('#icon-preview').attr('src', '').hide();
            $('#image').val('');
            $('.delete-icon-btn').hide();
        }

        $(document).ready(function() {

            let limit = 100;
            let offset = 0;
            let collections = [];
            let status = '{{ $category->status }}';
            // set parent category
            $('#select').val({{ $category->parent_id }});
            $('#status').val(status ? 1 : 0);
            // set collection

            //get wix collections
            $.ajax({
                type: 'GET',
                url: '{{ route('wix.collection') }}',
                data: {
                    limit: limit,
                    offset: offset
                },
                success: function(data) {
                    if (data.collections.length == 0) {
                        $('#collection_id').append(
                            '<option value="" style="background: #32bcff;" selected>No Collection Found</option>'
                        );
                        return;
                    }
                    collections = data.collections;

                    if (offset > 0) {
                        $('#collection_id').append(
                            '<option class="previous-page" style="background: #32bcff;" value="">Previous Page</option>'
                        );
                    }

                    $.each(data.collections, function(index, value) {
                        $('#collection_id').append(
                            `<option value="${value.id}">${value.name} (${value.numberOfProducts})</option>`
                        );
                    });

                    if (data.totalResults > offset + limit) {
                        $('#collection_id').append(
                            '<option class="next-page" style="background: #32bcff;">Next Page</option>'
                        );
                    }

                    $('#collection_id').val('{{ $category->collection_id }}');

                },
                error: function(data) {
                    console.log(data);
                }
            });

            //next page
            $(document).on('click', '.next-page', function() {
                offset = offset + limit;
                $('#collection_id').empty();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('wix.collection') }}',
                    data: {
                        limit: limit,
                        offset: offset
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.collections.length == 0) {
                            $('#collection_id').append(
                                '<option value="" class="dark:bg-slate-700" selected>No Collection Found</option>'
                            );
                            return;
                        }

                        if (offset > 0) {
                            $('#collection_id').append(
                                '<option class="dark:bg-slate-700 previous-page" value="">Previous Page</option>'
                            );
                        }

                        $.each(data.collections, function(index, value) {
                            $('#collection_id').append(
                                `<option value="${value.id}">${value.name} (${value.numberOfProducts})</option>`
                            );
                        });

                        if (data.totalResults > offset + limit) {
                            $('#collection_id').append(
                                '<option class="dark:bg-slate-700 next-page" value="">Next Page</option>'
                            );
                        }

                        $('#collection_id').val('{{ $category->collection_id }}');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            //previous page
            $(document).on('click', '.previous-page', function() {
                offset = offset - limit;
                $('#collection_id').empty();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('wix.collection') }}',
                    data: {
                        limit: limit,
                        offset: offset
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.collections.length == 0) {
                            $('#collection_id').append(
                                '<option value="" class="dark:bg-slate-700" selected>No Collection Found</option>'
                            );
                            return;
                        }

                        if (offset > 0) {
                            $('#collection_id').append(
                                '<option class="dark:bg-slate-700 previous-page" value="">Previous Page</option>'
                            );
                        }
                        $.each(data.collections, function(index, value) {
                            $('#collection_id').append(
                                `<option value="${value.id}">${value.name} (${value.numberOfProducts})</option>`
                            );
                        });

                        if (data.totalResults > offset + limit) {
                            $('#collection_id').append(
                                '<option class="dark:bg-slate-700 next-page" value="">Next Page</option>'
                            );
                        }

                        $('#collection_id').val('{{ $category->collection_id }}');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            // set data
            $(document).on('change', '#collection_id', function() {
                const collection_id = $(this).val();
                const collection = collections.find(collection => collection.id == collection_id);
                console.log(collection);
                if (collection) {
                    $('#product_count').val(collection.numberOfProducts);
                    $('#name').val(collection.name);
                }
            });

            // Submit Form
            $('#category-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'post',
                    url: '{{ route('category.update', $category->id) }}',
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
                            window.location.href = '{{ route('category.index') }}';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-app-layout>
