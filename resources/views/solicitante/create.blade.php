@extends('adminlte::page')


@section('template_title')
    Cadastrar um novo solicitante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <h4><strong>  <span class="card-title">Cadastrar novo solicitante</span> </strong></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitante.store') }}"  role="form" enctype="multipart/form-data">
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
            <h6>Para cadastrar um novo solicitante basta prenche os campos como:<b>Nome do Solicitante</b>,<b>Email do Solicitante</b> e <b>Função</b></h6>


            <div class="col-sm-5">
                <h6><b>Exemplo:</b></h6>
            <label>Nome do solicitante</label>
            {{ Form::text('nome', $solicitante->nome, ['class' => 'form-control' , 'placeholder' => 'Nome']) }}
            </div>

            <br>
            <h6>Após preencher os dados selecione uma função para o solicitante.</h6>
            <h6><b>Exemplo:</b></h6>
            <div class="col-sm-5"><select class="form control select2-single" id="help" multiple><option>Acadêmico</option><option>Externo</option></select></div>
            <h6><b><i>Obs: Só é possivel selecionar 1 item por vez, por tanto para visualizar outras funções limpe o campo e selecione a função desejada</i></b></h6>
            <br>



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

<script  type="text/javascript">
    $(document).ready(function() {
     $('#help').select2({

     placeholder: "Selecione os itens",

     width: '100%',

     maximumSelectionLength: 1,
     language: "pt-BR",
   });

 });
     </script>

@endsection
