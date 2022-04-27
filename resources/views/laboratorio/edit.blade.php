@extends('adminlte::page')


@section('template_title')
    Cadastrar novo laboratorio
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar  laboratorio</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('laboratorios.update', $laboratorio->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('laboratorio.form')

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
                <h6>Para editr laboratório basta editar os campos como:<b>Número do Laboratório</b>, <b>Apelido</b> e se possui alguma <b>Restrição de acesso</b></h6>
                <h6>Os dados do laboratório serão carregados nos campos para que seja possivel altera-los</h6>

                <div class="col-sm-6">
                    <h6><b>Exemplo:</b></h6>
                <label>Número do Laboratório</label>
                <div class="input-group-prepend"><input type="text" class="form-control" aria-describedby="basic-addon3" value="Lab 08"></div>

                </div>

                <div class="col-sm-6">
                    <label>Apelido do Laboratório</label>
                    <div class="input-group-prepend"><input type="text" class="form-control" aria-describedby="basic-addon3" value="Laboratorio de computação"></div>
                </div>

                <br>
                <h6>Após preencher os dados selecione se o laboratório possui alguma restrição de acesso.</h6>
                <h6><b>Exemplo:</b></h6>
                <div class="col-sm-3"><select class="form control select2-single" id="help" multiple><option selected>Não</option><option>Sim</option></select></div>
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
