<x-guest-layout>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="bg-white rounded-lg mx-4 p-8 flex ">
            <img class="w-24" src="{{asset('../images/baby-logo.png')}}" alt="">
            <div class="pl-8 flex flex-col items-center">
                <h1 class="text-sm text-center md:text-left md:text-base font-bold mb-2">{{__('Order received')}}</h1>
                <h1 class=" text-sm text-center md:text-left md:text-base mb-4">{{__("Thank you message")}}</h1>
                <a class="px-4 py-2 bg-pink-300 text-white hover:bg-pink-500 rounded-lg" href="/">{{__('Go back')}}</a>
            </div>
        </div>
    </div>
</x-guest-layout>