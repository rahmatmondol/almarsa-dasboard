<x-app-layout>
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4
            class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
            About page setting</h4>

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
                            <input id="title" name="title" type="text" value=""
                                class="form-control" placeholder="title">
                        </div>
                        <div class="input-area">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</x-app-layout>
