@extends('adminlte::page')


@section('template_title')
    Editar Solicitante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <h4><strong>   <span class="card-title">Editar Solicitante</span> </strong></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitante.update', $solicitante->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('solicitante.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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


                <div class="modal-body">
                    <h6>Para editar um solicitante basta editar os campos como:<b>Nome do Solicitante</b>,<b>Email do Solicitante</b> e <b>Função</b></h6>
                    <h6>Os dados do solicitante serão carregados nos campos para que seja possivel altera-los</h6>

                    <div class="col-sm-5">
                        <h6><b>Exemplo:</b></h6>
                    <label>Nome do solicitante</label>
                    <div class="input-group-prepend"><input type="text" class="form-control" aria-describedby="basic-addon3" value="Ana Maria">
                    </div>
                    </div>

                    <br>
                    <h6>Após preencher os dados selecione uma nova função para o solicitante.</h6>
                    <h6><b>Exemplo:</b></h6>
                    <div class="col-sm-5"><select class="form control select2-single" id="help" multiple><option selected>Acadêmico</option><option>Externo</option></select></div>
                    <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outras funções limpe o campo e selecione a função desejada</i></b></h6>
                    <br>



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
