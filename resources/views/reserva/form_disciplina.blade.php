<div class="box box-info padding-1">
    <div class="box-body">


        <input type="hidden" name="usuario_id" value="{{auth()->id()}}">

        <input type="hidden" name="tipo_reserva" value="1">



            <div class="form-group" id="div_laboratorio_dis">
                {{ Form::label('Laboratório') }}

                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control select2-single" multiple data-style="btn btn-link" id="laboratorio_id"
                            name="laboratorio_id" required>
                            @foreach ($laboratorios as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nome}}</option>                            @endforeach
                        </select>
                    </div>

                </div>

            </div>



            <div class="form-group" id="div_hora_ini_dis">
                {{ Form::label('Inicio') }}


                    <div class="col-sm-6">
                        <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input {{ $errors->has('hora_inicio') ? ' is-invalid' : '' }}" data-target="#datetimepicker2" name="hora_inicio" value="{{ old('hora_inicio') }}"
                            required aria-required="true" />
                             <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>

                            </div>

                        </div>
                        @if ($errors->has('hora_inicio'))
                                        <span id="name-error" class="error text-danger"
                                            for="input-name">{{ $errors->first('hora_inicio') }}</span>
                                        @endif

                    </div>
                </div>

                <div class="form-group" id="QtdAulas_dis">
                    {{ Form::label('Quantidade de aulas') }}
                    <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon "></span>
                        <select class="form-control select2-single" required multiple name="QtdAulas"  title="QtdAulas">

                            <option value="1" >1 Aula</option>
                            <option value="2" >2 Aulas</option>
                            <option value="3" >3 Aulas</option>
                            <option value="4" >4 Aulas</option>

                        </select>
                    </div>
                    @if($errors->has('turno'))
                        <p class="help-block">{!! $errors->first('turno') !!}</p>
                    @endif
                </div>
                </div>



            <div class="form-group" id = "div_repetir_dis">
                {{ Form::label('Repetir agendamento?') }}

                <div class="col-sm-6">
                    <div class="form-group bmd-form-group">
                        <div class="form-check">
                            <input type="radio" name="opcaoReserva" value="1" id="umavez" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Uma Vez
                            </label>
                        </div>


                        <div class="form-check">
                            <input type="radio" name="opcaoReserva" value="2" id="semanalmente">
                            <label class="form-check-label" for="gridRadios1">
                                Semanalmente
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="opcaoReserva" value="3" id="diariamente">
                            <label class="form-check-label" for="gridRadios1">
                                Diariamente
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="form-group" id="dataLabelFimId_dis">
                {{ Form::label('Data final do agendamento') }}

                <div class="col-sm-6">
                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                     <input type="text" class="form-control datetimepicker-input {{ $errors->has('dataFim') ? ' is-invalid' : '' }}" data-target="#datetimepicker4" name="dataFim" value="{{ old('dataFim') }}"
                     required aria-required="true"/>
                         <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>



                        </div>
                    </div>

                    @if ($errors->has('dataFim'))
                    <span id="name-error" class="error text-danger"
                        for="input-name">{{ $errors->first('dataFim') }}</span>
                    @endif
                </div>

            </div>


            <div class="form-group" id ="div_disciplinas_dis">
                {{ Form::label('Disciplina') }}

                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control select2-single" multiple data-style="btn btn-link" id="disciplinas_id" name="disciplinas_id" required>
                            @foreach ($disciplinas as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nome}}</option>                               @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <div class="form-group" id="div_professor_dis">
                {{ Form::label('Professor da disciplina') }}

                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control select2-single" required multiple data-style="btn btn-link" id="solicitante_id_professor"
                            name="solicitante_id_professor">
                            @foreach ($solicitantes_professores as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nome}}</option>                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group" id="div_obs_dis">
                {{ Form::label('Observações') }}
                <div class="col-sm-6">

                        <div class="form-group{{ $errors->has('observacao') ? ' has-danger' : '' }}">
                            <textarea cols="20" rows="2"
                                class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                                name="observacao" id="input-description" type="text"
                                placeholder="Observação" aria-required="true"></textarea>
                            @if ($errors->has('observacao'))
                            <span id="name-error" class="error text-danger"
                                for="input-observacao">{{ $errors->first('observacao') }}</span>
                            @endif
                        </div>
                </div>
            </div>
    </div>




