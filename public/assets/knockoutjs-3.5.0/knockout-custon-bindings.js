/*
	 exemplo de como criar um componente knockout
	ko.bindingHandlers.yourBindingName = {
		init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
			// This will be called when the binding is first applied to an element
			// Set up any initial state, event handlers, etc. here
		},
		update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
			// This will be called once when the binding is first applied to an element,
			// and again whenever any observables/computeds that are accessed change
			// Update the DOM element based on the supplied values here.
		}
	};
*/

/*
	AUTOCOMPLETE
		MODO DE USO:
			<input
				type="text"
				data-bind="
					autocomplete:<o ko.obervable do objeto que irá receber o valor>,
					source:'<a url do controller para onde a chamada deve ser direcionada>',
					render: <opcional, callback que monta as opções do autocomplete quando o retono não é chave=>valor>
					onselect: <opcional, callback com a ação de onselect do inpu
				"
			/>
*/
ko.bindingHandlers.autocomplete = {
    init: function (element, valueAccessor, allBindings) {
        var value = valueAccessor();
        var urlSource = allBindings.get('source');
        var render = allBindings.get('render');
        var onselect = allBindings.get('onselect');
        var opcoes = allBindings.get('opcoes');
        var customrequest = allBindings.get('customrequest');
        //  atribuindo automaticamente um loading para sinalizar o carregamento
        $(element).parent().append("<img class='loading-gif-ui-autocomplete'src='" + GLOBAL_PATH_LOADING_GIF_KNOCKOUT + "' style='display:none;width: 15px;position: relative;float: right;top: -25px;left: -15px;'>");

        $(element).autocomplete({
            source: function (request, response) {
                $(element).parent().find('img.loading-gif-ui-autocomplete').show();
                if (opcoes) {
                    var filtrados = opcoes;
                    if (request.term != null) {
                        filtrados = ko.utils.arrayFilter(filtrados, function (i) {
                            return i.toString().toLowerCase().indexOf(request.term.toString().toLowerCase()) != -1;
                        });
                    }
                    response(filtrados);
                    $(element).parent().find('img.loading-gif-ui-autocomplete').hide();
                } else {
                    if (!!customrequest && typeof (customrequest) == 'function') {
                        customrequest(request, response, $(element).parent().find('img.loading-gif-ui-autocomplete'));
                    } else {
                        $.post(urlSource, {
                                'term': request.term
                            })
                            .done(function (data) {
                                // por problemas de exibição nos modais. trazer o z-indez da lista para frente sempre
                                $(".ui-autocomplete").css('z-index', '999999');
                                var dados = data; //JSON.parse(data);
                                // para customizar a renderização dos dados como concatenação de id - nome fazer um callback que receba os dados e formate em array
                                if (render != null) {
                                    response(render(dados));
                                }
                                // senão trazer os dados formatados em array direto do service
                                else {
                                    response(dados);
                                }
                            }).fail(function (error) {
                                console.log('Um erro ocorreu no componente de autocomplete.');
                                console.log(error);
                            }).always(function () {
                                $(element).parent().find('img.loading-gif-ui-autocomplete').hide();
                            });
                    }
                    // $(element).parent().find('img.loading-gif-ui-autocomplete').show();
                }
            },
            minlength: 3,
            select: function (event, ui) {
                // sempre que selecionado o valor do input recebe a string no observable... para fazer uma pos exexução setar o callback onselect
                valueAccessor()(ui.item.value);
                if (onselect != null) {
                    onselect(event, ui);
                }
            }
        });
        ko.utils.registerEventHandler(element, 'focusout', function () {
            var observable = valueAccessor();
            observable($(element).val());
        });

        ko.utils.registerEventHandler(element, 'keypress', function (e) {
            if (e.which == 13) {
                var observable = valueAccessor();
                observable($(element).val());
            }
        });
    },
    update: function (element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor());
        $(element).val(value);
    }
};
ko.validation.makeBindingHandlerValidatable('autocomplete');

// ko.bindingHandlers.multiselect = {
//     init: function (element, valueAccessor, allBindingAccessors) {
//         "use strict";

//         var options = valueAccessor();

