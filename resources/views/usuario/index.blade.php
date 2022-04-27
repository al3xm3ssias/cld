@extends('adminlte::page')

@section('template_title')
    Usuários
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <h4><strong>    {{ __('Usuários') }} </strong></h4>
                            </span>

                             <div class="float-right">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn float-right"  data-placement="left">
                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Novo Usuário') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <table class="table" id="export_example">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>

										<th>Nome</th>
										<th>E-mail</th>
										<th>Função</th>

                                        <th class="text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $i++ }}</td>

											<td>{{ $usuario->nome }}</td>
                                            <td>{{ $usuario->email }}</td>


                                            <td>{{ $usuario->profile }}</td>



                                            <td class="td-actions text-right" width = '20%'>
                                                <form >
                                                    <a class="btn btn-sm btn-success" href="{{ route('users.edit',$usuario->id) }}"><i class="fa fa-fw fa-edit"></i></a>


                                                    @if (auth()->id() == $usuario->id)
                                                    <button class="btn btn-danger btn-sm" disabled data-toggle="modal" data-target="#deleteModal" data-id="{{ $usuario->id }}"><i class="fa fa-fw fa-trash"></i></button>
                                                    @else
                                                    <button type="button" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#deleteModal" data-id="{{ $usuario->id }}"><i class="fa fa-fw fa-trash"></i></<button>
                                                    @endif

                                                 </form>
                                            </td>
                                        </tr>



                                    @endforeach
                                </tbody>
                            </table>
                        </div>





                </div>

            </div>
        </div>
    </div>



    <!-- Modal -->
    @foreach ($usuarios as $usuario )
    <form id = "deleteForm" method="POST" action="{{ route('users.destroy', $usuario->id) }}">
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
                            Deseja excluir este usuário?
                        </div>

                        <input type="hidden" name="user_id" id="user_id" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
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
            modal.find("#user_id").val(recipientId)


             let id = $(this).attr('data-id');

        });
</script>

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

            <h6>Nesta tela estão todos os <b>Usuários</b> cadastrados no sistema</h6>
            <br>
            <h6>Logo acima está o botão <b>Novo Usuário</b> Clicando no botão é possivel cadastrar novos usuários.</h6><h6>Exemplo: <br><button  class="btn btn-primary btn-sm">Novo Usuário</button></h6>
            <br>
            <h6>Abaixo estão os dados referentes os usuários que foram cadastrados</h6>
            <br>
            <h6>Logo abaixo do titulo <b>Usuários</b> existe alguns botões para exportar os dados </h6><h6>Exemplo:<br><div class="dt-buttons btn-group flex-wrap"><button  class="btn btn-secondary btn-sm float-right">Copiar</button><button  class="btn btn-secondary btn-sm float-right">Excel</button><button  class="btn btn-secondary btn-sm float-right">CSV</button><button  class="btn btn-secondary btn-sm float-right">PDF</button></div></h6>
            <br>
            <h6>Em cada registro de um usuário existe botões de ações <b>Editar</b> e <b>Deletar</b> que são respectivamente para editar e/ou deletar os cadastros dos usuários</h6>
            <h6>Exemplo: <br>
            <h6>Botão de Editar:<button  class="btn btn-success btn-sm"><i class="fa fa-fw fa-edit"></i></button></h6>
            <h6>Botão de Deletar:<button  class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button></h6></h6>


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
