<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            <div class="col-sm-4">
            {{ Form::label('Nome da disciplina') }}
            {{ Form::text('nome', $disciplina->nome, ['class' => 'form-control' . ($errors->has('nome') ? ' is-invalid' : ''), 'placeholder' => 'Nome da disciplina','required','minlength'=>4, 'maxlength' => '75']) }}
            {!! $errors->first('nome', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>


        <div class="form-group {{ $errors->has('turno') ? ' has-error' : '' }}">
            {{ Form::label('Turno') }}
            <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon "></span>
                <select class="form-control select2-single" multiple name="turno" required title="turno">

                    <option value="M" @if(old('restrito') == "M" || (isset($disciplina) && $disciplina->turno == "M")) selected @endif>Manhã</option>
                    <option value="T" @if(old('restrito') == "N" || (isset($disciplina) && $disciplina->turno == "N")) selected @endif>Tarde</option>
                    <option value="N" @if(old('restrito') == "T" || (isset($disciplina) && $disciplina->turno == "T")) selected @endif>Noturno</option>

                </select>
            </div>
            </div>
            @if($errors->has('turno'))
                <p class="help-block">{!! $errors->first('turno') !!}</p>
            @endif
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
  {{--
    <body>
    <button onclick="goBack()">Go Back</button>
    </body>  --}}
    @section('footer')
    Footer Content
    @stop
    @section('js')

    <script  type="text/javascript">
        $(document).ready(function() {
         $('.select2-single').select2({

         placeholder: "Selecione os itens",



         maximumSelectionLength: 1,
         language: "pt-BR",
       });

     });
         </script>

    @endsection