//         $(element).multiselect({
// 		    click: function(event, ui)
// 		    {
// 		        if(ui.checked)
// 		        {
// 		            options.selectedOptions.push(ui.value);
// 		        }
// 		        else
// 		        {
// 		            var indice = options.selectedOptions().indexOf(ui.value);
// 		            options.selectedOptions().splice(indice, 1);
// 		        }
// 		    },
// 		    checkAll: function(event, ui)
// 		    {
// 				options.selectedOptions(
// 					ko.utils.arrayMap(options.options(), function(item) {
// 						return item.id;
// 					})
// 				);
// 		    },
// 		    uncheckAll: function(event, ui)
// 		    {
// 		   		options.selectedOptions([]);
// 		    }
// 		}).multiselectfilter();
//     },
//     update: function (element, valueAccessor, allBindingAccessors) {
//         "use strict";

//         var options = valueAccessor();

//         ko.bindingHandlers.options.update(
//             element,
//             function() { return options.options; },
//             allBindingAccessors
//         );

//         ko.bindingHandlers.selectedOptions.update(
//             element,
//             function () { return options.selectedOptions; },
//             allBindingAccessors
//         );

//         $(element).multiselect("refresh");
//     }
// };


/*
    MASKED
        MODO DE USO:
            <input
                type="text"
                data-bind="
                    masked:<ko.observable do objeto>
                    pattern:'<obrigatório string com o pattern desejado ex: (99) 9999-9999?9>'
                    iscell: se é celular
                "
            />
*/
ko.bindingHandlers.masked = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {

        // This will be called when the binding is first applied to an element
        // Set up any initial state, event handlers, etc. here
        var pattern = allBindings.get('pattern');
        var unmask = allBindings.get('unmask') || false;
        var iscell = allBindings.get('iscell') || false;
        if (iscell) pattern = '(99) 99999-9999';
        element.value = ko.utils.unwrapObservable(valueAccessor());
        $(element).mask(pattern);


        if (element.tagName == 'INPUT') {
            ko.utils.registerEventHandler(element, 'input', function () {
                var value = $(element).unmask().val();
                if (unmask) {
                    valueAccessor()(value);
                    setTimeout(function () {
                        // valueAccessor()(value);
                        $(element).mask(pattern);
                    }, 150);
                } else {
                    // debugger;
                    valueAccessor()($(element).val());
                }
            });
        } else {
            var input = document.createElement("INPUT");
            input.setAttribute("value", ko.utils.unwrapObservable(valueAccessor()));
            $(input).mask(pattern);
            var valueMasked = $(input).val();
            // ko.utils.unwrapObservable(valueAccessor()).toString().replace(/\D/g, '').replace(/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2}).*/, '$1.$2.$3-$4');
            element.innerHTML = valueMasked;
            input.remove();
        }
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // This will be called once when the binding is first applied to an element,
        // and again whenever any observables/computeds that are accessed change
        // Update the DOM element based on the supplied values here.
        var pattern = allBindings.get('pattern');
        var iscell = allBindings.get('iscell') || false;
        if (iscell) pattern = '(99) 99999-9999';
        var value = ko.utils.unwrapObservable(valueAccessor());
        setTimeout(function () {
            $(element).unmask();
            $(element).val(value);
            $(element).mask(pattern);
        }, 100);
    }
};
ko.validation.makeBindingHandlerValidatable('masked');

/*
		font: http://stackoverflow.com/questions/15775608/using-nicedit-with-knockout
		And how to use it:

		<textarea id="area1" data-bind="nicedit: title" style="width: 640px"></textarea>
		... where in my example "title" is your bound property of course.

		There are two "limitations":

		The textarea must have a DOM "id" attribute otherwise it crashes.
		With IE (at least, version 8) the DOMNodeInserted and DOMNodeRemoved
		are not fired, which means that you have to type something after
		modifying the style of your text for it to be properly updated in
		your observable object.
*/
ko.bindingHandlers.nicedit = {
    init: function (element, valueAccessor) {
        var value = valueAccessor();
        var area = new nicEditor({
            fullPanel: true
        }).panelInstance(element, {
            hasPanel: true
        });
        // $(element).text(ko.utils.unwrapObservable(value));

        // function for updating the right element whenever something changes
        var textAreaContentElement = $($(element).prev()[0].childNodes[0]);
        var areachangefc = function () {
            value(textAreaContentElement.html());
        };
        //setando dados na inicializaÃ§Ã£o
        textAreaContentElement.html(value());

        // Make sure we update on both a text change, and when some HTML has been added/removed
        // (like for example a text being set to "bold")
        $(element).prev().keyup(areachangefc);
        $(element).prev().bind('DOMNodeInserted DOMNodeRemoved', areachangefc);
    },
    update: function (element, valueAccessor) {
        //o update buga o esquema. migrado para o init function que ja tem o keyup e DOMNodeInserted, DOMNodeRemoved function
        /*var value = valueAccessor();
        var textAreaContentElement = $($(element).prev()[0].childNodes[0]);
        textAreaContentElement.html(value());*/
    }
};
ko.validation.makeBindingHandlerValidatable('nicedit');

