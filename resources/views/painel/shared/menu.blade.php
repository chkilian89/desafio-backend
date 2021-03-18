<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#">
        <img class="rounded-circle" src="{{ asset('assets/chktecnologia/img/chk-ico-fundo-branco.png') }}" width="30" height="30" alt="chktecnologia">
        {{env('APP_NAME')}}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ (Route::currentRouteName() == 'painel.inicio') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('painel.inicio')}}">Início <span class="sr-only">(current)</span></a>
            </li>


        </ul>
        <ul class="navbar-nav">
            <div id="knockoutMenuContainer" data-bind="with: menuViewModel">
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter" data-bind="text: countLista"></span>
                    </a>
                    <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Notificações
                            </h6>

                            <div data-bind="foreach: listaNotification">
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    {{-- <div class="mr-3">
                                        <div class="icon-circle bg-danger">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div> --}}
                                    <div>
                                        <div class="small text-gray-500">
                                                <strong><span data-bind="date: not_date_insert, format: 'DD/MM/YYYY HH:mm' "></span></strong>
                                        </div>
                                        <span data-bind="text: not_desc"></span>
                                    </div>
                                </a>
                                <hr>

                            </div>

                            <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar todos os alertas</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">{{ Auth::user()->usu_username }}</a></li>
                <li class="nav-item"><a href="{{route('login.logout')}}" class="nav-link">Sair</a></li>
            </div>
        </ul>
    </div>
</nav>
<script>
    let menuViewModel = new MenuViewModel;

    function MenuViewModel()
    {
        let self                  = this;

        self.listaNotification    = ko.observableArray();
        self.countLista           = ko.observable(0);

        self.count = function()
        {
            let a = [];
            ko.utils.arrayMap(self.listaNotification(), function (i) {
                if(i.not_date_read === null)
                {
                    i.not_date_insert = moment(i.not_date_insert).format('DD/MM/YYYY HH:MM');
                    a.push(i);
                }
            });
            return self.countLista(a.length);
        }

        self.setData = function()
        {
            base.post("{{route('notifications.getNotificaoes')}}", {}, function(resp){
                if(resp.status == 1){
                    self.listaNotification(resp.response);
                    self.count();
                }
            }, true);

        }

    }

    menuViewModel.setData();
    $(document).ready(function () {
        ko.applyBindingsWithValidation(menuViewModel, document.getElementById('knockoutMenuContainer'), _KNOCKOUT_OVERRIDE_VALIDATION);
    });
    window.setInterval('menuViewModel.setData()', 2500);
</script>
