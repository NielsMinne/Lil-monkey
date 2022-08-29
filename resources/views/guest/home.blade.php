<x-layout>
    <div class="h-screen">
        <div class="hero relative md:h-5/6">
            <div class="hidden md:block w--full h-full flex flex-col justify-center"></div>
            <div class=" md:absolute md:w-2/3 md:left-60 md:top-32 flex flex-col md:items-start items-center">
                <img class="md:hidden mt-10 mb-6 md:mt-0 md:mb-0 md:absolute md:top-20 md:right-40" src="{{asset('images/asset-1.png')}}" alt="">
                <h1 class="md:text-5xl text-pink-800 font-bold">{{__('home.intro_text')}}</h1>
                <h2 class="mb-4 md:mt-4 md:text-3xl text-gray-600 ">{{__('home.intro_subtext')}}</h2>
                <h2 class="md:mt-16 text-center md:text-left mb-8 md:text-xl text-gray-600 ">{{__('home.intro_smalltext')}}</h2>
                <div class="mb-20 flex justify-center">
                    @if(auth()->user())
                        <a class="md:py-4 px-2 py-4 md:px-8 font-bold text-sm md:text-lg shadow-md shadow-pink-300 text-white bg-pink-400 rounded hover:bg-pink-500 transition duration-300" href="{{route('list.create')}}">{{__('buttons.Make a list')}}</a>
                        <a class="ml-4 px-2 py-4 md:py-4 md:px-8 font-bold text-sm md:text-lg text-pink-400 shadow-md shadow-pink-300 border-2 border-pink-400 rounded hover:bg-pink-500 hover:text-white transition duration-300" href="{{route('list.user')}}">{{__('buttons.View ur lists')}}</a>
                    @else
                        <a class="md:py-4 px-2 py-4 md:px-8 font-bold text-sm md:text-lg shadow-md shadow-pink-300 text-white bg-pink-400 rounded hover:bg-pink-500 transition duration-300" href="{{route('register')}}">{{__('home.Create account')}}</a>
                        <a class="ml-4 px-2 py-4 md:py-4 md:px-8 font-bold text-sm md:text-lg text-pink-400 shadow-md shadow-pink-300 border-2 border-pink-400 rounded hover:bg-pink-500 hover:text-white transition duration-300" href="{{route('login')}}">{{__("home.login")}}</a>
                    @endif
                </div>
            </div>
            <svg class=" md:block absolute bottom-0 curves__bowed--bottom__3BS6Q" viewBox="0 0 1632 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="m0 4423.20703c226.015625 115.91406 542.398437 167.99479 949.148437 156.24219 315.351563-12.4349 542.968753-38.20478 682.851563-77.30966v80.86044h-1632z" fill="#ffffff" fill-rule="evenodd" transform="translate(0 -4423)"></path></svg>
        </div>
        
        
        <div class="relative h-2/3 mb-10 w-full bg-white flex flex-col items-center md:justify-center">
            <img class="asset md:absolute md:left-40 md:top-0" src="{{asset('images/asset-2.png')}}" alt="">
            <div class="subject w-full md:absolute md:right-80 md:top-40">
                <h1 class="md:text-4xl text-xl text-center text-blue-300 font-bold">{{__('home.subject_text')}}</h1>
                <h1 class="md:text-4xl text-xl text-center text-blue-300 font-bold">{{__('home.subject_text2')}}</h1>
                <h2 class="mt-4 text-xl text-center md:text-2xl text-gray-600 ">{{__('home.subject_subtext')}}</h2>
                <h2 class="mt-10 text-base text-center mb-8 md:text-xl text-gray-600 ">{{__('home.subject_smalltext')}}</h2>
                <h2 class="mt-4 pb-8 text-base text-center mb-8 text-base text-gray-600 ">{{__('home.subject_smalltext2')}}</h2>
            </div>
        </div>
        
        <img class="asset-1 hidden mt-0 mb-0 md:block md:absolute top-20 right-40" src="{{asset('images/asset-1.png')}}" alt="">
    </div> 
</x-layout>