/*
	NUMERICO
		MODO DE USO:
			<input
				type="text"
				data-bind="
					numerico:<ko.observable do objeto>,
					precisao:'<opcional, padrão 0. numero de casas decimais para exibição>'
				"
			/>
		OBS: por mais que a exibição mostre o numero formatado no padrão pt-BR o numero continua do tipo float no observable ;)
*/
ko.bindingHandlers.numerico = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var precisao = allBindings.get('precisao') || 0;
        var sobrescrever = allBindings.get('sobrescrever') || true;

        var valor = ko.utils.unwrapObservable(valueAccessor());
        var checker = typeof (valor) == 'string' || !valor;

        valor = valor == null || isNaN(valor) ? 0 : valor;
        valor = parseFloat(parseFloat(valor.toString()).toFixed(precisao));
        element.style.textAlign = 'right';

        if (element.tagName == 'INPUT') {
            element.value = valor.toLocaleString(Lang.number_format, {
                minimumFractionDigits: precisao,
                maximumFractionDigits: precisao
            });
            // definindo handlers para forçar o cursor permanecer a direita do input
            ko.utils.registerEventHandler(element, 'click', function () {
                setTimeout((function (element) {
                    var strLength = element.value.length;
                    return function () {
                        if (element.setSelectionRange !== undefined) {
                            element.setSelectionRange(strLength, strLength);
                        } else {
                            element.value = element.value;
                        }
                    }
                }(this)), 5);
            });
            ko.utils.registerEventHandler(element, 'focus', function () {
                setTimeout((function (element) {
                    var strLength = element.value.length;
                    return function () {
                        if (element.setSelectionRange !== undefined) {
                            element.setSelectionRange(strLength, strLength);
                        } else {
                            element.value = element.value;
                        }
                    }
                }(this)), 5);
            });
            // =======================================================================
            ko.utils.registerEventHandler(element, 'input', function () {
                var valor = element.value.replace(/\D/g, '');
                // ajuste de bug. quando o tamanho do munero é menor que a precisão, estava mudando o valor do input.
                // para solucionar, coloquei esse 'pad' para artificialmente aumentar o tamanho da strig com zeros a esquerda e
                // o parseFloat elimine os zeros desnecessários e
                var pad = '00000000000000000';

                if (valor == null || valor == '') {
                    valor = '0';
                }

                if (precisao > 0) {
                    if (valor.length < precisao) {
                        valor = pad + valor;
                    }
                    valor = parseFloat(valor.substr(0, valor.length - precisao) + '.' + valor.substr(valor.length - precisao, valor.length));
                } else {
                    valor = parseFloat(parseFloat(valor).toFixed(precisao));
                }

                element.value = valor.toLocaleString(Lang.number_format, {
                    minimumFractionDigits: precisao,
                    maximumFractionDigits: precisao
                });

                if (ko.isWriteableObservable(valueAccessor())) {
                    valueAccessor()(valor);
                }
            });
        } else {
            element.innerHTML = valor.toLocaleString(Lang.number_format, {
                minimumFractionDigits: precisao,
                maximumFractionDigits: precisao
            });
        }

        if (ko.isWriteableObservable(valueAccessor()) && checker && sobrescrever === true) {
            valueAccessor()(valor);
        }
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var precisao = allBindings.get('precisao') || 0;
        var sobrescrever = allBindings.get('sobrescrever') || true;
        var valor = ko.utils.unwrapObservable(valueAccessor());
        var checker = typeof (valor) == 'string' || !valor;

        valor = valor == null ? 0 : valor;
        valor = typeof (valor) == 'string' && valor.indexOf(",") != -1 ? valor.replace(/\./g, '').replace(",", ".") : valor;
        valor = parseFloat(valor).toFixed(precisao);
        valor = isNaN(valor) ? valor.toString().replace(/\D/g, '') : valor;

        if (valor == null || valor == '') {
            valor = 0;
        }

        valor = parseFloat(valor);

        if (element.tagName == 'INPUT') {
            element.value = valor.toLocaleString(Lang.number_format, {
                minimumFractionDigits: precisao,
                maximumFractionDigits: precisao
            });
        } else {
            element.innerHTML = valor.toLocaleString(Lang.number_format, {
                minimumFractionDigits: precisao,
                maximumFractionDigits: precisao
            });
        }

        if (ko.isWriteableObservable(valueAccessor()) && checker && sobrescrever === true) {
            valueAccessor()(valor);
        }
    }
};
ko.validation.makeBindingHandlerValidatable('numerico');

