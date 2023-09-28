@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Siparişler</h4>

                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>İsim</th>
                                <th>Telefon</th>
                                <th>E-Posta</th>
                                <th>Not</th>
                                <th>Adres</th>
                                <th>Sepetteki Ürün</th>
                                <th>Durum</th>
                                <th>Düzenle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($orders) && count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr class="item" item-id="{{ $order->id }}">
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->email ?? ''}}</td>
                                        <td>{{ $order->note }}</td>
                                        <td>{!! strLimit($order->address, 50, route('panel.order.edit', $order->id)) !!} - {{ $order->city }} / {{ $order->district }}</td>
                                        <td>{{ $order->orders_count }}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="durum" data-toggle="toggle"
                                                           data-on="Aktif"
                                                           data-off="Pasif" {{ $order->status === 1 ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="d-flex">
                                            <a class="btn btn-primary mr-2"
                                               href="{{ route('panel.order.edit', $order->id) }}">Düzenle</a>

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
                            {{ $orders->links('pagination::custom') }}
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
                url: "{{route('panel.order.status')}}",
                data: {
                    id: id,
                    state: state
                },
                success: function (response) {
                    if (response.status == 'true') {
                        alertify.success("İletişim Aktif Edildi");
                    } else {
                        alertify.error("İletişim Pasif Edildi")
                    }
                }
            });
        });

        $(document).on('click', '.sil-btn', function (e) {
            e.preventDefault();
            var item = $(this).closest('.item');
            id = item.attr('item-id');
            alertify.confirm("Silmek istediğinizden emin misiniz?", "Silinen order bir daha erişilemez.",
                function () {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: "DELETE",
                        url: "{{route('panel.order.destroy')}}",
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
