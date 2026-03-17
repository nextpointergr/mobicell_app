@if (session()->has('success'))
    <div   x-data="{ show: true }"
               x-init="setTimeout(() => show = false, 1000)"
               x-show="show" id="dismiss-alert" class="hs-removing:translate-x-5
               hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 rounded-md p-4 mb-5 mt-5"
           role="alert">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <i class="ti ti-circle-check text-xl"></i>
                </div><!-- flex-shrink-0-->
                <div class="flex-grow">
                    <div class="text-sm text-teal-800 font-medium">
                        {{ session('success') }}
                    </div>
                </div><!-- flex-grow-->
                <button data-hs-remove-element="#dismiss-alert" type="button"
                        id="dismiss-test"
                        class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                    <i class="ti ti-x text-xl"></i>
                </button><!-- ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center-->
            </div><!-- flex items-center gap-3-->
    </div><!-- hs-removing:translate-x-5
               hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 rounded-md p-4-->
@endif