/*
	DATEPICKER
		MODO DE USO:
			<input
				type="text"
				data-bind="
					value: <ko.obervable do objeto>,
					datepicker: <ko.obervable do objeto>,
					datepickerOptions: {
						callbackOk         :<opcional callback com a ação do onselect do calendário>,
						format             :<opcional string 'yy-mm-dd' ou qualquer outra para o retono da data selecionada no observable>,
						showDays           :<opcional flag para mostrar ou não os dias no calendário>,
						showMonths         :<opcional flag para mostrar ou não os meses no calendário>,
						showYears          :<opcional flag para mostrar ou não o ano no calendário>,
						showIconsNavigation:<opcional flag para mostrar ou não os botoes de navegação do calendário>,
					}
					//TODAS ESSAS OPÇÕES PODEM ESTAR DENTRO DE UM UNICO OBJETO  SIMPLIFICANDO A CONFIGURAÇÃO
					datepickerOptions:<objeto contendo as opções>
				"
			/>
*/
ko.bindingHandlers.datepicker = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        var options = allBindingsAccessor().datepickerOptions || {};

        // valores defaul
        options.dayNames = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        options.dayNamesMin = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'];
        options.dayNamesShort = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
        options.monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        options.monthNamesShort = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        options.nextText = 'Próximo';
        options.prevText = 'Anterior';
        options.closeText = 'ok';
        options.changeMonth = true;
        options.changeYear = true;
        options.showButtonPanel = true;
        options.dateFormat = 'dd/mm/yy';
        options.format = options.format != undefined ? options.format : 'dd/mm/yy';
        options.showDays = options.showDays != undefined ? options.showDays : true;
        options.showMonths = options.showMonths != undefined ? options.showMonths : true;
        options.showYears = options.showYears != undefined ? options.showYears : true;
        options.showIconsNavigation = options.showIconsNavigation != undefined ? options.showIconsNavigation : true;

        options.onClose = function (dateText, inst) {
            var data = $.datepicker.formatDate(options.format, new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay))
            valueAccessor()(data);
            $(element).val(data);
            if (options.callbackOk != undefined && typeof (options.callbackOk) == 'function') {
                options.callbackOk();
            }
        };

        $(element).val(valueAccessor()());
        $(element).datepicker(options);

        //setando valores default para o datepicker independente da configuração de idioma
        $.datepicker.setDefaults(options);

        $(element).focus(function () {
            if (!options.showDays) $(".ui-datepicker-calendar").hide();
            if (!options.showMonths) $(".ui-datepicker-month").hide();
            if (!options.showYears) $(".ui-datepicker-year").hide();
            if (!options.showIconsNavigation) $("div.ui-datepicker-header a.ui-datepicker-prev,div.ui-datepicker-header a.ui-datepicker-next").hide();
        });

        //handle the field changing
        ko.utils.registerEventHandler(element, "change", function () {
            var observable = valueAccessor();
            observable($.datepicker.formatDate(options.format, $(element).datepicker("getDate")));
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            $(element).datepicker("destroy");
        });
    }
};
ko.validation.makeBindingHandlerValidatable('datepicker');


