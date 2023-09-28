@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sipariş</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <form action="{{  route('panel.order.update', $order->id) }}" class="forms-sample" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="isim">İsim</label>
                            <input type="text" class="form-control" id="isim" readonly
                                   value="{{ $order->name ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label for="telefon">Telefon</label>
                            <input type="tel" class="form-control" id="telefon" readonly
                                   value="{{ $order->phone ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label for="email">E-Posta</label>
                            <input type="email" class="form-control" id="email" readonly
                                   value="{{ $order->email ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label for="note">Not</label>
                            <textarea class="form-control" id="note" readonly
                                      rows="3">{!! $order->note ?? '' !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="durum">Durum</label>
                            @php
                                $status = $order->status ?? 1;
                            @endphp
                            <select class="form-control" id="durum" name="status">
                                <option value="1" {{$status === 1 ? 'selected' : ''}}>Sipariş Onaylandı</option>
                                <option value="0" {{$status === 0 ? 'selected' : ''}}>Sipariş Alındı</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                        <button class="btn btn-light">İptal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
