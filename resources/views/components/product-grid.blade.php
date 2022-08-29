@props(['products'])

<div class='grid grid-cols-2 mx-10 gap-2 md:ml-40 md:grid-cols-4 '>
    @foreach ($products as $product) 
        <article class='flex flex-col items-center bg-white p-4 rounded-lg border-2 border-gray-100'>
        <img src="{{url('storage/' . $product->image)}}" alt="{{$product->title}}" class="h-24 my-4">
        <small class="text-xs mb-2">{{$product->EAN_code}}</small>
        <div class="h-full flex flex-col items-center justify-between">
            <h5 class="text-xs md:text-base text-center mb-4 font-semibold"> {{$product->title}}</h5>
            <p class="font-bold">€ {{$product->price}}</p>
        </div>
        </article>  
    @endforeach
</div>
