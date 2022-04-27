@extends('adminlte::page')

@section('content')





<script src="..\vendor\jquery\jquery.min.js"></script>
<link href='..\vendor\fullcalendar\main.css' rel='stylesheet'/>
<script src='..\vendor\fullcalendar\main.js'></script>

<link href='..\vendor\fullcalendar\main.min.css' rel='stylesheet' />


<script src='..\vendor\fullcalendar\locales\pt-br.js'></script>


<script type="text/javascript">
    $(document).ready(function () {
    var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('card')
                }
    });
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            //events: SITEURL + "/calendario",
            eventColor: '#378006',


           //
            //container: 'body',
            navLinks: true,
            headerToolbar: {
                left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
      timeZone: 'local',
      events:  SITEURL + '/calendario/mostrar/',
      displayEventTime: true,

      nowIndicator: true,

      dayMaxEventRows: true, // for all non-TimeGrid views
        views: {
            timeGrid: {
            dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                }
         },


     eventDidMount: function(arg) {
      let val = selector.value;
      if (!(val == arg.event.extendedProps.laboratorio_id || val == "all")) {
        arg.el.style.display = "none";
        }


        $(arg.el).popover({
                animation: true,
                delay: 300,
                content: "Solicitante: " + arg.event.extendedProps.description + " Laboratório: " +arg.event.extendedProps.groupID,
                trigger: 'hover',
                html: true,
                container: 'body',
                placement: 'top',
            });
    },

    });

    calendar.render();

    busca.addEventListener('click', function() {
    calendar.refetchEvents();
  });


});

</script>
<script  type="text/javascript" src="../../vendor/jquery/jquery.js"></script>




<script>
   $(document).ready(function() {
    $('.select2-single').select2({

    placeholder: "Selecione os itens",
    dropdownAutoWidth: true,
    //closeOnSelect: false,
    width: '20%',
    maximumSelectionLength: 1,
    language: "pt-BR",
  });




});
    </script>
{{--
    <script>
        $('.select2-single').on("click", function () {
        $example.select2("open");
});
    </script>
--}}
{{--  <script src='..\vendor\fullcalendar\script.js'></script>
<script src='..\vendor\fullcalendar\calendario.js'></script>--}}

<div class="card">
    <div class="card-body">
            <div class="float-right">
                <a href="{{ route('reservas.create') }}" class="btn btn-primary btn float-right"  data-placement="left">
                    <i class="fa fa-plus" aria-hidden="true"></i>  {{ __('Nova reserva') }}
                </a>
            </div>

            {{ Form::label('Pesquisar:') }}

                <select class="form control select2-single"  multiple name="laboratorio_id" id="selector" tabindex="-1" aria-hidden="true">
                    <option value="all" selected>Todos</option>

                    @foreach($laboratorios as $laboratorio)
                    <option value="{{ $laboratorio->id }}" @if (request('laboratorio_id') == $laboratorio->id) selected @endif>{{ $laboratorio->nome }}</option>
                    @endforeach
                </select>
                 <button class="btn btn-info" id="busca">Buscar</button>





        <div id='calendar'></div>
    </div>
    </div>




    {{--  MODAL DE AJUDA --}}

    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajuda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="card">

                    <div class="card-header">

                <h6>Nesta tela as reservas cadastradas estão visiveis em formato de um calendario.</h6>

                </div>
                <div class="card-body">

                <h6>Logo acima está o botão <b>Nova Reserva</b> Clicando no botão é possivel cadastrar uma nova reserva.</h6><h6><b>Exemplo:</b></h6> <h6><button  class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>Nova Reserva</button></h6>

                </div>
                <div class="card-body">
                <h6>É possivel filtrar as reservas por laboratorio, basta selecionar o laboratorio no campo <b>Pesquisar</b></h6>
                <h6><b>Exemplo:</b></h6><label>Pesquisar:</label><select class="form control select2-single"  multiple><option selected>Todos</option><option>Lab 05</option><option>Lab 09</option></select> <button class="btn btn-info">Buscar</button>
                <br>
                <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por padrão o campo vem selecionado a opção "Todos", por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>
                </div>
                <div class="card-body">
                <h6>Logo abaixo dos botões há um calendario de reservas cadastradas nos laboratórios</h6>

                </div>
                <div class="card-body">
                <h6>Logo abaixo, existe alguns botôes que alteram a visulização do calendario </h6><h6>Exemplo:<br><h6> São botões de avançar e retroceder nas datas (Meses/Semanas/Dias)<br><div class="dt-buttons btn-group flex-wrap"><button  class="btn btn-secondary btn-sm float-right"><i class="fa fa-chevron-left"></i></button></button><button  class="btn btn-secondary btn-sm float-right"><i class="fa fa-chevron-right"></i></button></div></h6><h6>Este botão volta a data atual {{ date('d/m/Y', strtotime($dataHoje))}}<br><button  class="btn btn-secondary btn-sm active">Hoje</button></h6></h6>

                <h6>Logo abaixo do botão de Nova reserva, existe alguns botôes que alteram a visulização do calendario </h6><h6>Exemplo:<br><div class="dt-buttons btn-group flex-wrap"><button  class="btn btn-secondary btn-sm float-right active">Mês</button><button  class="btn btn-secondary btn-sm float-right">Semana</button><button  class="btn btn-secondary btn-sm float-right">Dia</button><button  class="btn btn-secondary btn-sm float-right">Lista</button></div></h6>

                </div>
                <div class="card-body">
                <h6>Existe um padrão de cores para diferenciar as Reservas</h6>
                <b><p class="text-primary">Reserva para disciplinas</p>
                <p class="text-danger">Reserva para solicitantes externos</p>
                <p class="text-success">Reserva para Academicos do departamento</p></b>
                </div>
                </div>

              </div>


              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

              </div>
            </div>
          </div>

    </div>

@endsection


@section('footer')
Footer Content
@stop
