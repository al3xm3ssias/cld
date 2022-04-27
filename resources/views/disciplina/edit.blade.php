@extends('adminlte::page')


@section('template_title')
    Editar uma disciplina
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar  disciplina</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('disciplinas.update', $disciplina->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('disciplina.form')

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
                <h6>Para cadastrar uma nova disciplina basta preencher os campos como:<b>Nome da Disciplina</b> e <b>Turno</b>.</h6>

                <div class="col-sm-6">
                    <h6><b>Exemplo:</b></h6>
                <label>Nome da Disciplina</label>
                <div class="input-group-prepend"><input type="text" class="form-control" aria-describedby="basic-addon3" value="Projetos e Sistemas de Informação"></div>

                </div>



                <br>
                <h6>Após isso selecione a qual turno do dia esta disciplina é realizada.</h6>
                <h6><b>Exemplo:</b></h6>
                <div class="col-sm-6"><select class="form control select2-single" id="help" multiple><option selected>Manhã</option><option>Tarde</option><option>Noturno</option></select></div>
                <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outras disciplinas limpe o campo e selecione a disciplina desejado</i></b></h6>

                <br>

                <h6>Ao final do preenchimento dos dados clique em <b>Confirmar</b></h6>
                <h6><b>Exemplo:</b></h6>
                <button type="submit" class="btn btn-sm btn-primary">Confirmar</button>
                <input type="button" class="btn btn-sm btn-danger" value="Voltar">



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
