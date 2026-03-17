<div class="hs-tooltip">
    <button type="submit" class="btn rounded-full  bg-primary text-white gap-3">
        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
        <span class="ml-2">
@if($id) {{ __('Update') }} @else {{ __('Save') }}@endif
        </span><!-- ml-2 -->
    </button><!-- btn rounded-full  bg-primary text-white gap-3-->

    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
             <span>@if($id) {{ __('Update') }} @else {{ __('Save') }}@endif </span>
   </span><!-- hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm-->
</div>
