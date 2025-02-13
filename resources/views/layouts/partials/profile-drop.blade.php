 <!-- Profile DropDown Area -->
 <div class="md:block hidden w-full">
     <button
         class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center"
         type="button" data-bs-toggle="dropdown" aria-expanded="false">
         <span
             class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
             {{ Auth::user()->name }} </span>
         <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]"
             aria-hidden="true" fill="none" stroke="currentColor" viewbox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
             </path>
         </svg>
     </button>
     <!-- Dropdown menu -->
     <div
         class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden">
         <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
             <li>
                 <a href="{{ route('dashboard') }}"
                     class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text white font-normal">
                     <iconify-icon icon="heroicons-outline:user"
                         class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                     <span class="font-Inter">Dashboard</span>
                 </a>
             </li>
             <li>
                 <a href="{{ route('logout') }}"
                     class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                     <iconify-icon icon="heroicons-outline:login"
                         class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                     <span class="font-Inter">Logout</span>
                 </a>
             </li>
         </ul>
     </div>
 </div>
