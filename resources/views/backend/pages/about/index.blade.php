@extends('backend.layout.app')

@section('customcss')
    <style>
        .ck-content {
            height: 300px !important;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Hakkımızda </h4>

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

                    <form action="{{  route('panel.about.update') }}" class="forms-sample" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        @if (!empty($about->image))
                            <div class="form-group">
                                <div class="input-group col-xs-12">
                                    <img class="w-50" src="{{asset($about->image)}}">
                                </div>
                            </div>
                        @endif

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
                            <label for="name">Başlık</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $about->name ?? '' }}"
                                   placeholder="Başlık">
                        </div>

                        <div class="form-group">
                            <label for="editor">Hakkımızda</label>
                            <textarea class="form-control" id="editor" name="content" placeholder="Hakkımızda"
                                      rows="3">{!! $about->content ?? '' !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="text_1_icon">İkon 1</label>
                            <input type="text" class="form-control" id="text_1_icon" name="text_1_icon"
                                   value="{{ $about->text_1_icon ?? '' }}"
                                   placeholder="İkon 1">
                        </div>

                        <div class="form-group">
                            <label for="text_1">İkon Açıklama 1</label>
                            <input type="text" class="form-control" id="text_1" name="text_1"
                                   value="{{ $about->text_1 ?? '' }}"
                                   placeholder="İkon açıklama 1">
                        </div>

                        <div class="form-group">
                            <label for="text_1_content">İkon 1 İçerik</label>
                            <textarea class="form-control" id="text_1_content" name="text_1_content"
                                      placeholder="İkon 1 İçerik"
                                      rows="3">{!! $about->text_1_content ?? '' !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="text_2_icon">İkon 2</label>
                            <input type="text" class="form-control" id="text_2_icon" name="text_2_icon"
                                   value="{{ $about->text_2_icon ?? '' }}"
                                   placeholder="İkon 2">
                        </div>

                        <div class="form-group">
                            <label for="text_2">İkon Açıklama 2</label>
                            <input type="text" class="form-control" id="text_2" name="text_2"
                                   value="{{ $about->text_2 ?? '' }}"
                                   placeholder="İkon açıklama 2">
                        </div>

                        <div class="form-group">
                            <label for="text_2_content">İkon 2 İçerik</label>
                            <textarea class="form-control" id="text_2_content" name="text_2_content"
                                      placeholder="İkon 2 İçerik"
                                      rows="3">{!! $about->text_2_content ?? '' !!}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="text_3_icon">İkon 3</label>
                            <input type="text" class="form-control" id="text_3_icon" name="text_3_icon"
                                   value="{{ $about->text_3_icon ?? '' }}"
                                   placeholder="İkon 3">
                        </div>

                        <div class="form-group">
                            <label for="text_3">İkon Açıklama 3</label>
                            <input type="text" class="form-control" id="text_3" name="text_3"
                                   value="{{ $about->text_3 ?? '' }}"
                                   placeholder="İkon açıklama 3">
                        </div>

                        <div class="form-group">
                            <label for="text_3_content">İkon 3 İçerik</label>
                            <textarea class="form-control" id="text_3_content" name="text_3_content"
                                      placeholder="İkon 3 İçerik"
                                      rows="3">{!! $about->text_3_content ?? '' !!}
                            </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                        <button class="btn btn-light">İptal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customjs')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/tr.js"></script>
    <script>
        const option = {
            language: 'tr',
            heading: {
                options: [
                    {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                    {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                    {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'},
                    {model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3'},
                    {model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4'},
                    {model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5'},
                    {model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6'}
                ]
            }
        };

        ClassicEditor
            .create(document.querySelector('#editor'), option)
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
