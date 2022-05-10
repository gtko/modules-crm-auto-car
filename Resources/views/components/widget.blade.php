<div {{ $attributes->class(['report-box zoom-in']) }}>
    <div class="box p-2 sm:p-3 xl:p-5 text-center">
        <div class="text-base sm:text-2xl xl:text-3xl whitespace-nowrap font-medium">{!! $slot !!}</div>
        <div class="text-xs sm:text-base text-gray-600 mt-1">{!! $title !!}</div>
    </div>
</div>
