@props(['products','category','babylist'])

@foreach($products->where('category.title',$category) as $product)
    <form method="POST" action="{{route('product.addList',$babylist->id)}}">
        @csrf
        <input type="hidden" name="productID" value="{{$product->id}}">
        <article class='relative flex h-44 md:h-44 items-center bg-white p-4 rounded-lg border-2 border-gray-200'>
        <img src="{{url('storage/' . $product->image)}}" alt="{{$product->title}}" class="h-24">
        <div class="ml-4 mr-2 md:mx-6 flex flex-col justify-between">
            <h1 class="font-bold text-xs ">{{ $product->shop->name}}</h1>
            <p class=" font-semibold text-xs mb-2">{{__('CODE: ') . $product->EAN_code}}</p>
            <div class="flex flex-col justify-between">
                <h5 class="mb-4"> {{$product->title}}</h5>
                <button type="submit" class="absolute bottom-2 right-2 bg-green-200 rounded-lg py-2 px-4" href=""><i class="fa-solid fa-plus"></i></button>
                <p class="w-40 font-bold">€ {{$product->price}}</p>
            </div>
        </div>
        </article>
    </form>
@endforeach
