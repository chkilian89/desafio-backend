/**
 * Default function. Get
 * this functtion must call with sintaxe:
 *     Lang.get('default.select.optionsText') for simple returns the current string of translation
 *     Lang.get('default.select.optionsText', {'atribute_name':'atribut replacement'})
 *         ex: Lang.es.default.custonMessage = 'The field :name must be number'
 *         Lang.get('default.ccustonMessage', {'name':Lang.get('place.of.string.label')})
 *
 * @param  {[string]} key 'string_path.string_property':<mandatory>
 * @param  {[object]} arrayKeyReplacement
 * @return string
 */
function Lang() {[native / code]};

Lang.key = '{!! App::getLocale() !!}';

Lang.get = function (key, objectReplacement)
{
	try
	{
		var txt = Lang[Lang.key];
		var pieces = key.split('.');
		var debug = {!! config('app.debug')?1:0 !!};

		for (var i = 0; i < pieces.length; i++) {
			txt = txt[pieces[i]];
		};

		if (typeof(txt) !== 'string' && typeof(txt) !== 'object' )
		{
			if (debug) throw 'Translation not found';
		}

		if (objectReplacement !== undefined && typeof(objectReplacement) === 'object')
		{
			var props = Object.keys(objectReplacement);
			props.forEach(function (k) {
				txt = txt.replace((':' + k), ko.unwrap(objectReplacement[k]));
			});
		}

		return txt;
	}
	catch (er)
	{
		console.log(er + ' ' + key);
		return key;
	}
};

Lang[Lang.key] = {
	'app'        : {!! json_encode(Lang::get('app')) !!},
	'validation' : {!! json_encode(Lang::get('validation')) !!},
};

lang = Lang.get;

if(moment)
{
    moment.locale(Lang.key,{
        weekdays :[
            lang('app.meses.dias_semana.longo.dom'),
            lang('app.meses.dias_semana.longo.seg'),
            lang('app.meses.dias_semana.longo.ter'),
            lang('app.meses.dias_semana.longo.qua'),
            lang('app.meses.dias_semana.longo.qui'),
            lang('app.meses.dias_semana.longo.sex'),
            lang('app.meses.dias_semana.longo.sab')
        ],
        weekdaysShort: [
            lang('app.meses.dias_semana.curto.dom'),
            lang('app.meses.dias_semana.curto.seg'),
            lang('app.meses.dias_semana.curto.ter'),
            lang('app.meses.dias_semana.curto.qua'),
            lang('app.meses.dias_semana.curto.qui'),
            lang('app.meses.dias_semana.curto.sex'),
            lang('app.meses.dias_semana.curto.sab')
        ],
        weekdaysMin: [
            lang('app.meses.dias_semana.min.dom'),
            lang('app.meses.dias_semana.min.seg'),
            lang('app.meses.dias_semana.min.ter'),
            lang('app.meses.dias_semana.min.qua'),
            lang('app.meses.dias_semana.min.qui'),
            lang('app.meses.dias_semana.min.sex'),
            lang('app.meses.dias_semana.min.sab')
        ],
        months: [
            lang('app.meses.longo.jan'),
            lang('app.meses.longo.fev'),
            lang('app.meses.longo.mar'),
            lang('app.meses.longo.abr'),
            lang('app.meses.longo.mai'),
            lang('app.meses.longo.jun'),
            lang('app.meses.longo.jul'),
            lang('app.meses.longo.ago'),
            lang('app.meses.longo.set'),
            lang('app.meses.longo.out'),
            lang('app.meses.longo.nov'),
            lang('app.meses.longo.dez')
        ],
        monthsShort:[
            lang('app.meses.curto.jan'),
            lang('app.meses.curto.fev'),
            lang('app.meses.curto.mar'),
            lang('app.meses.curto.abr'),
            lang('app.meses.curto.mai'),
            lang('app.meses.curto.jun'),
            lang('app.meses.curto.jul'),
            lang('app.meses.curto.ago'),
            lang('app.meses.curto.set'),
            lang('app.meses.curto.out'),
            lang('app.meses.curto.nov'),
            lang('app.meses.curto.dez')
        ]
    });
    moment.locale(Lang.key);
}

$.fn.datepicker.dates[Lang.key] = {
    days: moment.weekdays(),
    daysShort: moment.weekdaysShort(),
    daysMin: moment.weekdaysMin(),
    months: moment.months(),
    monthsShort: moment.monthsShort(),
    today: lang('app.datePicker.today'),
    clear: lang('app.datePicker.clear'),
    format: lang('app.datePicker.format'),
    titleFormat: lang('app.datePicker.titleFormat'), //Leverages same syntax as 'format'
    weekStart: 0
};
