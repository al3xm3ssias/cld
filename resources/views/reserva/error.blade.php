@extends('adminlte::page')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">

          @if ($dadosErro !== [])
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-danger">
                          <h4 class="card-title">{{ __('Erro!!! Há um conflito, já existe reserva para este intervalo de horário!') }}</h4>
                          <p class="card-category"></p>
                      </div>

                      <div class="card-body">
                        @foreach ($dadosReserva as $item)

                                    <div class="alert alert-primary">

                                        <span>
                                            <b class="text-right"> Existe uma reserva para este horario:</b> Horário: {{date('d/m/Y', strtotime($item->start))}} - {{date('H:i', strtotime($item->start))}} - {{date('H:i', strtotime($item->end))}}, solicitante : {{$item->nomeSolicitante}}.
                                        </span>
                                    </div>

                        @endforeach

                        @foreach ($dadosErro as $item )


                                    <div class="alert alert-danger">

                                        <span>
                                            <b class="text-right"> Dados Reserva - </b> Horário: {{date('d/M/Y', strtotime($item->start))}} - {{date('H:i', strtotime($item->start))}} - {{date('H:i', strtotime($item->end))}}, solicitante : {{$item->solicitante_id}}.
                                        </span>
                                    </div>
                        @endforeach
                      </div>
                  </div>
              </div>
              @else

              @endif


{{--
          @if ($reservasCadastradas !== [])
              <div class="col-md-12">
                      <div class="card">
                          <div class="card-header card-header-success">
                              <h4 class="card-title">{{ __('Reservas Cadastradas com Sucesso!') }}</h4>
                              <p class="card-category"></p>
                          </div>
                          <div class="card-body">
                              @foreach ($reservasCadastradas as $key => $values )
                                  @foreach ($values as $item)
                                      <div class="alert alert-primary">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <i class="material-icons">close</i>
                                          </button>
                                          <span>
                                              <b class="text-right"> Reserva Cadastrada - </b> Horário: {{date('d/M/Y', strtotime($item->data))}} - {{$item->start}}/{{$item->end}}.
                                          </span>
                                      </div>

                                  @endforeach
                              @endforeach



                          </div>
                      </div>
              </div>

          @else

          @endif--}}


    </div>
  </div>
</div>
@endsection


@section('footer')
    Footer Content
    @stop

    @section('js')

    <script type="text/javascript">

        $(document).ready(function() {
        $('#export_example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],

            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        } );
    } );
        </script>
        <script type="text/javascript">
            $("#deleteModal").on('show.bs.modal',function (event){
                   var button = $(event.relatedTarget);

                   var recipientId = button.data('id');

                   console.log(recipientId);

                   var modal = $(this);
                   modal.find("#reserva_id").val(recipientId)


                    let id = $(this).attr('data-id');

               });
        </script>
    @endsection
