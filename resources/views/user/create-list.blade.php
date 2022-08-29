<x-layout>
    <div class="flex flex-col items-center">
        <h1 class="mt-10 mb-5 text-xl font-bold">{{__("Make a list")}}</h1>
        <x-create-form :listTables="$listTables" />  
    </div>
        
</x-layout>