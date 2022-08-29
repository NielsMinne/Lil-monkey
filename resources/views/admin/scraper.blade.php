<x-layout>
    <div class="h-100 w-full mb-10">
        <div class="w-4/6 mx-auto">
            <div class="flex flex-col col-sm-8 offset-sm-2">
                <h1 class="text-center my-8 text-xl font-bold">{{__('scraper.Data scraping')}}</h1>
                <form action="{{route('scrape.categories')}}" method="POST">
                    @csrf
                    <div class="flex flex-col">
                        <label for="shop">{{__('scraper.Webshop')}}</label>
                        <select name="shop" id="shop" class='rounded-md'>
                        @foreach ($categories->pluck('shop')->unique() as $shop )
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col my-4">
                        <label for="url">{{__('scraper.collection')}}</label>
                        <input required class='rounded-md py-2' type="url" name='url' id='url' placeholder='{{__('scraper.example')}}'>
                    </div>
                    <div class='flex justify-center my-6'>
                        <button type='submit' class='btn btn-primary bg-blue-100 py-2 px-6 rounded-md border-2 border-gray-700'>{{__('scraper.scrape')}}</button>
                    <a class='btn btn-primary text-center bg-blue-100 ml-4 py-2 px-6 rounded-md border-2 border-gray-700' href="{{route('scrape.images')}}">{{__('scraper.download')}}</a>
                </div>
                </form>
            </div>

            @foreach($categories->pluck('shop.name')->unique() as $shop)
                <h1 class="text-center font-bold text-xl my-8">{{$shop}}</h1>
                <x-category-scrape :categories="$categories->where('shop.name',$shop)" />
            @endforeach

            
        </div>
    </div>
</x-layout>
