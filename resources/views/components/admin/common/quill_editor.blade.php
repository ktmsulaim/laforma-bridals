@push('libs_css')
    <link href="{{ asset('assets/app/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/app/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/app/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('libs_js')
    <script src="{{ asset('assets/app/libs/katex/katex.min.js') }}"></script>
    <script src="{{ asset('assets/app/libs/quill/quill.min.js') }}"></script>
    <script>
        $(function(){
            var quill=new Quill(".quill",{
                theme:"snow",
                modules:{
                    toolbar:[
                        [{font:[]},{size:[]}],
                        ["bold","italic","underline","strike"],
                        [{color:[]},{background:[]}],
                        [{script:"super"},{script:"sub"}],
                        [{header:[!1,1,2,3,4,5,6]},"blockquote","code-block"],
                        [{list:"ordered"},{list:"bullet"},{indent:"-1"},{indent:"+1"}],
                        ["direction",{align:[]}],["link"]]
                }
            });
        });
    </script>
@endpush

<textarea style="display: none" name="{{ $name }}" id="{{ $name }}" cols="30" rows="10" class="form-control" parsley-trigger="change" {{ $required ? 'required' : '' }}>{{ $data }}</textarea>
<div class="quill"></div>