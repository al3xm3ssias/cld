<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            <div class="col-sm-4">
            {{ Form::label('Número do Laboratório') }}
            {{ Form::text('nome', $laboratorio->nome, ['class' => 'form-control' . ($errors->has('nome') ? ' is-invalid' : ''), 'placeholder' => 'Número do Laboratório','required']) }}
            {!! $errors->first('nome', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        <div class="form-group">
            <div class="col-sm-4">
            {{ Form::label('Apelido do Laboratório') }}
            {{ Form::text('apelido', $laboratorio->apelido, ['class' => 'form-control' . ($errors->has('apelido') ? ' is-invalid' : ''), 'placeholder' => 'Apelido do Laboratório', 'required']) }}
            {!! $errors->first('apelido', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            </div>


        {{ Form::label('Possui restrição de acesso?') }}
        <div class="col-sm-2">
        <div class="form-group {{ $errors->has('restrito') ? ' has-error' : '' }}">

            <div class="input-group">
                <span class="input-group-addon "></span>
                <select class="form-control select2-single" multiple name="restrito" required title="restrito">

                    <option value="0" @if(old('restrito') == 0 || (isset($laboratorio) && $laboratorio->restrito == 0)) selected @endif>Não</option>
                    <option value="1" @if(old('restrito') == 1 || (isset($laboratorio) && $laboratorio->restrito == 1))  @endif>Sim</option>
                    </select>
            </div>
            @if($errors->has('restrito'))
                <p class="help-block">{!! $errors->first('restrito') !!}</p>
            @endif
        </div>
        </div>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Confirmar</button>
        <input type="button" class="btn btn-danger" value="Voltar" onClick="history.go(-1)">
    </div>
</div>

@section('footer')
Footer Content
@stop

@section('js')

<script  type="text/javascript">
    $(document).ready(function() {
     $('.select2-single').select2({

     placeholder: "Selecione os itens",

     width: '100%',

     maximumSelectionLength: 1,
     language: "pt-BR",
   });

 });
     </script>

@endsection
