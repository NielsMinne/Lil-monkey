<x-layout>
    <div class="relative md:w-full flex flex-col items-center">   
        <div class='absolute top-10 right-4 flex flex-col items-center'>
            <p class="hidden md:block">{{__('Export Excel')}}</p>
            <a href="{{route('export')}}"><i class="fa-3x text-pink-600 fa-solid fa-file-csv"></i></a>
        </div>
        <h1 class='font-semibold text-3xl mt-10 md:mt-20'>{{__("Purchased articles")}}</h1>
        <p class="mb-10 text-xl">{{__("Total price: ")}} <span class="font-bold">{{__('Euro')}} {{$totalPrice}}</span></p>
        <div class="grid md:grid-cols-2 gap-4 md:gap-8 mx-20 md:mt-20">
            @foreach($orders as $order)
                <div class='flex flex-col md:flex-row w-full justify-between bg-white rounded-lg p-8 border-2 mb-10 border-gray-300 shadow-md'>
                    <div class="md:w-48 w-full  md:border-r-2 border-gray-400 md:pr-4">
                        <div class='text-center'>
                            <h1 class="font-bold text-sm">{{__("Buyer")}}</h1>
                            <h2 class="font-semibold text-sm mb-2 md:mb-4">{{$order->name_buyer}}</h2>
                        </div>
                        <div class='text-center'>
                            <p class="font-bold text-sm">{{__("Message")}} </p>
                            <p class="text-sm">{{$order->message}}</p>
                        </div>
                    </div>
                    <div>
                        @foreach($purchasedProducts as $listProduct)
                            <x-purchased-products :babylist="$babylist" :listProduct="$listProduct" :order="$order"/>
                        @endforeach
                    </div>
                </div> 
                @endforeach           
        </div>
    </div>
    
</x-layout>