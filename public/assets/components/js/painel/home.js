let viewModel = new ViewModel;

function transferirSaldo(obj, refs)
{
    let self        = this;
    self.value      = ko.observable();//value
    self.payer      = ko.observable();//pagador
    self.payee      = ko.observable();//recebedor


    self.salvar = function()
    {
        base.post(url_transferir, {
            "value" : self.value(),
            "payer" : base.Auth.usu_id,
            "payee" : self.payee(),
        }, function(data){
            if(data.status)
            {
                refs.setData();
                refs.openModalTransferirSaldo(false);
            }
            if (data.status == 0) {
                let errors = base.handle_error(data);
                if (errors) Alert.error(errors, lang('app.standards.alertTitle.error'));
            }
            return;
        });
    };

    self.cancelar = function()
    {
        refs.modal_transfSaldo(null);
        refs.openModalTransferirSaldo(false);
    };
}

function adicionarSaldo(obj, refs)
{
    let self        = this;
    self.valor      = ko.observable();

    self.salvar = function()
    {
        base.post(url_addSaldo, {
            "valor" : self.valor(),
            "user_id" : base.Auth.usu_id
        }, function(data){
            if(data.status)
            {
                refs.setData();
                refs.openModalAddSaldo(false);
            }
            if (data.status == 0) {
                let errors = base.handle_error(data);
                if (errors) Alert.error(errors, lang('app.standards.alertTitle.error'));
            }
            return;
        });
    };

    self.cancelar = function()
    {
        refs.openModalAddSaldo(false);
    };
}

function userInfoHeader(obj, refs)
{
    let self        = this;
    self.user_nome  = ko.observable(obj.usu_nome);
    self.valor      = ko.observable(obj.valor);
}

function userHistorico(obj, refs)
{
    let self            = this;
    self.cat_id         = ko.observable(obj.cat_id);
    // self.user_from      = ko.observable(obj.user_from);
    // self.user_to        = ko.observable(obj.user_to);
    self.classe         = ko.observable(obj.classe);
    self.acao           = ko.observable(obj.acao);
    self.valor          = ko.observable(base._fomartMoeda(obj.valor));
    self.data           = ko.observable(moment(obj.created_at).format('DD/MM/YYYY HH:mm:ss'));


}

function ViewModel()
{
    let self                = this;
    self.userInfo           = ko.observable();
    self.listaHistorico     = ko.observableArray();
    self.listaUsuarios      = ko.observableArray();
    self.modal_addSaldo     = ko.observable();
    self.modal_transfSaldo  = ko.observable();

    self.openModalAddSaldo = function (action) {
        $("#modalAddSaldo").modal(action ? 'show' : 'hide');
    };

    self.openModalTransferirSaldo = function (action) {
        $("#modalTransferirSaldo").modal(action ? 'show' : 'hide');
    };

    self.makeHistorico = function(tmp)
    {
        return new userHistorico(
            tmp, {
            }
        );
    };

    self.makeDados = function(obj)
    {
        self.listaHistorico(
            ko.utils.arrayMap(obj.historico, function(i){
                return self.makeHistorico(i);
            })
        );

        self.userInfo(new userInfoHeader(obj.carteira));
        self.listaUsuarios(obj.usuarios);
    };

    self.addSaldo = function()
    {
        self.modal_addSaldo(new adicionarSaldo({}, {
            setData : self.setData,
            modal_addSaldo : self.modal_addSaldo,
            openModalAddSaldo : self.openModalAddSaldo
        }));
        self.openModalAddSaldo(true);
    };

    self.transfSaldo = function()
    {
        self.modal_transfSaldo(new transferirSaldo({}, {
            setData : self.setData,
            modal_transfSaldo : self.modal_transfSaldo,
            openModalTransferirSaldo : self.openModalTransferirSaldo
        }));
        self.openModalTransferirSaldo(true);
    };

    self.setData = function ()
    {
        base.post(url,{}, function(resp){
            if(resp.status == 1)
            {
                self.makeDados(resp.response);
            }
            if (resp.status == 0) {
                let errors = base.handle_error(resp);
                if (errors) Alert.error(errors, lang('app.standards.alertTitle.error'));
            }
            return;
        });
    }
}

viewModel.setData();
$(document).ready(function () {
    ko.applyBindingsWithValidation(viewModel, document.getElementById('knockoutContainer'), _KNOCKOUT_OVERRIDE_VALIDATION);
});
