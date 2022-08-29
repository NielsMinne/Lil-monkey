@props(['listProduct','babylist','order'])

@if(in_array($listProduct->id, unserialize($order->products)))
    <div class="w-full px-4 mt-6 md:mt-0 mb-2">
        <div class='relative flex flex-row justify-between items-center w-full '>
            <img class="h-8 md:h-16 md:mt-4 md:mt-0" src="{{url('storage/' . $listProduct->image)}}" alt="{{$listProduct->title}}">
            <h4 class="w-2/3 text-xs md:text-sm md:text-base text-center md:text-left text-md pl-4 ">{{$listProduct->title}}</h4>
            <h4 class="w-28 text-md text-center  pl-4 font-bold">{{__("Euro")}} {{$listProduct->price}}</h4>
        </div>
    </div>
@endif

