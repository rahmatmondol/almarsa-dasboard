 <!-- Notifications Dropdown area -->
 <div class="relative md:block hidden">
     <button
         class="lg:h-[32px] lg:w-[32px] lg:bg-slate-100 lg:dark:bg-slate-900 dark:text-white text-slate-900 cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center"
         type="button" data-bs-toggle="dropdown" aria-expanded="false">
         <iconify-icon id="notification_alert" class="text-slate-800 dark:text-white text-xl"
             icon="heroicons-outline:bell"></iconify-icon>
         <span id="notification_count" style="visibility: hidden"
             class="absolute -right-1 lg:top-0 -top-[6px] h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center justify-center rounded-full text-white z-[99]"></span>
     </button>
     <!-- Notifications Dropdown -->
     <div
         class="dropdown-menu z-10 hidden bg-white shadow w-[335px] dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden lrt:origin-top-right rtl:origin-top-left">
         <div class="flex items-center justify-between py-4 px-4">
             <h3 class="text-sm font-Inter font-medium text-slate-700 dark:text-white">
                 Notifications</h3>
         </div>
         <div class="widget-recently"></div>
     </div>
 </div>
 <!-- END: Notification Dropdown -->
 <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/dayjs/plugin/relativeTime.js"></script>

 <script>
     // Function to read data


     function readData() {
         const user_id = '<?php echo auth()->user()->id; ?>'
         database.ref(`notifications/admin`).on('value', (snapshot) => {
             const data = snapshot.val();
             let notifications = '';
             let count = '';
             if (data) {
                 Object.entries(data).forEach(([key, value]) => {
                     if (value.read_at == false) {
                         dayjs.extend(dayjs_plugin_relativeTime);

                         let timeAgo = dayjs(value.created_at).fromNow();
                         count++;
                         notifications += `<div class="text-slate-600 dark:text-slate-300 block w-full px-4 py-2 text-sm">
                            <div class="flex ltr:text-left rtl:text-right relative">
                                <div class="flex-none ltr:mr-3 rtl:ml-3">
                                    <div class="h-8 w-8 bg-white rounded-full">
                                        <img src="${value.data.avatar || '/assets/images/avatar/av-1.svg'}" alt="user"
                                            class="border-transparent block w-full h-full object-cover rounded-full border">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <a href="notification-delete/?key=${key}&url=${value.data.url}"
                                        class="text-slate-600 dark:text-slate-300 text-sm font-medium mb-1 before:w-full before:h-full before:absolute  before:top-0 before:left-0">
                                        ${value.data.name}
                                        </a>
                                    <div class="text-slate-600 dark:text-slate-300 text-xs leading-4">
                                        ${value.data.message}
                                    </div>
                                    <div class="text-slate-400 dark:text-slate-400 text-xs mt-1">
                                        ${timeAgo}
                                    </div>
                                </div>
                            </div>
                        </div>
                        `
                     }
                 });
             }
             if (count == 0) {
                 $('#notification_count').text(count).css('visibility', 'hidden');
                 $('#notification_alert').removeClass('animate-tada');
             } else {
                 $('#notification_count').text(count).css('visibility', 'visible');
                 $('#notification_alert').addClass('animate-tada');
             }
             $('.widget-recently').html('');
             $('.widget-recently').html(notifications);

         }).catch((error) => {
             console.error('Error reading data: ' + error);
         });
     }
     readData()
 </script>
