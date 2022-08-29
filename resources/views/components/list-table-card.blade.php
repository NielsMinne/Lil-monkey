@props(['listData','amountOfProducts'])

<div class="flex md:w-5/6 mx-4 md:mx-auto px-6 py-4 items-center border-b-2 border-gray-200">
    <h4 class="hidden text-center md:flex w-1/3 text-md  ">{{$listData->name_list}}</h4>
    <h4 class="w-1/3 text-sm md:text-base md:text-left text-md pl-2 font-semibold">{{str_replace("_"," ",$listData->name_child)}}</h4>
    <h4 class="w-1/3 text-sm md:text-base  md:text-left text-md pl-4">{{$amountOfProducts[$listData->id]}}</h4>
    <div class="w-1/3 text-md ">
        <a class="bg-blue-300 text-sm p-2 rounded-lg" href="{{route('list.specific', $listData->id)}}">{{__('buttons.Go to list')}}</a>
    </div>
</div>

</div>