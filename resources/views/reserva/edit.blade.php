@extends('adminlte::page')


@section('template_title')
    Editar Reserva
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')






                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar Reserva</span>
                    </div>
                    <div class="card-body">
                        <form  method ="POST" action="{{ route('reservas.update', $reserva->id) }}"  role="form" enctype="multipart/form-data">

                            {{ method_field('PATCH') }}
                            @csrf


                            @include('reserva.formedit')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-inicial-tab" data-toggle="pill" href="#pills-inicial" role="tab" aria-controls="pills-inicial" aria-selected="true">Inicial</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-academicos-tab" data-toggle="pill" href="#pills-academicos" role="tab" aria-controls="pills-academicos" aria-selected="false">Acad??micos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-disciplinas-tab" data-toggle="pill" href="#pills-disciplinas" role="tab" aria-controls="pills-disciplinas" aria-selected="false">Disciplinas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-externo-tab" data-toggle="pill" href="#pills-externo" role="tab" aria-controls="pills-externo" aria-selected="false">Externo</a>
                      </li>
                  </ul>


                  <div class="tab-content" id="pills-tabContent">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-inicial" role="tabpanel" aria-labelledby="pills-inicial-tab">
                           {{--  INICIO DO MODAL DE AJUDA --}}


                            <h6>Nesta tela ?? possivel agendar novas reservas</h6>
                                    <br>
                                    <h6>Ao carregar a pagina ?? exibido 3 op????es de reservas <b>Acad??micos</b>,<b>Disciplinas</b> e <b>Externo</b></h6>

                                    <h6><b>Exemplo:</b></h6>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_reserva" value="3" id="academico" tabindex="1" >
                                            <label class="form-check-label" for="gridRadios1">
                                            Acad??micos
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_reserva" value="1" id="disciplinas" tabindex="2">
                                            <label class="form-check-label" for="gridRadios1">
                                                Disciplinas
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_reserva" value="2" id="externo" tabindex="3">
                                            <label class="form-check-label" for="gridRadios1">
                                                Externo
                                            </label>
                                        </div>

                                    <h6>Estas op????es mudam o formul??rio de cadastro para novas reservas</h6>

                                    <h6>Clique nos bot??es acima para visualizar mais orienta????es sobre cada tipo de reserva</h6>
                                </div>


                        <div class="tab-pane fade" id="pills-academicos" role="tabpanel" aria-labelledby="pills-academicos-tab">
                            {{--  ACADEMICOS --}}
                            <h6>No formul??rio para para acad??micos voc?? dever?? preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: S?? ?? possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>
                            <br>




                            <br>

                                <h6>Ap??s isso selecione um acad??mico para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Maria das Gra??as</option><option>Jo??o da Silva</option></select></div>

                                <br>

                                <h6>Ao final do formul??rio ?? possivel colocar uma observa????o caso queira informar alguma solicita????o, por exemplo: uma instala????o de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observa????o" aria-required="true"></textarea>
                            <br>
                                <h6>Ao final clique em <b>Confirmar</b> para salvar a reserva ou em <b>Voltar</b></h6>
                                <h6>Exemplo:</h6>
                                <div class="box-footer mt20">
                                    <button type="button" class="btn btn-primary">Confirmar</button>
                                    <button type="button" class="btn btn-danger">Voltar</button>
                                </div>
                        </div>
                        {{--  DISCIPLINAS --}}
                        <div class="tab-pane fade" id="pills-disciplinas" role="tabpanel" aria-labelledby="pills-disciplinas-tab">
                            <h6>No formul??rio para disciplinas voc?? dever?? preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: S?? ?? possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>

                            <h6>Ap??s isso selecione data e hora para inicio da reserva do laborat??rio clique sobre o bot??o com icone de calendario</h6>


                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>

                            <br>
                            <h6>Ap??s isso selecione a quantidade de aulas que esta disciplina ter??, lembrando que caso haja divis??o de turmas (<i>MA,MB ou NA,NB</i>) n??o ?? necess??rio criar uma nova reserva para cada turma, basta selecionar a quantidade de aulas seguidas da mesma disciplina.</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>1 aula</option><option>2 aulas</option><option>3 aulas</option><option>4 aulas</option></select></div>
                            <h6><b><i>Obs: O sistema verifica se o hor??rio est?? disponivel para o labor??torio selecionado</i></b></h6>

                            <br>




                            <h6>Ap??s isso selecione uma disciplina para criar uma nova reserva</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Banco de Dados</option><option>Linguagens de Programa????o </option><option>Projeto de Sistemas de Informa????o</option></select></div>
                            <h6><b><i>Obs: S?? ?? possivel selecionar 1 item por vez, por tanto para visualizar outras disciplinas limpe o campo e selecione a disciplina desejada</i></b></h6>




                            <br>

                                <h6>Ap??s isso selecione um professor para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Diolete</option><option>Ezequiel</option><option>Idomar</option></select></div>
                                <h6><b><i>Obs: S?? ?? possivel selecionar 1 item por vez, por tanto para visualizar outros professores limpe o campo e selecione o professor desejado</i></b></h6>

                                <br>

                                <h6>Ao final do formul??rio ?? possivel colocar uma observa????o caso queira informar alguma solicita????o, por exemplo: uma instala????o de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observa????o" aria-required="true"></textarea>

                        <br>
                                <h6>Ao final clique em <b>Confirmar</b> para salvar a reserva ou em <b>Voltar</b></h6>
                                <h6>Exemplo:</h6>
                                <div class="box-footer mt20">
                                    <button type="button" class="btn btn-primary">Confirmar</button>
                                    <button type="button" class="btn btn-danger">Voltar</button>
                                </div>

                        </div>

                        <div class="tab-pane fade" id="pills-externo" role="tabpanel" aria-labelledby="pills-externo-tab">
                        {{--  SOLICITANTES EXTERNOS --}}
                            <h6>No formul??rio para para solicitantes externos voc?? dever?? preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: S?? ?? possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>
                            <br>
                            <h6>Ap??s isso selecione data e hora para inicio do agendamento para rereserva do laborat??rio clique no bot??o com icone de calendario</h6>

                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>


                            <h6>Ap??s isso selecione data e hora para termino do agendamento para rereserva do laborat??rio clique no bot??o com icone de calendario</h6>


                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <h6><b><i>Obs: O sistema verifica se o hor??rio est?? disponivel para o labor??torio selecionado</i></b></h6>
                            <br>

                                <h6>Ap??s isso selecione um solicitante externo para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Antonio Carlos</option><option>Pedro Bass</option></select></div>

                                <br>

                                <h6>Ao final do formul??rio ?? possivel colocar uma observa????o caso queira informar alguma solicita????o, por exemplo: uma instala????o de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observa????o" aria-required="true"></textarea>

                        <br>
                        <h6>Ao final clique em <b>Confirmar</b> para salvar a reserva ou em <b>Voltar</b></h6>
                        <h6>Exemplo:</h6>
                        <div class="box-footer mt20">
                            <button type="button" class="btn btn-primary">Confirmar</button>
                            <button type="button" class="btn btn-danger">Voltar</button>
                        </div>
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


@section('js')

<script>

    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000);
    });
    </script>
@endsection