ko.bindingHandlers.sortable = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // This will be called when the binding is first applied to an element
        // Set up any initial state, event handlers, etc. here
        var
            list = valueAccessor(),
            defaultAction = function () {},
            actionActivate = allBindings.get('activate') || defaultAction,
            actionBeforeStop = allBindings.get('beforeStop') || defaultAction,
            actionChange = allBindings.get('change') || defaultAction,
            actionCreate = allBindings.get('create') || defaultAction,
            actionDeactivate = allBindings.get('deactivate') || defaultAction,
            actionOut = allBindings.get('out') || defaultAction,
            actionOver = allBindings.get('over') || defaultAction,
            actionReceive = allBindings.get('receive') || defaultAction,
            actionRemove = allBindings.get('remove') || defaultAction,
            actionSort = allBindings.get('sort') || defaultAction,
            actionStart = allBindings.get('start') || defaultAction,
            actionStop = allBindings.get('stop') || defaultAction
        //update           = allBindings.get('update')     || defaultAction,
        ;
        $(element).sortable({
            // containment: 'parent',
            // placeholder: 'placeholder',
            update: function (event, ui) {
                var item = ko.dataFor(ui.item[0]),
                    newIndex = ko.utils.arrayIndexOf(ui.item.parent().children(), ui.item[0]);
                if (newIndex >= list().length) newIndex = list().length - 1;
                if (newIndex < 0) newIndex = 0;

                ui.item.remove();
                list.remove(item);
                list.splice(newIndex, 0, item);
            },
            activate: function (event, ui) {
                actionActivate(event, ui);
            },
            beforeStop: function (event, ui) {
                actionBeforeStop(event, ui);
            },
            change: function (event, ui) {
                actionChange(event, ui);
            },
            create: function (event, ui) {
                actionCreate(event, ui);
            },
            deactivate: function (event, ui) {
                actionDeactivate(event, ui);
            },
            out: function (event, ui) {
                actionOut(event, ui);
            },
            over: function (event, ui) {
                actionOver(event, ui);
            },
            receive: function (event, ui) {
                actionReceive(event, ui);
            },
            remove: function (event, ui) {
                actionRemove(event, ui);
            },
            sort: function (event, ui) {
                actionSort(event, ui);
            },
            start: function (event, ui) {
                actionStart(event, ui);
            },
            stop: function (event, ui) {
                actionStop(event, ui);
            }
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // This will be called once when the binding is first applied to an element,
        // and again whenever any observables/computeds that are accessed change
        // Update the DOM element based on the supplied values here.
    }
};
ko.validation.makeBindingHandlerValidatable('sortable');


ko.bindingHandlers.filereader = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // This will be called when the binding is first applied to an element
        // Set up any initial state, event handlers, etc. here
        var conf = {
            input: $(element)[0],
            value: valueAccessor(),
            ext: allBindings.get('ext') || [], //extenções permitidas
            max: allBindings.get('max') || 1024 * 1024 * 5 //tamanho máximo permitido 5MB
        }
        ko.utils.registerEventHandler(element, 'change', function () {
            if (conf.input.files && conf.input.files[0]) {
                var f = conf.input.files[0];
                if (conf.ext.length && conf.ext.indexOf(f.name.split('.').pop()) == -1) {
                    Alert.info('O item selecionado não é do tipo esperado:' + conf.ext.toString());
                    return;
                }
                if (f.size > conf.max) {
                    Alert.info('O item selecionado é maior que o permitido:' + (conf.max / 1024 / 1024) + ' MB');
                    return;
                }
                var FR = new FileReader();
                FR.onload = function (e) {
                    conf.value({
                        name: f.name,
                        type: f.type,
                        size: f.size,
                        file: e.target.result
                    });
                }
                FR.readAsDataURL(conf.input.files[0]);
            }
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // This will be called once when the binding is first applied to an element,
        // and again whenever any observables/computeds that are accessed change
        // Update the DOM element based on the supplied values here.
    }
};
ko.validation.makeBindingHandlerValidatable('filereader');


ko.bindingHandlers.enterkey = {
    init: function (element, valueAccessor, allBindings, viewModel) {
        var callback = valueAccessor();
        $(element).keypress(function (event) {
            var keyCode = (event.which ? event.which : event.keyCode);
            if (keyCode === 13) {
                callback.call(viewModel);
            }
        });
    }
};

