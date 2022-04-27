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
                      <a class="nav-link" id="pills-academicos-tab" data-toggle="pill" href="#pills-academicos" role="tab" aria-controls="pills-academicos" aria-selected="false">Acadêmicos</a>
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


                            <h6>Nesta tela é possivel agendar novas reservas</h6>
                                    <br>
                                    <h6>Ao carregar a pagina é exibido 3 opções de reservas <b>Acadêmicos</b>,<b>Disciplinas</b> e <b>Externo</b></h6>

                                    <h6><b>Exemplo:</b></h6>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_reserva" value="3" id="academico" tabindex="1" >
                                            <label class="form-check-label" for="gridRadios1">
                                            Acadêmicos
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

                                    <h6>Estas opções mudam o formulário de cadastro para novas reservas</h6>

                                    <h6>Clique nos botões acima para visualizar mais orientações sobre cada tipo de reserva</h6>
                                </div>


                        <div class="tab-pane fade" id="pills-academicos" role="tabpanel" aria-labelledby="pills-academicos-tab">
                            {{--  ACADEMICOS --}}
                            <h6>No formulário para para acadêmicos você deverá preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>
                            <br>




                            <br>

                                <h6>Após isso selecione um acadêmico para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Maria das Graças</option><option>João da Silva</option></select></div>

                                <br>

                                <h6>Ao final do formulário é possivel colocar uma observação caso queira informar alguma solicitação, por exemplo: uma instalação de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observação" aria-required="true"></textarea>
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
                            <h6>No formulário para disciplinas você deverá preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>

                            <h6>Após isso selecione data e hora para inicio da reserva do laboratório clique sobre o botão com icone de calendario</h6>


                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>

                            <br>
                            <h6>Após isso selecione a quantidade de aulas que esta disciplina terá, lembrando que caso haja divisão de turmas (<i>MA,MB ou NA,NB</i>) não é necessário criar uma nova reserva para cada turma, basta selecionar a quantidade de aulas seguidas da mesma disciplina.</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>1 aula</option><option>2 aulas</option><option>3 aulas</option><option>4 aulas</option></select></div>
                            <h6><b><i>Obs: O sistema verifica se o horário está disponivel para o laborátorio selecionado</i></b></h6>

                            <br>




                            <h6>Após isso selecione uma disciplina para criar uma nova reserva</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Banco de Dados</option><option>Linguagens de Programação </option><option>Projeto de Sistemas de Informação</option></select></div>
                            <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outras disciplinas limpe o campo e selecione a disciplina desejada</i></b></h6>




                            <br>

                                <h6>Após isso selecione um professor para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Diolete</option><option>Ezequiel</option><option>Idomar</option></select></div>
                                <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outros professores limpe o campo e selecione o professor desejado</i></b></h6>

                                <br>

                                <h6>Ao final do formulário é possivel colocar uma observação caso queira informar alguma solicitação, por exemplo: uma instalação de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observação" aria-required="true"></textarea>

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
                            <h6>No formulário para para solicitantes externos você deverá preencher o campo <b>Laboratorio</b> clicando sobre o campo e escolhendo ou digitando um laboratorio</h6>
                            <h6><b>Exemplo:</b></h6>
                            <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Lab 05</option><option>CCA 04</option></select></div>
                            <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outros laboratorios limpe o campo e selecione o laboratorio desejado</i></b></h6>
                            <br>
                            <h6>Após isso selecione data e hora para inicio do agendamento para rereserva do laboratório clique no botão com icone de calendario</h6>

                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>


                            <h6>Após isso selecione data e hora para termino do agendamento para rereserva do laboratório clique no botão com icone de calendario</h6>


                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <h6><b><i>Obs: O sistema verifica se o horário está disponivel para o laborátorio selecionado</i></b></h6>
                            <br>

                                <h6>Após isso selecione um solicitante externo para criar uma nova reserva</h6>
                                <h6><b>Exemplo:</b></h6>
                                <div class="col-sm-3"><select class="form control select2-single"  multiple><option>Antonio Carlos</option><option>Pedro Bass</option></select></div>

                                <br>

                                <h6>Ao final do formulário é possivel colocar uma observação caso queira informar alguma solicitação, por exemplo: uma instalação de algum programa especifico para fins de ensino/pesquisa</h6>
                                <h6><b>Exemplo:</b></h6>
                                <textarea cols="20" rows="2" class="form-control{{ $errors->has('observacao') ? ' is-invalid' : '' }}"
                        name="observacao" id="input-description" type="text"
                        placeholder="Observação" aria-required="true"></textarea>

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
