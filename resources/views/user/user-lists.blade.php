<x-layout>
    <div class="flex w-5/6 mx-auto h-14 mt-8 border-b-2 border-gray-400">
        <h4 class="hidden w-1/3 md:flex text-center md:text-xl pl-4 pt-2">{{__('name_list')}}</h4>
        <h4 class="w-1/3 text-sm  md:text-left md:text-xl pl-4 pt-2">{{__('name_child')}}</h4>
        <h4 class="w-1/3 text-sm  md:text-left md:text-xl  pl-4 pt-2">{{__('# of items')}}</h4>
        <h4 class="w-1/3 text-sm  md:text-left md:text-xl  md:pl-4 pt-4 md:pt-2">{{__('Action')}}</h4>
    </div>
    
    <div>
        @foreach($lists as $list)
            <x-list-table-card :amountOfProducts="$amountOfProducts" :listData="$list" />
        @endforeach
    </div>
    
    
    <div class="w-5/6 mx-auto mt-10 ">
        {{ $lists->links() }}
    </div>
</x-layout>