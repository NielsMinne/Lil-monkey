<x-layout>

    <div class="mobile-menu-side hidden md:block fixed shadow-md shadow-gray-300 top-20 h-full w-60 bg-white z-10">
        <h1 class="font-bold border-b-2 border-gray-300 text-lg pl-12 pb-6 pt-4">{{__('Shops')}}</h1>
        <div class="shops flex flex-col">
            @foreach($products->pluck('category.shop.name')->unique() as $shop)
                <a class="border-b-2 border-gray-100 px-12 py-2 hover:font-semibold hover:border-red-200" href="#{{$shop}}">{{$shop}}</a>
            @endforeach
        </div>
    </div>

    <div class="md:w-5/6 md:ml-44 my-10">
        @foreach ($products->pluck('category.shop.name')->unique() as $shop)
            <h1 id="{{$shop}}" class='text-center md:ml-40 pb-20 text-4xl mt-20'>{{$shop}}</h1>
            <x-product-grid :products="$products->where('category.shop.name',$shop)"/>
        @endforeach  
    </div>

    
    <button class="md:hidden fixed top-28 left-6 flex items-center z-20 outline-none mobile-menu-button-side"><i class="icon fa-2xl fa-solid fa-list"></i></button>

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
                btnNav.className = "md:hidden fixed top-28 left-6 flex items-center z-20 outline-none mobile-menu-button-side";
                icon.className = "icon fa-2xl fa-solid fa-list";
            }
        });

        const navItems = document.querySelector('.shops').children;
        for(let i = 0 ; i < navItems.length ; i++){
            navItems[i].addEventListener('click',()=> {
                menuNav.classList.toggle("hidden");
                btnNav.className = "md:hidden fixed top-28 left-6 flex items-center z-20 outline-none mobile-menu-button-side";
                icon.className = "icon fa-2xl fa-solid fa-list";
            })
        }

    </script>
</x-layout>
