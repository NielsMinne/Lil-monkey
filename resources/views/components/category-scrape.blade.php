@props(['categories'])

<table class='w-full'>
    @foreach ($categories as $category)
        <tr>
            <td>{{$category->title}}</td>
            <td>
                <form method="POST" action="{{route('scrape.products')}}">
                    @csrf
                    <input type="hidden" name="url" value="{{$category->url}}">
                    <input type="hidden" name="category_id" value="{{$category->id}}">
                    <input type="hidden" name="shop" value="{{$category->shop_id}}">
                    <button type="submit" class="btn bg-yellow-500 text-black py-2 px-4 rounded-lg">{{__("scraper.Scrape products")}}</button>

                </form>
            </td>
        </tr>
    @endforeach
</table>
