<x-guest-layout>
    <div class="h-screen h-full px-8 md:w-1/3 mx-auto flex flex-col justify-center">
        <div class="bg-white mb-10 rounded-lg border-2 border-gray-300 shadow-md p-8">
            <img class="h-16 md:h-24 mx-auto mb-6" src="{{asset('../images/baby-logo.png')}}" alt="">
            <h1 class="text-center text-gray-700 md:text-lg font-semibold">{{__('Welcome to the list of ')}}</h1>
            <h1 class="text-center md:text-lg font-bold mb-2 ">{{str_replace("_"," ",$babylist->name_child)}}</h1>
            <p class="text-sm md:text-base text-center pt-4 mb-8">{{$babylist->message}}</p>
            <p class="text-center pt-4 mb-4">{{__('Enter Password')}}</p>
            <div class="w-full flex justify-center mb-4">
                @include('flash-message')
            </div>
            <form method="POST" action="{{route('list.guest.enter', array($babylist->name_child, $babylist->user_id))}}">
                @csrf
                <div class="flex flex-col px-8 md:w-1/3 md:px-0 items-center mx-auto">
                <input class="rounded-md w-full" type="password" name="password">
                <button type="submit" class="mt-4 py-2 rounded-lg bg-blue-300 w-full">{{__('Enter')}}</button>
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>