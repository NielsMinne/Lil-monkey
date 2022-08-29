<x-guest-layout>
    <div class="flex w-full md:justify-between justify-center">
        <div class="guest-products md:mr-40 md:px-20 flex flex-col">
            <div class="w-full flex justify-center mt-20 mb-4">
            <img class="w-24" src="{{asset('../images/baby-logo.png')}}" alt="">
            </div>
            <h1 class="text-center text-gray-700 md:text-lg font-semibold">{{__('Welcome to the list of ')}}</h1>
            <h1 class="text-center md:text-lg font-bold mb-2 ">{{str_replace("_"," ",$babylist->name_child)}}</h1>
            <p class="text-center pt-10 mb-20">{{$babylist->message}}</p>

            <div class="grid md:grid-cols-3 gap-4 mb-10">
                @foreach($productsInList as $listProduct)
                <x-guest-list-product :babylist="$babylist" :listProduct="$listProduct" :paidProducts="$paidProducts" />
                @endforeach
            </div>
        </div>

        <div class="hidden shop-cart fixed right-0 h-full bg-white md:flex flex-col shadow-lg">
            <form class="relative h-full flex flex-col mt-10" action="{{route('checkout')}}" method="GET">
                <h1 class="text-xl font-semibold text-center">{{__("Shopping cart")}}</h1>
                <h2 class="text-center mb-4">{{__("Total price: ")}} <span class="font-bold">{{__("Euro")}} {{$cart->getTotal()}}</span></h2>
                <div class="w-full px-8">
                    @foreach ($cart->getContent() as $item)
                        @if(!$item)
                        <p>No items in cart yet...</p>
                        @else
                        <p class="text-xs md:text-sm mt-2">{{$item->name}}</p>
                        <p class='font-bold'>{{__('Euro')}} {{$item->price}}</p>
                        <input type="hidden" name="productID[]" value="{{$item->id}}">
                        @endif
                    @endforeach
                </div>
                <input type="hidden" name="list_id" value="{{$babylist->id}}">
                <div class="md:absolute bottom-20 w-full px-8 mt-8">
                    <h1 class="font-semibold text-lg text-center mb-2">{{__("Information")}}</h1>
                    <input class="w-full mb-4" required type="text" name="name" placeholder="{{__("placeholder.Name")}}">
                    <input class="w-full mb-4" type="email" name="email" placeholder="{{__('placeholder.Email')}}">
                    <textarea class="w-full mb-4 h-36" name="message" id="message" cols="30" rows="10" placeholder="{{__("placeholder.Message")}}"></textarea>
                </div>
                <button type="submit" class="w-full font-bold h-14 bg-orange-300 absolute bottom-10 md:bottom-0 hover:bg-yellow-500">
                    {{__("Pay")}} <i class="ml-2 fa-solid fa-basket-shopping"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="shop md:hidden fixed top-8 right-2">
        <i class="icon px-2 relative fa-2xl fa-solid fa-basket-shopping"><span class="count text-white @if(count($cart->getContent())) animate-pulse @endif z-20 rounded-lg px-2 bg-pink-500 absolute text-xs font-base bottom-0 left-0">{{count($cart->getContent())}}</span></i>
    </div>

    <div class='z-20 fixed w-60 bottom-20 right-20 mr-10 flex justify-center'>
        @include('flash-message')
    </div>


    <script>
        const shop = document.querySelector(".icon");
        const shopMenu = document.querySelector('.shop-cart');
        const count = document.querySelector('.count');

        shop.addEventListener("click", () => {
            shopMenu.classList.toggle("hidden");
            if(shop.className === "icon px-2 relative fa-2xl fa-solid fa-basket-shopping"){
            // shopMenu.className = "md:hidden shop-cart fixed right-0 h-full bg-white md:flex flex-col shadow-lg";
            count.classList.toggle("hidden");
            shop.className = "icon fa-2xl px-2 fa-solid fa-xmark";
            }
            else{
                // btnNav.className = "md:hidden shop-cart fixed right-0 h-full bg-white md:flex flex-col shadow-lg";
                shop.className = "icon px-2 relative fa-2xl fa-solid fa-basket-shopping";
                count.className = "count animate-pulse text-white z-20 rounded-lg px-2 bg-pink-500 absolute text-xs font-base bottom-0 left-0";
            }
        });
    </script>
   
</x-guest-layout>
