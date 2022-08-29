<x-layout>
    <div class=' md:mx-auto flex flex-col md:justify-center md:flex-row md:gap-28'>
        <div class="md:w-1/3">
            <h1 class='text-center font-semibold text-lg mt-5 md:my-10'>{{__("Edit list")}}</h1>
            <form class=" flex flex-col h-full mb-6 px-8 " action="{{route('list.edit',$babylist->id)}}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                @foreach($listTables as $listTable)
                    @if(in_array($listTable,['name_child']))
                    <div class='flex flex-col'>
                        <label class="md:text-center my-3" for="{{$listTable}}">{{__($listTable)}}</label>
                        <input type="text" class="rounded-lg" name="{{$listTable}}" id="{{$listTable}}" value="{{str_replace("_"," ",$babylist->name_child)}}">
                    </div>
                    @elseif(in_array($listTable,['name_list']))
                    <div class='flex flex-col'>
                        <label class="md:text-center my-3" for="{{$listTable}}">{{__($listTable)}}</label>
                        <input type="text" class="rounded-lg" name="{{$listTable}}" id="{{$listTable}}" value="{{$babylist->name_list}}">
                    </div>
                    @elseif(in_array($listTable,['password']))
                    <div class='flex flex-col'>
                        <label class="md:text-center my-3" for="{{$listTable}}">{{__($listTable)}}</label>
                        <input type="{{$listTable}}" class="rounded-lg" name="{{$listTable}}" id="{{$listTable}}" value="{{$babylist->password}}">
                    </div>
                    @endif
                @endforeach
              
                <div class='flex flex-col'>
                    <label class="md:text-center my-3" for="{{$listTables[2]}}">{{__($listTables[2])}}</label>
                    <textarea name="{{$listTables[2]}}" id="{{$listTables[2]}}" class="rounded-lg max-h-40" cols="30" rows="10" maxlength="1000">{{$babylist->message}}</textarea>
                    <button type="submit" class="bg-blue-300 my-4 py-2 px-4 rounded-lg">{{__("Edit")}}</button>
                </div>
            </form>

            <div class="md:hidden sticky flex justify-end pr-10 opacity-60">
                <svg class="animate-bounce w-8 h-8 bg-pink-400 rounded-2xl text-white" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>

        <div class=" mx-6">
            <h1 class='font-semibold text-lg md:mt-10'>{{__("All Articles")}}</h1>
            <p class="mb-10">{{__("Total price: ")}} <span class="font-bold">{{__('Euro')}} {{$totalPrice}}</span></p>            
            @foreach($productsInList as $listProduct)
                <x-edit-list-product :babylist="$babylist" :listProduct="$listProduct" :paidProducts="$paidProducts"/>
            @endforeach
            <div class="md:w-2/3 my-10 ">{{ $productsInList->links() }}</div>
        </div>

    </div>
</x-layout>