<div class="box-footer mt20">
    <button type="submit" class="btn btn-primary">Confirmar</button>
    <input type="button" class="btn btn-danger" value="Voltar" onClick="history.go(-1)">
</div>

    </div>



<!--Bootstrap CSS CDN-->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!--Bootstrap JS CDN-->
<script  type="text/javascript" src="../../vendor/jquery/jquery.js"></script>

<!--Moment JS CDN-->



<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment-with-locales.min.js" integrity="sha512-kcvf1mExE8WCOLBL5re/9hLUHfaj8+LQrKlupTarmme+rwv8asLK4q6Ge32trTMBElPBP5sll4czZKNvps0VvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/locale/pt-br.min.js" integrity="sha512-ZQjLQJ3zyxOFiOW2bf+1xD3wCAYxpi+b3Zzf/x2ThVJ4hqhkGN52eNznjIQ0vmW+Wpzw719H+QO9c/yKmPLtXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!--Tempusdominus JS CDN-->
<script type="text/javascript" src="../../vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script  type="text/javascript" src="../../vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!--Tempusdominus CSS CDN-->
<link rel="stylesheet" href="../../vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css"/>
<link rel="stylesheet" href="../../vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"/>

<script>
    function goBack() {
        window.history.back()
    }
    </script>



<script type="text/javascript">
    $(function(){
        $('#datetimepicker2').datetimepicker({
          locale: 'pt-br',
          useCurrent: false,
          format: 'DD/MM/YYYY HH:mm',
          inline:true,
          sideBySide: true,
          daysOfWeekDisabled: [0],
          disabledHours: [0, 1, 2, 3, 4, 5, 6, 24],
            icons: {
                time: 'fa fa-clock',

            }
        });


   /* $('#datetimepicker3').datetimepicker({
          locale: 'pt-br',
          useCurrent: false,
          format: 'DD/MM/YYYY HH:mm',

          //inline:true,
          sideBySide: false,
          daysOfWeekDisabled: [0],
          disabledHours: [0, 1, 2, 3, 4, 5, 6, 24],
            icons: {
                time: 'fa fa-clock',
                up: 'fas fa-chevron-up',
                own: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
                },
        }); */

    $('#datetimepicker4').datetimepicker({
        locale: 'pt-br',
        //useCurrent: false,
        format: 'DD-MM-YYYY',
        //inline:true,
        //sideBySide: true,
        daysOfWeekDisabled: [0],
        disabledHours: [0, 1, 2, 3, 4, 5, 6, 24],
            icons: {
                time: 'fa fa-clock',

            },
            maxDate: moment().add(30, 'days'),

     });



});

</script>

<script type="text/javascript">
    $(function(){
        $('#datatimepicker3').datetimepicker();
        $('#datatimepicker2').datetimepicker();
        $('#datetimepicker4').datetimepicker();




        $('#datetimepicker2').on('change.datetimepicker',  function(f) {
                $('#datetimepicker4').datetimepicker('minDate', f.date);

        });




       /* $('#datetimepicker3').on('change.datetimepicker', function ('30') {
              $('#datetimepicker4').datetimepicker('maxDate', e.date);


        }); */
    });

</script>

<script>
    $(document).ready(function() {
     $('.select2-single').select2({

     placeholder: "Selecione os itens",

     width: '100%',

     maximumSelectionLength: 1,
     language: "pt-BR",
   });

 });
     </script>



<script  type="text/javascript" src="../../vendor/jquery/jquery.js"></script>



        <script>
            $(document).ready(function(){
                $('#dataLabelFimId_dis').hide();
                $('#dataLabelFimId_ext').hide();
                $('#umavez').click(function(){
                    if($('#umavez').prop('checked')){
                        $('#dataLabelFimId_dis').hide();

                    }
                });
                $('#diariamente').click(function(){
                    if($('#diariamente').prop('checked')){
                        $('#dataLabelFimId_dis').show();

                    }else{
                        $('#dataLabelFimId_dis').hide();
                    }
                });
                $('#semanalmente').click(function(){
                    if($('#semanalmente').prop('checked')){
                        $('#dataLabelFimId_dis').show();

                    }else{
                        $('#dataLabelFimId_dis').hide();
                    }
                });
            })
        </script>
