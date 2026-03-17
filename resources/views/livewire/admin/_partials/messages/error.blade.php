@if (session()->has('error'))
    <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            id="dismiss-alert"
            class="hs-removing:translate-x-5 mt-5 mb-5 hs-removing:opacity-0 transition duration-300 bg-danger/25 text-danger text-sm rounded-md p-4 w-full mb-5"
            role="alert"
    >
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 text-red-600">
                    <i class="ti ti-alert-circle text-xl"></i>
                </div><!-- flex-shrink-0 text-red-600-->
                <div class="flex-grow">
                    <div class="text-sm text-red-800 font-medium">
                        {{ session('error') }}
                    </div><!-- text-sm text-red-800 font-medium-->
                </div><!-- flex-grow-->
                <button
                    type="button"
                    @click="show = false"
                    class="ms-auto h-8 w-8 rounded-full bg-red-100 hover:bg-red-200 transition flex justify-center items-center">
                    <i class="ti ti-x text-xl text-red-600"></i>
                </button><!-- ms-auto h-8 w-8 rounded-full bg-red-100 hover:bg-red-200 transition flex justify-center items-center-->
            </div><!-- flex items-center gap-3-->
    </div><!--- hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-danger/25 text-danger text-sm rounded-md p-4 w-full mb-5-->
@endif
