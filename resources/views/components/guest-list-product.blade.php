@props(['listProduct','babylist','paidProducts'])

<form class="relative w-full bg-white p-4 rounded-lg border-2 border-green-300 @if(in_array($listProduct->id,$paidProducts)) border-orange-100 opacity-50 @endif" method="POST" action="{{route('list.guest.addCart', array($babylist->name_child, $babylist->user_id))}}">
    @csrf
    <input type="hidden" name="productID" value="{{$listProduct->id}}">
    <div class='h-full relative flex flex-col h-44 justify-center items-center'>
        <img class="h-16 md:mt-0" src="{{url('storage/' . $listProduct->image)}}" alt="{{$listProduct->title}}">
        <h4 class="w-full text-xs text-center font-bold text-md  ">{{$listProduct->shop->name}}</h4>
        <h4 class="w-full text-xs text-center font-semibold text-md mb-2 ">{{$listProduct->EAN_code}}</h4>
        <h4 class="w-full text-sm md:text-base text-center text-md  ">{{$listProduct->title}}</h4>
        <h4 class="w-1/3 text-md text-center  font-bold">€ {{$listProduct->price}}</h4>
    </div>
    <button @if(in_array($listProduct->id,$paidProducts)) disabled @endif class="absolute bottom-0 right-2 bg-orange-300 mb-2 py-2 px-4 rounded-lg 
        @if(in_array($listProduct->id,$paidProducts))
        opacity-40 
        @endif
        " href="/my-list/{{$listProduct->id}}"><i class="text-orange-900 fa-solid fa-cart-plus"></i></button>
</form>

