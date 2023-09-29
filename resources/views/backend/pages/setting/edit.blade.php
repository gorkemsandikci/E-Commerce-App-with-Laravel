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
                    <h4 class="card-title">Site Ayarı</h4>

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

                    @if (!empty($setting->id))
                        @php
                            $route_link = route('panel.setting.update', $setting->id)
                        @endphp
                    @else
                        @php
                            $route_link = route('panel.setting.store')
                        @endphp
                    @endif

                    <form action="{{ $route_link }}" class="forms-sample" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @if (!empty($setting->id))
                            @method('PUT')
                        @endif

                        @if (isset($setting->set_type) && $setting->set_type === 'image')
                            <div class="form-group">
                                <div class="input-group col-xs-12">
                                    <img width="40%" src="{{asset($setting->data ?? 'img/logo.png')}}">
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="set_type">Tür Seçiniz:</label>
                            <select name="set_type" class="form-control" id="setTypeSelect">
                                <option value="">Tür Seçiniz</option>
                                <option
                                    value="ckeditor" {{ isset($setting->set_type) && $setting->set_type == 'ckeditor' ? 'selected' : '' }}>
                                    CKEditor
                                </option>
                                <option
                                    value="textarea" {{ isset($setting->set_type) && $setting->set_type == 'textarea' ? 'selected' : '' }}>
                                    TextArea
                                </option>
                                <option
                                    value="file" {{ isset($setting->set_type) && $setting->set_type == 'file' ? 'selected' : '' }}>
                                    Dosya
                                </option>
                                <option
                                    value="image" {{ isset($setting->set_type) && $setting->set_type == 'image' ? 'selected' : '' }}>
                                    Resim
                                </option>
                                <option
                                    value="text" {{ isset($setting->set_type) && $setting->set_type == 'text' ? 'selected' : '' }}>
                                    Yazı
                                </option>
                                <option
                                    value="email" {{ isset($setting->set_type) && $setting->set_type == 'email' ? 'selected' : '' }}>
                                    E-Posta
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Key:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $setting->name ?? '' }}"
                                   placeholder="Key">
                        </div>

                        <div class="form-group">
                            <label for="data">Value:</label>
                            <div class="inputContent">
                                @if(isset($setting->set_type) && $setting->set_type === 'ckeditor')
                                    <textarea class="form-control" id="editor" name="data"
                                              rows="3">{!! $setting->data == '' !!}</textarea>
                                @elseif(isset($setting->set_type) && $setting->set_type === 'textarea')
                                    <textarea class="form-control" id="data" name="data"
                                              rows="3">{!! $setting->data == '' !!}</textarea>
                                @elseif(isset($setting->set_type) && $setting->set_type === 'image' || isset($setting->set_type) && $setting->set_type === 'file')
                                    <input class="form-control" type="file" name="data">
                                @elseif(isset($setting->set_type) && $setting->set_type === 'text')
                                    <input class="form-control" type="text" name="data" placeholder="Yazınız"
                                           value="{{ $setting->data ?? '' }}">
                                @elseif(isset($setting->set_type) && $setting->set_type === 'email')
                                    <input class="form-control" type="email" value="{{ $setting->data ?? '' }}">
                                @else
                                @endif

                            </div>
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

        function ckeditor(defaultText) {
            ClassicEditor
                .create(document.querySelector('#editor'), option)
                .then(editor => {
                    window.editor = editor;
                    editor.setData(defaultText);
                })
                .catch(error => {
                    console.error(error);
                });
        }

        $(document).on('change', '#setTypeSelect', function (e) {
            selectType = $(this).val();
            createInput(selectType);
        });

        @if(isset($setting->data) && $setting->set_type == 'ckeditor')
            defaultText = "{!! isset($setting->data) ? $setting->data : '' !!}";
        ckeditor(defaultText);
        @endif

        @if(isset($setting->data) && $setting->set_type == 'textarea')
        console.log('textarea');
        createInput('textarea');
        @endif

        function createInput(type) {
            defaultText = "{!! isset($setting->data) ? $setting->data : '' !!}";

            if (type === 'text') {
                newInput = $('<input>').attr({
                    type: 'text',
                    name: 'data',
                    value: defaultText,
                    class: 'form-control'
                });
            } else if (type === 'email') {
                newInput = $('<input>').attr({
                    type: 'email',
                    name: 'data',
                    class: 'form-control',
                    value: defaultText,
                    placeholder: "E-Posta Giriniz"
                });
            } else if (type === 'ckeditor') {
                newInput = $('<textarea>').attr({
                    name: 'data',
                    id: 'editor',
                    value: defaultText,
                    class: 'editor',
                });
                newInput.val(defaultText);
            } else if (type === 'textarea') {
                newInput = $('<textarea>').attr({
                    name: 'data',
                    id: 'textarea',
                    value: defaultText,
                    class: 'form-control',
                });
                newInput.value(defaultText);
            } else if (type === 'file' || type === 'image') {
                newInput = $('<input>').attr({
                    type: 'file',
                    name: 'data',
                    class: 'form-control',
                });
            }

            $('.inputContent').empty().append(newInput);

            if (type === 'ckeditor') {
                ckeditor(defaultText);
                window.editor.setData(defaultText);
            }
        }
    </script>
@endsection
