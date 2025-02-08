 <!-- BEGIN: Sidebar -->
 <div class="sidebar-wrapper group">
     <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
     </div>

    @include('layouts.partials.logo')

     <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none opacity-0">
     </div>

    @include('layouts.partials.sidebar-menu')
 </div>
 <!-- End: Sidebar -->
