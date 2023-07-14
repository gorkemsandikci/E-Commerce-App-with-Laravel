@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kategori </h4>
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

                    @if (!empty($category->id))
                        @php
                            $route_link = route('panel.category.update', $category->id)
                        @endphp
                    @else
                        @php
                            $route_link = route('panel.category.store')
                        @endphp
                    @endif
                    <form action="{{ $route_link }}" class="forms-sample" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @if (!empty($category->id))
                            @method('PUT')
                        @endif

                        @if (!empty($category->image))
                            <div class="form-group">
                                <div class="input-group col-xs-12">
                                    <img width="40%" src="{{asset($category->image)}}">
                                </div>
                            </div>
                        @endif


                        <div class="form-group">
                            <label for="baslik">Başlık</label>
                            <input type="text" class="form-control" id="baslik" name="name"
                                   value="{{ $category->name ?? '' }}"
                                   placeholder="Başlık">
                        </div>

                        <div class="form-group">
                            <label for="aciklama">Açıklama</label>
                            <textarea class="form-control" id="aciklama" name="description" placeholder="Açıklama"
                                      rows="3">{!! $category->content ?? '' !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="cat_ust">Kategori</label>
                            <select class="form-control" id="" name="cat_ust">
                                <option value="">Kategori Seç</option>
                                @if($categories)
                                    @foreach($categories as $sub_category)
                                        <option value="{{ $sub_category->id }}" {{ isset($category) && $category->cat_ust == $sub_category->id ? 'selected' : '' }} >{{ $sub_category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Görsel Yükle</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                       placeholder="Görsel Yükle">
                                <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Yükle</button>
                        </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="durum">Durum</label>
                            @php
                                $status = $category->status ?? '1';
                            @endphp
                            <select class="form-control" id="durum" name="status">
                                <option value="1" {{$status == '1' ? 'selected' : ''}}>Aktif</option>
                                <option value="0" {{$status == '0' ? 'selected' : ''}}>Pasif</option>
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
