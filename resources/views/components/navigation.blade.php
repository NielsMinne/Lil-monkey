<nav class="z-40 sticky top-0 h-20 bg-white shadow-md">
    <div class="w-11/12 mx-auto px-4">

            <div class=" flex space-x-10">
                <div>
                    <!-- Website Logo -->
                    <a href="/" class="flex items-center py-6 px-2 w-40">
                        <img src="{{url('images/baby-logo.png')}}" alt="Logo" class="h-8 w-8 mr-2">
                        <span class="font-bold text-pink-500 text-lg">{{__('navigation.organizationName')}}</span>
                    </a>
                </div>
                 @guest
                <div class="hidden md:flex items-center space-x-1">
                    <a href="/" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Home')}}</a>
                    <a href="{{route('products')}}" class="py-4 px-2 text-gray-500 font-semibold transition duration-300">{{__('navigation.Articles')}}</a>
                </div>
                @endguest
                <!-- Primary Navbar items -->
                @if(auth()->check())
                    @if(auth()->user()->isAdmin == 0)
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Home')}}</a>
                        <a href="{{route('products')}}" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Articles')}}</a>
                        <a href="{{route('list.user')}}" class="w-28 py-4 px-2 text-center text-gray-500 font-semibold ">{{__('navigation.MyLists')}}</a>
                        <a href="{{route('list.create')}}" class="w-40 py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.MakeAList')}}</a>

                    </div>
                        <div class='flex w-5/6 items-center justify-end'>
                        <h2 class='hidden md:flex items-center space-x-1'>{{__('Welcome,')}} <span class="ml-2 font-bold ">{{auth()->user()->name}}</span></h2>
                        <form class="hidden px-4 py-4 sm:block" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
                @endif
            @endif
            @if (auth()->check())
                @if(auth()->user()->isAdmin)
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Home')}}</a>
                        <a href="{{route('products')}}" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Articles')}}</a>
                        <a href="{{route('scrape.categories.show')}}" class="py-4 px-2 text-gray-500 font-semibold ">{{__('Categories')}}</a>
                        <a href="{{route('scrape')}}" class="py-4 px-2 text-gray-500 font-semibold ">{{__('navigation.Scraper')}}</a>

                    </div>
                        <div class='flex w-5/6 items-center justify-end'>
                        <h2 class='hidden md:flex items-center space-x-1'>{{__('Welcome,')}} <span class="font-bold text-lg">{{auth()->user()->name}}</span></h2>
                        <form class="hidden px-4 py-4 sm:block" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                @endif
            @endif
            <!-- Secondary Navbar items -->
            @guest
            <div class="hidden fixed top-4 right-12 md:flex items-center space-x-3 ">
                <a href="{{route('login')}}" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-blue-100 hover:text-black transition duration-300">{{__('Login')}}</a>
                <a href="{{ route('register') }}" class="py-2 px-2 font-medium text-white bg-pink-300 rounded hover:bg-pink-500 transition duration-300">{{__('Register')}}</a>
            </div>
            @endguest
            <!-- Mobile menu button -->
            <div class="md:hidden fixed top-6 right-6 flex items-center">
                <button class="outline-none mobile-menu-button">
                    <div class="space-y-2">
                        <span class="block w-6 h-0.5 bg-gray-600"></span>
                        <span class="block w-6 h-0.5 bg-gray-600"></span>
                        <span class="block w-4 h-0.5 bg-gray-600"></span>
                      </div>
            </button>
            </div>

    </div>

    <!-- mobile menu -->

    <div class="hidden fixed left-0 w-full bg-white mobile-menu shadow-md">
        <ul class="">
            @guest
            <li><a href="/" class="block text-sm px-2 py-4">{{__('navigation.Home')}}</a></li>
            <li><a href="{{route('products')}}" class="block text-sm px-2 py-4">{{__('navigation.Articles')}}</a></li>
            <li><a href="{{route('login')}}" class="block text-sm px-2 py-4 ">{{__('navigation.Login')}}</a></li>
            <li><a href="{{route('register')}}" class="block text-sm px-2 py-4 ">{{__('navigation.Register')}}</a></li>
            @endguest

            @if (auth()->check())
                @if(auth()->user()->isAdmin)
                <li><a href="/" class="block text-sm px-2 py-4 ">{{__('navigation.Home')}}</a></li>
                <li><a href="{{route('products')}}" class="block text-sm px-2 py-4 ">{{__('navigation.Articles')}}</a></li>
                <li><a href="{{route('scrape.categories.show')}}" class="block text-sm px-2 py-4 ">{{__('Categories')}}</a></li>
                <li><a href="{{route('scrape')}}" class="block text-sm px-2 py-4 ">{{__('navigation.Scraper')}}</a></li>
                <li class="block text-sm py-2 ">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
                @elseif(auth()->user()->isAdmin == 0)
                <li class="active"><a href="#" class="block text-sm px-2 py-4">{{__('navigation.Home')}}</a></li>
                <li><a href="{{route('products')}}" class="block text-sm px-2 py-4 ">{{__('navigation.Articles')}}</a></li>
                <li><a href="{{route('list.user')}}" class="block text-sm px-2 py-4 ">{{__('navigation.MyLists')}}</a></li>
                <li><a href="{{route('list.create')}}" class="block text-sm px-2 py-4 ">{{__('navigation.MakeAList')}}</a></li>
                <li class="block text-sm py-2 ">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
                @endif
            @endif
                {{-- <form class="hidden fixed top-0 right-0 px-4 py-4 sm:block" method="POST" action="{{ route('logout') }}">
                    @csrf
                   <a href="#">Logout</a>
                </form> --}}
            </li>
        </ul>
    </div>
    <script>
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</nav>
