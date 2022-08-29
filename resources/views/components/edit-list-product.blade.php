@props(['listProduct','babylist','paidProducts'])

<form class="bg-white md:w-full px-4 mb-2 rounded-lg border-2 border-gray-400 @if(in_array($listProduct->id,$paidProducts)) border-red-300 opacity-50 @endif" method="POST" action="{{route('product.delete',$babylist->id)}}">
    @csrf
    <input type="hidden" name="productID" value="{{$listProduct->id}}">
    <div class='relative flex flex-col md:flex-row items-center w-full gap-4'>
        <img class="h-16 mt-4 md:mt-0" src="{{url('storage/' . $listProduct->image)}}" alt="{{$listProduct->title}}">
        <h4 class="w-full text-sm md:text-base text-center md:text-left text-md pl-4 ">{{$listProduct->title}}</h4>
        <h4 class="w-full md:w-1/3 text-md text-center pl-4 font-bold">{{__("Euro")}} {{$listProduct->price}}</h4>
        <h4 class="w-1/3 text-md text-center pl-4 font-bold">@if(in_array($listProduct->id,$paidProducts))  {{__('Bought')}} @else {{__('Available')}} @endif</h4> 
        <div class="w-1/3 flex items-center ml-10 text-md pl-4 pt-2">
            <button @if(in_array($listProduct->id,$paidProducts)) disabled @endif class="absolute bottom-0 right-0 bg-red-300 mb-2 py-2 px-4 rounded-lg" href="/my-list/{{$listProduct->id}}"><i class="fa-solid fa-trash-can"></i></button>
        </div>
    </div>
</form>