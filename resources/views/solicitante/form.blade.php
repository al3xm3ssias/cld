<div class="box box-info padding-1">
    <div class="box-body">



        <div class="form-group">
            <div class="col-sm-4">
            {{ Form::label('Nome do Solicitante') }}
            {{ Form::text('nome', $solicitante->nome, ['class' => 'form-control' . ($errors->has('nome') ? ' is-invalid' : ''), 'placeholder' => 'Nome', 'required','minlength'=>4, 'maxlength' => '75']) }}
            {!! $errors->first('nome', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>

        <div class="form-group">
            <div class="col-sm-4">
            {{ Form::label('Email do Solicitante') }}
            {{ Form::text('email', $solicitante->email,['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'name@example.com', 'required']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>



        <div class="col-sm-4">
            {{ Form::label('Função') }}
            <div class="form-group">
                <select class="form-control select2-single" multiple data-style="btn btn-link" id="tipo_solicitante_id" name="tipo_solicitante_id" required>
                    @foreach ($tipoSolicitante as $tipo)
                    <option value="{{$tipo->id}}" {{ (old('tipo_solicitante_id') == $tipo->id ? 'selected'  : ($solicitante->tipo_solicitante_id  == $tipo->id ? 'selected' : '')) }}>{{$tipo->nome}}</option>
                @endforeach
            </select>

            </div>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Confirmar</button>
        <input type="button" class="btn btn-danger" value="Voltar" onClick="history.go(-1)">
    </div>
</div>

<script>
    function goBack() {
        window.history.back()
    }
    </script>

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

