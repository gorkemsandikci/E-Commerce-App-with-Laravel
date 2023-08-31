@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ürünler</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.product.create')  }}" class="btn btn-primary">Yeni Ekle</a>
                    </p>
                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Görsel</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Link</th>
                                <th>Durum</th>
                                <th>Düzenle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    <tr class="item" item-id="{{ $item->id }}">
                                        <td class="py-1">
                                            <img src="{{ asset($item->image) }}" alt="image"/>
                                        </td>
                                        <td>{{ $item->name }}</td>

                                        <td>{{ $item->product->name ?? '' }}</td>
                                        <td>{{ $item->content }}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="durum" data-toggle="toggle"
                                                           data-on="Aktif"
                                                           data-off="Pasif" {{ $item->status === '1' ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="d-flex">
                                            <a class="btn btn-primary mr-2"
                                               href="{{ route('panel.product.edit', $item->id) }}">Düzenle</a>
                                            <button type=button class="sil-btn btn btn-danger">Sil</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            {{ $products->links('pagination::custom') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('customjs')
    <script>
        $(document).on('change', '.durum', function (e) {
            id = $(this).closest('.item').attr('item-id');
            state = $(this).prop('checked');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: "POST",
                url: "{{route('panel.product.status')}}",
                data: {
                    id: id,
                    state: state
                },
                success: function (response) {
                    if (response.status == 'true') {
                        alertify.success("Kategori Aktif Edildi");
                    } else {
                        alertify.error("Kategori Pasif Edildi")
                    }
                }
            });
        });

        $(document).on('click', '.sil-btn', function (e) {
            e.preventDefault();
            var item = $(this).closest('.item');
            id = item.attr('item-id');
            alertify.confirm("Silmek istediğinizden emin misiniz?", "Silinen kategoryiye bir daha erişilemez.",
                function () {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: "DELETE",
                        url: "{{route('panel.product.destroy')}}",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            if (response.error == false) {
                                item.remove();
                                alertify.success(response.message);
                            } else {
                                alertify.error("Hata oluştu!");
                            }
                        }
                    });
                },
                function () {
                    alertify.error('İşlem iptal edildi!');
                });
        });

    </script>
@endsection
