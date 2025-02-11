 <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
     id="sidebar_menus">
     <ul class="sidebar-menu">
         {{-- <li class="sidebar-menu-title">MENU</li> --}}
         <li>
             <a href="{{ route('dashboard') }}" class="navItem {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                 <span class="flex items-center">
                     <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                     <span>Dashboard</span>
                 </span>
             </a>
         </li>

         <li class="sidebar-menu-title">Orders Management</li>
         <li>
             <a href="{{ route('order.list') }}" class="navItem {{ request()->routeIs('order.list') ? 'active' : '' }}">
                 <span class="flex items-center">
                     <iconify-icon class=" nav-icon" icon="heroicons-outline:document"></iconify-icon>
                     <span>Orders</span>
                 </span>
             </a>
         </li>

         <li class="sidebar-menu-title">Category Management</li>
         <li>
             <a href="javascript:void(0)" class="navItem">
                 <span class="flex items-center">
                     <iconify-icon class=" nav-icon" icon="heroicons-outline:document"></iconify-icon>
                     <span>Categories</span>
                 </span>
                 <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
             </a>
             <ul class="sidebar-submenu">
                 <li>
                     <a href="{{ route('category.create') }}">Add Category</a>
                 </li>
                 <li>
                     <a href="{{ route('category.index') }}">Category List</a>
                 </li>
             </ul>
         </li>

     </ul>

 </div>
