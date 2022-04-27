@extends('adminlte::page')




@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title" bold="strong">
                                <h4><strong>   {{ __('Reservas') }} </strong></h4>
                            </span>

                             <div class="float-right">
                                <a href="{{ route('reservas.create') }}" class="btn btn-primary btn float-right"  data-placement="left">
                                    <i class="fa fa-plus" aria-hidden="true"></i>   {{ __('Nova reserva') }}
                                </a>
                              </div>
                        </div>
                    </div>



                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @elseif ($message = Session::get('info'))
                    <div class="alert alert-info">
                        <p>{{ $message }}</p>
                    </div>
                    @elseif ($dadosErro = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $dadosErro }}</p>
                    </div>
                    @endif




                    <div class="card-body">
                        <table class="table" id="export_example">
                                <thead class="thead">

                     <th>
                       {{ __('#') }}
                         </th>
                    <th>
                        {{ __('Laboratório') }}
                    </th>
                    <th>
                      {{ __('Solicitante') }}
                    </th>
                    <th>
                        {{ __('Data') }}
                      </th>

                    <th>
                      {{ __('Inicio') }}
                    </th>
                    <th>
                      {{ __('Termino') }}
                    </th>

                    <th>
                        Tipo
                    </th>

                   {{--   <th class="text-center">
                        Status
                    </th> --}}
                    <th class="text-center">
                      {{ __('Ação') }}
                    </th>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @foreach($reservas as $item)
                      <tr>

                        <td>
                            {{ $i++ }}
                          </td>
                        <td>
                          {{ $item->nomeLaboratorio }}
                        </td>
                        <td>
                          {{ $item->nomeSolicitante }}
                        </td>

                        <td>
                            @php
                               echo date('d/m/y', strtotime($item->data));
                            @endphp
                          </td>

                        <td>
                            @php
                               echo date('H:i', strtotime($item->start));
                            @endphp

                        </td>

                        <td>

                            @if ($item->end == '')

                                Em aberto

                            @else

                            @php
                               echo date('H:i', strtotime($item->end));
                            @endphp

                            @endif



                        </td>

                        <td>
                            {{ $item->disciplinaNome }}

                        </td>

                        {{--   <td class="td-actions text-center" width = '20%'>
                          <div class="col-md-12">
                            @if ($item->status == 1)
                            <a class="btn btn-sm btn-danger" href="{{ route('reserva.alterar.status',$item->id) }}"><i class="fa fa-fw fa-lock"></i> Em uso</a>
                              @else
                              <a class="btn btn-sm btn-success"  href="{{ route('reserva.alterar.status',$item->id) }}" ><i class="fa fa-fw fa-unlock" ></i> Liberado</a>
                            @endif
                          </div>
                        </td> --}}



                            <td class="td-actions text-right" width = '20%'>
                            <form>

                            @if ($item->tipo_reserva_id == 3)
                                    @if ($item->status == 1)

                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#alteraStatus" data-id="{{ $item->id }}"><i class="fa fa-fw fa-lock"></i> </a>
                                    @else
                                        <button class="btn btn-sm btn-primary" disabled  href="{{ route('reserva.alterar.status',$item->id) }}" ><i class="fa fa-fw fa-unlock" ></i></button>

                                    @endif

                                    <button class="btn btn-sm btn-success" disabled href="{{ route('reservas.edit',$item->id) }}"><i class="fa fa-fw fa-edit"></i> </button>

                                    <button class="btn btn-danger btn-sm" disabled data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->id }}"><i class="fa fa-fw fa-trash"></i> </button>


                            @else
                            <a class="btn btn-sm btn-success"  href="{{ route('reservas.edit',$item->id) }}"><i class="fa fa-fw fa-edit"></i> </a>

                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->id }}"><i class="fa fa-fw fa-trash"></i> </a>

                            @endif
                           </form>

                        </td>
                      </tr>


                      @endforeach
                  </tbody>

                </table>

                </div>
              </div>
              @foreach ($reservas as $item )
                <form id = "deleteForm" method="POST" action="{{ route('reservas.destroy', $item->id) }}">
                @endforeach
                @method('DELETE')
                @csrf
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <p style="text-align:center">Deseja excluir esta Reserva?</p>
                                </div>

                                <input type="hidden" name="reserva_id" id="reserva_id" value="">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                @foreach ($reservas as $item )
                <form id = "FormAltera" method="POST" action="{{ route('reserva.alterar.status', $item->id) }}">
                @endforeach
                @method('GET')
                @csrf
                    <div class="modal fade" id="alteraStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <p style="text-align:center">Deseja encerrar esta Reserva?</p>
                                </div>

                                <input type="hidden" name="reserva_id" id="reserva_id" value="">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


        </div>

      </div>
    </div>

 <!-- Modal -->











 {{--  MODAL DE AJUDA --}}

 <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajuda</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <h6>Nesta tela estão todas as <b>Reservas</b> cadastrados no sistema</h6>
            <br>
            <h6>Logo acima está o botão <b>Nova Reserva</b> Clicando no botão é possivel agendar uma reserva para um determidado laboratorio.</h6><h6>Exemplo: <br><button  class="btn btn-primary btn-sm">Nova Reserva</button></h6>
            <br>
            <h6>Abaixo estão os dados referentes as reservas que foram cadastradas</h6>
            <br>
            <h6>Logo abaixo do titulo <b>Reservas</b> existe alguns botões para exportar os dados </h6><h6>Exemplo:<br><div class="dt-buttons btn-group flex-wrap"><button  class="btn btn-secondary btn-sm float-right">Copiar</button><button  class="btn btn-secondary btn-sm float-right">Excel</button><button  class="btn btn-secondary btn-sm float-right">CSV</button><button  class="btn btn-secondary btn-sm float-right">PDF</button></div></h6>
            <br>
            <h6>Em cada registro de uma reserva existe botões de ações <b>Editar</b> e <b>Deletar</b> que são para editar e deletar dados das reservas</h6>
            <h6>Exemplo: <br>
                <h6>Botão de Editar:<button  class="btn btn-success btn-sm"><i class="fa fa-fw fa-edit"></i></button></h6>
                <h6>Botão de Deletar:<button  class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button></h6></h6>
            <br>
            <h6>Para as reservas de acadêmicos, é possivel finalizar as reservas, para finalizar a reserva, clique sobre o botão com icone de cadiado
            <button class="btn btn-sm btn-warning"><i class="fa fa-fw fa-lock" ></i></button> para alterar o status da reserva.</h6>

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

