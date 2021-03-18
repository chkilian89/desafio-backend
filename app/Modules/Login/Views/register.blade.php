@extends('painel.shared.masterpage')
@section('maincontainer')
<style>
    .login-container {
        border-radius: 5px;
        border: 2px solid rgba(95, 95, 95, 0.9);
        background-color: #FFFFFF;
        top: 10vw;
        padding: 3em;
    }
</style>
<div class="container" id="loginko">
    <form>
        <div class="row justify-content-md-center form-group">
            <div class=" col col-md-6 col-lg-4 login-container" style="margin-top: -70px">
                <row class="form-row">
                    <div class="col mb-3">
                        <img class="mx-auto d-block rounded-circle"
                            src="{{asset('assets/chktecnologia/img/favicon.png')}}" alt="chktecnologia" />
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="text" class="form-control" placeholder="Nome"
                            data-bind="value:usu_nome, valueUpdate:'afterkeydown'" maxlength="156">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="text" class="form-control" placeholder="E-mail"
                            data-bind="value:usu_email, valueUpdate:'afterkeydown'" maxlength="156">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="text" class="form-control" placeholder="Usuário"
                            data-bind="value:usu_username,valueUpdate:'afterkeydown'" maxlength="156">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="text" class="form-control"  placeholder="Documento (só números)"
                            data-bind="value:usu_documento,valueUpdate:'afterkeydown'" maxlength="80">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="password" class="form-control" placeholder="Senha"
                            data-bind="value:usu_senha,valueUpdate:'afterkeydown'" maxlength="16" autocomplete="on">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <input type="password" class="form-control" placeholder="Confirme a Senha"
                            data-bind="value:usu_senha2,valueUpdate:'afterkeydown'" maxlength="16" autocomplete="on">
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <select class="form-control" data-bind="
                            options:listaPerfil,
                            optionsText:'per_desc',
                            optionsValue:'per_id',
                            optionsCaption:'Selecione um perfil',
                            value:selectedPerfil
                        "></select>
                    </div>
                </row>
                <row class="form-row">
                    <div class="col mb-3">
                        <button class="btn btn-info float-right" data-bind="click:logar">Salvar</button>
                    </div>
                </row>
            </div>
        </div>
    </form>
</div>
<script>
    var vmlogin = new LoginModel;
        function LoginModel()
        {
            var me = this;
            me.listaPerfil = ko.observableArray([{'per_id' : 1, 'per_desc' : 'Vendedor'}, {'per_id' : 2, 'per_desc' : 'Usuário'} ]);
            me.selectedPerfil = ko.observable();
            me.usu_nome = ko.observable().extend({
                required:{message:'O campo nome é obrigatório'},
                maxLenght:{params:156,message:'O campo nome tem tamanho máximo de 156 caracteres'}
            });
            me.usu_senha = ko.observable().extend({
                required:{
                    message:'Por favor, informe uma senha.',
                },
                minLength: {params: 6, message: 'Senha de no mínimo 6 caracteres.'},
                maxLenght:{params:16,message:'O campo senha tem tamanho máximo de 16 caracteres'}
            });
            me.usu_senha2 = ko.observable().extend({
                required:{
                    message:'Por favor, repita sua senha.',
                },
                minLength: {params: 6, message: 'Senha de no mínimo 6 caracteres.'},
                maxLenght:{params:16,message:'O campo senha tem tamanho máximo de 16 caracteres'},
                equal: {
                    params: me.usu_senha,
                    message: 'Senhas não são iguais.',
                }
            });
            me.usu_documento = ko.observable().extend({
                required:{message:'O campo documento é obrigatório'},
                DOC:{params:true, message:"Documento inválido"}
            });
            me.usu_email = ko.observable().extend({
                required:{ message: 'O campo e-mail é obrigatório.'},
                email: { message: 'E-mail inválio.'}
            });
            me.usu_username = ko.observable().extend({
                required:{message:'O campo usuário é obrigatório'},
                maxLenght:{params:156,message:'O campo usuário tem tamanho máximo de 156 caracteres'}
            });
            me.erros = ko.validation.group(me);

            me.logar = function()
            {
                if(me.erros().length>0)
                {
                    ko.utils.arrayForEach(me.erros(),function(err){
                        Alert.error(err,'Validação');
                    });
                    return;
                }
                let payload = {
                    usu_nome : ko.unwrap(me.usu_nome),
                    usu_email : ko.unwrap(me.usu_email),
                    usu_documento : ko.unwrap(me.usu_documento),
                    usu_username  : ko.unwrap(me.usu_username),
                    usu_senha : base._ecryptSha1(ko.unwrap(me.usu_senha)),
                    per_id : ko.unwrap(me.selectedPerfil)
                };
                base.post("{{route('login.saveUser')}}",payload,function(resp){
                    if(resp.status == 1){
                        window.location.href = "{{ route('painel.inicio') }}";
                    } else {
                        Alert.error(resp.message);
                    }
                })
            }
        }
        $(function()
        {
            ko.applyBindings(vmlogin,document.getElementById('loginko'));
            $("body").css('background-image', 'url("{{ asset('assets/chktecnologia/img/view-poll-background.jpg') }} ")');
        })
</script>
@stop