ko.validation.rules['url'] = {
    validator: function (value_on_input, params) {
        if (!value_on_input) return true;
        return (
            !!value_on_input &&
            (
                value_on_input.indexOf('http://') == 0 ||
                value_on_input.indexOf('https://') == 0 ||
                value_on_input.indexOf('www.') == 0
            ) &&
            (
                value_on_input.indexOf('.com') != -1 ||
                value_on_input.indexOf('.com.br') != -1 ||
                value_on_input.indexOf('.net') != -1
            )
        );
    },
    message: 'Valor informado não é um link válido'
};
ko.validation.registerExtenders();

/******************************************************** DATE Bindings *********************************************************/
ko.bindingHandlers.date = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var format = allBindings.get('format') || "DD/MM/YYYY";
        var valueUnwrapped = ko.utils.unwrapObservable(valueAccessor());
        var textContent = moment(valueUnwrapped).format(format);
        ko.bindingHandlers.text.update(element, function () {
            return textContent;
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var format = allBindings.get('format') || "DD/MM/YYYY";
        var valueUnwrapped = ko.utils.unwrapObservable(valueAccessor());
        var textContent = moment(valueUnwrapped).format(format);
        ko.bindingHandlers.text.update(element, function () {
            return textContent;
        });
    }
};
ko.validation.makeBindingHandlerValidatable('date');
/******************************************************** DATE Bindings *********************************************************/
ko.bindingHandlers.docFormat = {
    init: function (element, valueAccessor, allBindings, viewModel) {
        var valor = ko.utils.unwrapObservable(valueAccessor());
        switch (valor.length) {
            case 14:
                valor = valor.toString().replace(/\D/g, '').replace(/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2}).*/, '$1.$2.$3/$4-$5');
                break;
            case 11:
                valor = valor.toString().replace(/\D/g, '').replace(/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2}).*/, '$1.$2.$3-$4');
                break;
            default:
                valor = /*valor;*/ 'Documento Inválido.';
                break;
        }
        ko.bindingHandlers.text.update(element, function () {
            return valor;
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var valor = ko.utils.unwrapObservable(valueAccessor());
        switch (valor.length) {
            case 14:
                valor = valor.toString().replace(/\D/g, '').replace(/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2}).*/, '$1.$2.$3/$4-$5');
                break;
            case 11:
                valor = valor.toString().replace(/\D/g, '').replace(/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2}).*/, '$1.$2.$3-$4');
                break;
            default:
                valor = /*valor;*/ 'Documento Inválido.';
                break;
        }
        ko.bindingHandlers.text.update(element, function () {
            return valor;
        });
    }
};
ko.validation.makeBindingHandlerValidatable('docFormat');
/******************************************************************************************************************************/
/* BOOTSTRAP
	DATEPICKER MODO DE USO:
	<input type="text" class="form-control" data-bind="
		datepicker: <ko.observable>,
		dpotions:{callback:function(usado_quando_mudar_a_data){}},
		attr: { placeholder: '{{Lang::get('sac.screens.historic.dateLastrequest')}}' }
	">
*/
ko.bindingHandlers.datepicker2 = {
    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var options = allBindings.get('dpotions') || {};

        options.format = options.format || 'dd/mm/yyyy'; // esperando customizacao para funcionar
        options.clearBtn = options.clearBtn || true;
        options.language = options.language || 'pt-BR';
        options.multidate = options.multidate || false;
        options.disableTouchKeyboard = options.disableTouchKeyboard || false;
        options.enableOnReadonly = options.enableOnReadonly || true;
        options.keyboardNavigation = options.keyboardNavigation || false;
        options.autoclose = options.autoclose || true;
        options.forceParse = options.forceParse || true;
        options.orientation = options.orientation || 'auto';
        options.todayHighlight = options.todayHighlight || true;
        options.toggleActive = options.toggleActive || true;
        options.todayBtn = options.todayBtn || false;
        options.multidate = options.multidate || false;

        options.startView = options.startView || 0;
        options.minViewMode = options.minViewMode || 0;
        options.maxViewMode = options.maxViewMode || 4;

        options.changeMonth = options.changeMonth || true;
        options.changeYear = options.changeYear || true;

        $(element).datepicker(options)
            .on('hide', function (e) {
                var value = valueAccessor();
                if (e.date) {
                    if (moment(new Date(e.date.getFullYear(), e.date.getMonth(), e.date.getDate(), 12)).format('YYYY-MM-DD').length == 10) {
                        // value(newDate);
                        value(moment(new Date(e.date.getFullYear(), e.date.getMonth(), e.date.getDate(), 12)).format('YYYY-MM-DD'));
                    }
                } else {
                    value("");
                }
            });
    },
    update: function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        var date = ko.utils.unwrapObservable(valueAccessor());
        if (date != null) {
            if (date.length == 10) {
                date = moment(date);
                $(element).datepicker('setDate', new Date(date.format('MM/DD/YYYY', 12)));
            }
        }
    }
};
ko.validation.makeBindingHandlerValidatable('datepicker');

