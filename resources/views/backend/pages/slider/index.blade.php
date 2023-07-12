@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <p class="card-description">
                        <a href="{{ route('panel.slider.create') }}" class="btn btn-primary">Yeni Ekle</a>
                    </p>
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
                            @if(!empty($sliders) && count($sliders) > 0)
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td class="py-1">
                                            <img src="{{ asset($slider->image) }}" alt="image"/>
                                        </td>
                                        <td>{{ $slider->name }}</td>
                                        <td>{{ $slider->content }}</td>
                                        <td>{{ $slider->link }}</td>
                                        <td><label
                                                class="badge badge-{{ $slider->status === '1' ? 'success' : 'danger' }}">{{ $slider->status === '1' ? 'Aktif' : 'Pasif' }}</label>
                                        </td>
                                        <td class="d-flex">
                                            <a class="badge badge-warning mr-2"
                                               href="{{ route('panel.slider.edit', $slider->id) }}">Düzenle</a>
                                            <form action="{{ route('panel.slider.destroy', $slider->id) }}"
                                                  method="POST">
                                                @method('DELETE')
                                                <button type="submit" class="badge badge-secondary">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