<script type="text/javascript">
    $("#alteraStatus").on('show.bs.modal',function (event){
           var button = $(event.relatedTarget);
           var recipientId = button.data('id');
           console.log(recipientId);
           var modal = $(this);
           modal.find("#reserva_id").val(recipientId)
            let id = $(this).attr('data-id');
       });
</script>

<script>

    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000);
    });
    </script>

{{--
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
            var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 1, mirror: true, stop });

    });
</script>

<script type="text/javascript">
$(document).ready(function() {
    document.getElementById('btnModalQr').onclick = function(){
        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 1, mirror: true, stop });
    scanner.stop();
    });

});

</script>
<script type="text/javascript">
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 1, mirror: true });
    scanner.stop();


    scanner.addListener('scan',function(content){
        //alert(content);
        window.location.href='';
        scanner.stop();
    });
    Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
            scanner.start(cameras[0]);
            $('[name="options"]').on('change',function(){
                if($(this).val()==1){
                    if(cameras[0]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('Não foi encontrado camera frontal');
                    }
                }else if($(this).val()==2){
                    if(cameras[1]!=""){
                        scanner.start(cameras[1]);
                    }else{
                        alert('Não foi encontrado camera traseira');
                    }
                }
            });
        }else{
            console.error('Não foi encontrado nenhuma camera no dispositivo.');
            alert('Não foi encontrado nenhuma camera no dispositivo.');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
</script> --}}
@endsection


{{--  <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                        <label class="btn btn-primary active">
                          <input type="radio" name="options" value="1" autocomplete="off" checked> Camera frontal
                        </label>
                        <label class="btn btn-secondary">
                          <input type="radio" name="options" value="2" autocomplete="off"> Camera Traseira
                        </label>
                      </div>
                      <style>
                        #preview{
                           width:250px;
                           height: 250px;
                           margin:0px auto;
                        }
                        </style>
                        <video id="preview"></video --}}
