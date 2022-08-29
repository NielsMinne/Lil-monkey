
<div class="min-h-screen flex flex-col px-6 justify-center items-center pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
        {{ $slot }}
    </div>

    <div class="md:hidden mt-10 absolute bottom-4 left-8">
        <a class="text-lg text-gray-700" href="/"><i class="fa-solid fa-circle-chevron-left ml-2"></i> {{__('Go back')}}</a>
    </div>
</div>

