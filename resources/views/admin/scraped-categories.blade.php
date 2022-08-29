<x-layout>
   <div class="w-5/6 mx-auto my-20">
        <div class='grid grid-cols-1 md:grid-cols-3 gap-8'>
            @foreach ($categories->pluck('shop.name')->unique() as $shop)
                <div class="bg-slate-200 py-10 rounded-lg shadow-lg">
                <h1 class="text-center text-4xl mb-10">{{$shop}}</h1>
                @foreach ($categories->where('shop.name',$shop) as $category)
                    <div>
                        <article class='flex flex-col items-center mb-2'>
                        <h1>{{$category->title}}</h1>
                        </article>
                    </div>
                @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