ko.bindingHandlers.multipleSelect = {
    init: function (element, valueAccessor, allBindingAccessors, viewModel, bindingContext) {

        var options = allBindingAccessors(),
            events = {
                onOpen: function () {
                    if (bindingContext.$root.loadingMultipleSelect != undefined)
                        setTimeout(function () {
                            bindingContext.$root.loadingMultipleSelect(true);
                        }, 200);
                },
                onClose: function () {
                    // var multipleSelectList = $('select.multipleSelect');
                    // ko.utils.arrayForEach(multipleSelectList, function(item) {

                    //     var enable = item.disabled ? 'disable' : 'enable';
                    //     $(item).multipleSelect(enable);
                    // });

                    // $('select.multipleSelect').multipleSelect('refresh');

                    if (bindingContext.$root.loadingMultipleSelect != undefined)
                        bindingContext.$root.loadingMultipleSelect(false);
                },
                // onCheckAll: function() {
                //     console.log('Check all clicked!');
                // },
                // onUncheckAll: function() {
                //     console.log('Uncheck all clicked!');
                // },
                // onFocus: function() {
                //     console.log('focus!');
                // },
                // onBlur: function() {
                //     console.log('blur!');
                // },
                // onOptgroupClick: function(view) {
                //     var values = $.map(view.children, function(child){
                //         return child.value;
                //     }).join(', ');
                //     console.log('Optgroup ' + view.label + ' ' +
                //         (view.checked ? 'checked' : 'unchecked') + ': ' + values);
                // },
                onClick: function (view) {
                    if (options.multipleSelectOptions.single) {
                        options.selectedOptions([view.value]);
                    }
                }
            };
        var allDataObjectsOptions = $.extend(options.multipleSelectOptions, events);


        $(element).multipleSelect(allDataObjectsOptions);
    },
    update: function (element, valueAccessor, allBindingAccessors, viewModel, bindingContext) {
        var data = valueAccessor(),
            options = allBindingAccessors();

        ko.bindingHandlers.options.update(
            element,
            function () {
                if (data().length == 1) {
                    options.selectedOptions([data()[0].id]);
                }
                var enable = element.disabled ? 'disable' : 'enable';
                $(element).multipleSelect(enable);

                $(element).multipleSelect("refresh");
                return data;
            },
            allBindingAccessors
        );

        // ko.bindingHandlers.disable.update(
        //     element,
        //     function () {
        //      var enable = options.disable ? 'disable' : 'enable';
        //  	$(element).multipleSelect(enable);
        // 	},
        //     allBindingAccessors
        // );

        // $(element).multipleSelect("refresh");
    }
};
ko.validation.makeBindingHandlerValidatable('multipleSelect');

/*
    cuttext:yobservable , length: 300, trailing:
    CUTTEXT MODO DE USO:
	<input type="text" class="form-control" data-bind="
		cutText: <ko.observable>,
		options:{ length : 300, trailing : '...'}
	">
*/

ko.bindingHandlers.cutText = {
        update: function (element, valueAccessor, allBindingsAccessor) {
            var options = allBindingsAccessor().options;
            options.length = options.length || 4294967295; //SAFE MAX_INT
            options.trailing = options.trailing || "";

            var value = ko.utils.unwrapObservable(valueAccessor());
            if (value.length > options.length){
                value = value.substr(0,options.length)+options.trailing;
            }
            $(element).val(value);
        }
};

