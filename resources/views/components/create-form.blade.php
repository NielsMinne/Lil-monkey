@props(['listTables'])

    <form class="w-5/6 md:w-3/6 bg-white py-4 px-8 border-2 border-gray-100 rounded-lg shadow-lg" action="{{route('list.add')}}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        @foreach($listTables as $listTable)
            @if(in_array($listTable,['name_list','name_child']))
            <div class='flex flex-col'>
                <label class="md:text-center my-3" for="{{$listTable}}">{{__($listTable)}}</label>
                <input required type="text" class="rounded-lg" name="{{$listTable}}" id="{{$listTable}}" placeholder="{{__('placeholder.' . $listTable)}}">
            </div>
            @elseif(in_array($listTable,['password']))
            <div class='flex flex-col'>
                <label class="md:text-center my-3" for="{{$listTable}}">{{__($listTable)}}</label>
                <input required type="{{$listTable}}" class="rounded-lg" name="{{$listTable}}" id="{{$listTable}}">
            </div>
            @endif
        @endforeach
      
        <div class='flex flex-col'>
            <label class="md:text-center my-3" for="{{$listTables[2]}}">{{__($listTables[2])}}</label>
            <textarea name="{{$listTables[2]}}" id="{{$listTables[2]}}" class="rounded-lg max-h-40" cols="30" rows="10" maxlength="1000" placeholder="{{__('placeholder.Description')}}"></textarea>
            <button type="submit" class="bg-blue-300 my-4 py-2 px-4 rounded-lg">{{__('Create list')}}</button>
        </div>
    </form>
