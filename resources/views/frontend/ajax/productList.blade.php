@if (!empty($products) && $products->count() > 0)
    @foreach ($products as $product)
        <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
            <div class="block-4 text-center border">
                <figure class="block-4-image">
                    <a href="{{ route('urundetay', $product->slug) }}"><img
                            src="{{ asset($product->image) }}" alt="Image placeholder"
                            class="img-fluid"></a>
                </figure>
                <div class="block-4-text p-4">
                    <h3>
                        <a href="{{ route('urundetay', $product->slug) }}">{{ $product->name }}
                            {{$product->qty}}</a>
                    </h3>
                    <p class="mb-0">{{ $product->short_text }}</p>
                    <p class="text-primary font-weight-bold">
                        ₺{{ number_format($product->price, 2) }}</p>
                    <form method="POST" id="addForm">
                        @csrf
                        <input type="hidden" name="productId" value="{{ special_encrypt($product->id) }}">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="size" value="{{$product->size}}">
                        @if($product->qty = 0 || $product->qty == null)
                            <button type="submit" href="{{ route('sepet.ekle' )}}"
                                    class="buy-now btn btn-sm" disabled>Tükendi
                            </button>
                        @else
                            <button type="submit" href="{{ route('sepet.ekle' )}}"
                                    class="buy-now btn btn-sm btn-primary">Sepete Ekle
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
