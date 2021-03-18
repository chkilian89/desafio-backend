@extends('painel.basetemplate')
@section('content')

<div id="knockoutContainer" data-bind="with: viewModel">

    <div class="row" data-bind="with: userInfo">
        {{-- <div class="col-12 jumbotron text-center">
            <h1>Seja bem vindo ao painel administrativo!</h1>
        </div> --}}
        <div class="col-12 container-m-nx container-m-ny theme-bg-white mb-4">
            <div class="media col-12 mx-auto">
                <div class="media-body ml-5">
                    <h4 class="font-weight-bold mb-4">{{ Auth::user()->usu_nome }}</h4>

                    <div class="text-muted mb-4">
                        Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro
                        principes ei has.
                    </div>

                    <a href="javascript:void(0)" class="d-inline-block text-body ml-3">
                        <strong>R$ </strong>
                        <strong data-bind="numerico: valor, precisao: 2"></strong>

                    </a>
                </div>
            </div>
            <hr class="m-0">
        </div>
    </div>

    <div class="row">
        <button type="button" class="btn btn-success" data-bind="click: $root.addSaldo">Adicionar Saldo</button>&nbsp;
        @if (Auth::user()->per_id == 2)
            <button type="button" class="btn btn-danger" data-bind="click: $root.transfSaldo">Transferir / Pagar</button>
        @endif
    </div>

    <div class="row mt-2">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">DATA</th>
                    <th scope="col">AÇÃO</th>
                    <th scope="col">VALOR</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listaHistorico">
                <tr data-bind="attr: {'class': classe }">
                    <td><span data-bind="text: data"></span></th>
                    <td><span data-bind="text: acao"></span></td>
                    <td>R$ <span data-bind="text: valor"></span></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Modal ADD SALDO -->
        <div class="modal fade bd-example-modal-sm" id="modalAddSaldo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bind="with: modal_addSaldo">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar saldo a conta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" data-bind="numerico: valor, precisao: 2" placeholder="Valor em R$">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bind="click: cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-bind="click: salvar">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- FIM Modal ADD SALDO -->

    <!-- Modal TRANSFERIR SALDO -->
    <div class="modal fade bd-example-modal-sm" id="modalTransferirSaldo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bind="with: modal_transfSaldo">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tranferir / Pagar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <select class="form-control" id="periodo" data-bind="
                                    options:$root.listaUsuarios,
                                    optionsText:'usu_nome',
                                    optionsValue:'usu_id',
                                    optionsCaption:'Selecione um usuário',
                                    value:payee,
                                "></select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col">
                                <input type="text" class="form-control" data-bind="numerico: value, precisao: 2" placeholder="Valor em R$">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bind="click: cancelar">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-bind="click: salvar">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal TRANSFERIR SALDO -->

</div>
@endsection
@section('footerjs')
<script type="text/javascript">
    let url = "{{route('painel.get-dados')}}",
    url_addSaldo = "{{route('painel.adicionar-saldo')}}",
    url_transferir = "{{route('painel.transferir-saldo')}}"
    ;
</script>
<script src="{{ asset('assets/components/js/painel/home.js') }}" crossorigin="anonymous"></script>
@endsection