/* ________________________________________________ REGISTER EXTENDERS ______________________________________________________________________________________________*/
ko.extenders.dateFormater = function (target, option) {
    target.subscribe(function (vl) {
        var t = moment(vl, 'YYYY-MM-DD HH:mm:ss');
        target(t.isValid ?
            t.format(option || 'DD/MM/YYYY') :
            null
        );
    });
    return target;
};

ko.extenders.maxLength = function (target, maxLength) {
    var result = ko.computed({
        read: target,
        write: function (val) {
            if (maxLength > 0) {
                if (val != null && val.length > maxLength) {
                    var limitedVal = val.substring(0, maxLength);
                    if (target() === limitedVal) {
                        target.notifySubscribers();
                    }
                    else {
                        target(limitedVal);
                    }
                    result.css("errorborder");
                    setTimeout(function () { result.css(""); }, 1200);
                }
                else { target(val); }
            }
            else { target(val); }
        }
    }).extend({ notify: 'always' });
    result.css = ko.observable();
    result(target());
    return result;
};

/* ________________________________________________ REGISTER RULE ________________________________________________ */
ko.validation.rules['url'] = {
    validator: function (value_on_input, params) {
        if (!value_on_input) return true;
        return (
            !!value_on_input &&
            (
                value_on_input.indexOf('http://') == 0 ||
                value_on_input.indexOf('https://') == 0 ||
                value_on_input.indexOf('www.') == 0
            ) &&
            (
                value_on_input.indexOf('.com') != -1 ||
                value_on_input.indexOf('.com.br') != -1 ||
                value_on_input.indexOf('.net') != -1
            )
        );
    },
    message: 'Valor informado não é um link válido'
};
/* Validates that all values in an array are unique.
To initialize the simple validator provide an array to compare against.
By default this will simply compare do an exactly equal (===) operation against each element in the supplied array.
For a little more control, initialize the validator with an object instead. The object should contain two properties: array and predicate.
The predicate option enables you to provide a function to define equality. The array option can be observable.
Note: This is similar to the 'arrayItemsPropertyValueUnique' rule but I find it to be more flexible/functional.

SIMPLE EXAMPLE::
model.thisProp.extend({ isUnique: model.thoseProps });

COMPLEX EXAMPLE::
model.selectedOption.extend({ isUnique: {
    params: {
      array: model.options,
      predicate: function (opt, selectedVal) {
          return ko.utils.unwrapObservable(opt.id) === selectedVal;
      }
    }
}});
*/
ko.validation.rules['isUnique'] = {
    validator: function (newVal, options) {
        if (options.predicate && typeof options.predicate !== "function")
            throw new Error("Invalid option for isUnique validator. The 'predicate' option must be a function.");

        var array = options.array || options;
        var count = 0;
        ko.utils.arrayMap(ko.utils.unwrapObservable(array), function (existingVal) {
            if (equalityDelegate()(existingVal, newVal)) count++;
        });
        return count < 2;

        function equalityDelegate() {
            return options.predicate ? options.predicate : function (v1, v2) {
                return v1 === v2;
            };
        }
    },
    message: 'This value is a duplicate',
};
ko.validation.rules["DateValidation"] = {
    validator: function (val, params) {
        dateTime = new Date(val);
        var ageDifMs = Date.now() - dateTime.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        var year = Math.abs(ageDate.getUTCFullYear() - 1970);
        return (year < 18);
    },
    message: 'This value is a duplicate'
};

ko.validation.rules['DOC'] = {
    validator: function (value, params) {
        if (!value) return true;
        if (value.length == 11) {
            campo = 'CPF'
            if (cpf.valida(value) == "CPF Inválido") return false;
            return true;
        }
        if (value.length == 14) {
            campo = 'CNPJ'
            if (cnpj.valida(value)) return true;
            return false;
        }
    },
    message: 'Documento informado é inválido.'
};
//Depois de declarar um valadition é necessário registrar o mesmo.
//Novas regras devem ficar acima do comando abaixo.
ko.validation.registerExtenders();


//Depois de declarar um valadition é necessário registrar o mesmo.
//Novas regras devem ficar acima do comando abaixo.
ko.validation.registerExtenders();
