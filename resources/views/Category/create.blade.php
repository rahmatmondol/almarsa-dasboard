<x-app-layout>
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4
            class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
            Create Category</h4>

    </div>
    
    <form method="POST" action="/category/store" id="category-form">
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
                                placeholder="Category Name">
                        </div>
                        <div class="input-area">
                            <label for="description" class="form-label">Category Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description"></textarea>
                        </div>
                        <div class="input-area">
                            <label for="select" class="form-label">Parent Category</label>
                            <select id="select" name="parent_id" class="form-control">
                                <option value="" class="dark:bg-slate-700" selected>Root</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-area">
                            <label for="image" class="form-label">Category Image</label>
                            <input id="image" name="image" type="file" class="form-control"
                                onchange="previewImage(event)">
                            <div class="mt-4 relative">
                                <img id="image-preview" style="max-width: 100%; display: none;">
                                <button type="button" style="display: none;"
                                    class="delete-image-btn delete-image-btn btn-danger p-1 rounded-full text-white absolute top-0 right-0"
                                    onclick="deleteImage()">x</button>
                            </div>
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
                            <label for="collection_id" class="form-label">Select Wix Collection</label>
                            <select id="collection_id" name="collection_id" class="form-control">
                                <option value="" class="dark:bg-slate-700" selected>Select Collection</option>
                            </select>
                        </div>

                        <div class="input-area">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="active" class="dark:bg-slate-700">Active</option>
                                <option value="inactive" class="dark:bg-slate-700">Inactive</option>
                            </select>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-primary">Save</button>
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
            $('#image').val('');
            $('.delete-image-btn').hide();
        }

        $(document).ready(function() {

            let limit = 100;
            let offset = 0;

            //get wix collections
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
                            '<option value="" style="background: #32bcff;" selected>No Collection Found</option>'
                        );
                        return;
                    }

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
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


            // Submit Form
            $('#category-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('category.store') }}',
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
                            $('#category-form')[0].reset();
                            deleteImage();
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
        });
    </script>
</x-app-layout>
