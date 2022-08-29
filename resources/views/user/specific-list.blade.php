<x-layout>
    <div class="px-4 flex">
        <div class="hidden md:block md:h-full md:w-72"></div>

        <div class="sideNav overflow-y-scroll pb-28 mobile-menu-side hidden md:block fixed shadow-md shadow-gray-300 top-20 left-0 h-screen w-60 md:w-64 bg-white z-10">
            <h1 class="font-bold border-b-2 border-gray-300 text-lg pl-12 pb-6 pt-4">{{__('Categories')}}</h1>
            <div class="categories flex flex-col">
                @foreach($products->pluck('category.title')->unique()->sort() as $category)
                    <a class="text-sm  border-b-2 border-gray-100 px-12 py-2 hover:font-semibold hover:border-red-200 {{$category}}" href="#{{$category}}">{{$category}}</a>
                @endforeach
            </div>
        </div>

        <div class="w-full">
            <h1 class="text-center mt-20 text-2xl font-bold">{{$babylist->name_list}}</h1>
            <h2 class="text-center mt-2 text-lg font-semibold">{{__('guestUrl')}} {{url("/") . $babylist->url}}</h2>
            <h3 class="text-center mt-2 text-lg ">{{__('guestPassword')}} {{$babylist->password}}</h3>
            <div class="my-10">
                @if(!$babylist->products)
                <div class='flex justify-center w-full'>
                    <p class="text-center text-2xl p-2 text-red-300 ">{{__('There are no products yet')}}</p>
                </div>
                @elseif($babylist->products)
                <div class='flex justify-center w-full'>
                    <a class="text-xs font-semibold md:text-base md:font-normal text-center border-2 border-orange-200 rounded-lg mr-2 py-4 px-2 md:p-4" href="{{route('list.detail',$babylist->id)}}">{{__('buttons.View and edit list')}}</a>
                    <a class="text-xs font-semibold md:text-base md:font-normal text-center bg-orange-200 rounded-lg py-4 px-2 md:p-4" href="{{route('list.purchased',$babylist->id)}}">{{__('buttons.View bought items')}}</a>
                </div>
                @endif    
            </div>


            <h1 class='text-center my-10 font-bold'>{{__('Add products to your list')}}</h1>
            <div class="md:hidden flex flex-col items-end">
                <p class='mr-2'>{{__("sortBy")}}</p>
                <div class="flex justify-end top-24 right-2">
                    <div>
                        <a href="{{route('list.sortedByName',$babylist->id)}}" class="md:hidden flex items-center z-20 h-10 p-2 bg-white rounded-lg border-2"><i class="fa-2xl fa-solid fa-arrow-down-a-z"></i></a>
                        <p class="ml-2 text-xs">{{__("Name")}}</p>
                    </div>
                    <div>
                        <a href="{{route('list.sortedByPrice',$babylist->id)}}" class="md:hidden flex items-center z-20 h-10 p-2 bg-white rounded-lg border-2"><i class="fa-2xl fa-solid fa-arrow-down-1-9"></i></a>
                        <p class="ml-4 text-xs">{{__("Price")}}</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                @foreach($categories as $category)
                    <h1 class="text-center font-semibold text-lg py-10" id='{{$category}}'>{{$category}}</h1>
                    <div class='grid grid-cols-1 md:grid-cols-3 md:mx-20 gap-2 md:gap-4'>
                        <x-product-card :babylist="$babylist" :products="$products" :category="$category"/>
                    </div>
                @endforeach
                <div class="hidden md:block absolute top-10 right-24">
                    <a class='font-bold underline underline-offset-2 hover:text-blue-700' href="{{route('list.sortedByPrice',$babylist->id)}}">Sorteer op prijs</a>
                    <a class='font-bold pl-4 underline underline-offset-2 hover:text-pink-700' href="{{route('list.sortedByName',$babylist->id)}}">Sorteer op naam</a>
                </div>
            </div>
        
        </div>
    </div>

        <button class="md:hidden fixed top-24 left-4 flex items-center z-20 outline-none mobile-menu-button-side h-10 p-2 bg-white rounded-lg border-2">
                <i class="icon fa-2xl fa-solid fa-list"></i>
        </button>

       
    
    <script>
        const btnNav = document.querySelector("button.mobile-menu-button-side");
        const menuNav = document.querySelector(".mobile-menu-side");
        const icon = document.querySelector(".icon");

        btnNav.addEventListener("click", () => {
            menuNav.classList.toggle("hidden");
            if(icon.className === "icon fa-2xl fa-solid fa-list"){
            btnNav.className = "md:hidden fixed top-28 left-48 flex items-center z-20 outline-none mobile-menu-button-side";
            icon.className = "icon fa-2xl fa-solid fa-xmark";
            }
            else{
                btnNav.className = "md:hidden fixed top-24 left-4 flex items-center z-20 outline-none mobile-menu-button-side h-10 p-2 bg-white rounded-lg border-2";
                icon.className = "icon fa-2xl fa-solid fa-list";
            }
        });

        const navItems = document.querySelector('.categories').children;
                for(let i = 0 ; i < navItems.length ; i++){
                    navItems[i].addEventListener('click',()=> {
                        menuNav.classList.toggle("hidden");
                        btnNav.className = "md:hidden fixed top-24 left-4 flex items-center z-20 outline-none mobile-menu-button-side h-10 p-2 bg-white rounded-lg border-2";
                        icon.className = "icon fa-2xl fa-solid fa-list";
                    })
                }
    </script>
</x-layout>