function base(){[native/code]}

base.loading = {show:ko.observable(false)};

base.Auth = {!! !empty(Auth::user()) ? json_encode(Auth::user()) : json_encode(new stdClass) !!};

base.getHeaders = function(){
    return {
    'X-CSRF-TOKEN':"{{csrf_token()}}",
    //'Authorization': 'Bearer ' + oauth.access_token || '',/* Se a rota exigir token de acesso*/
    'Accept': 'application/json; charset=UTF-8'
    }
};

base.post = function(url,payload,callback,loading)
{
   let headers = {
       'X-CSRF-TOKEN':"{{csrf_token()}}"
   }
    if(!loading) base.loading.show(true);
    $.ajax({
        url:url,
        data:payload,
        dataType:'json',
        method:'post',
        headers:headers
    }).done(function(response){
        if(typeof(callback) == 'function') callback(response);
    }).fail(function(err){
        console.log(err);
        if(err.status == 422)
        {
            base.handle_formRequest(err.responseJSON.errors);
        }else{
            Alert.error('Ocorreu um erro, contate o administrador do sistema!!!', 'Ops...');
        }
    }).always(function(){
        if(!loading) base.loading.show(false);
    });
}

base.get = function(url,payload,callback,loading)
{
   let headers = {
       'X-CSRF-TOKEN':"{{csrf_token()}}"
   }
    if(!loading) base.loading.show(true);
    $.ajax({
        url:url,
        data:payload,
        dataType:'json',
        method:'get',
        headers:headers
    }).done(function(response){
        if(typeof(callback) == 'function') callback(response);
    }).fail(function(err){
        console.log(err);
        Alert.error('Ocorreu um erro, contate o administrador do sistema!!!', 'Ops...');
    }).always(function(){
        if(!loading) base.loading.show(false);
    });
}

base.delete = function(url,payload,callback,loading)
{
   let headers = {
       'X-CSRF-TOKEN':"{{csrf_token()}}"
   }
    if(!loading) base.loading.show(true);
    $.ajax({
        url:url,
        data:payload,
        dataType:'json',
        method:'delete',
        headers:headers
    }).done(function(response){
        if(typeof(callback) == 'function') callback(response);
    }).fail(function(err){
        console.log(err);
        if(err.status == 422)
        {
            base.handle_formRequest(err.responseJSON.errors);
        }else{
            Alert.error('Ocorreu um erro, contate o administrador do sistema!!!', 'Ops...');
        }
    }).always(function(){
        if(!loading) base.loading.show(false);
    });
}
/**
 * this context is to be used with de ExcelApi from the backend.
 * the DownloadController will return an instance of ExcelApi with the Headers
 * will make the downlaod of this spreadSheet from here
 * @function downloadFile
 * @var url the api url
 * @var payload the data you what to put in the spreadSheet non mandatory, when you need external data to do so, just call you scope from the bachend
 * @var callback is the function that will be called wen the request finish. You may use this._makeFile with the response.target.response
 */
base.download = function(url,payload,callback,loading){
    var xhr,headers;
    headers = this.getHeaders();
    xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.responseType = 'blob';
    xhr.setRequestHeader('X-CSRF-TOKEN',headers['X-CSRF-TOKEN']);
    //xhr.setRequestHeader('Authorization', headers['Authorization']);
    xhr.setRequestHeader('Content-type', headers['Accept']);
    xhr.onload= function(data){
        base.loading.show(false);
        callback(data);
    }
    xhr.onerror = function(){
        base.loading.show(false);
    }
    xhr.send(JSON.stringify(payload));
    base.loading.show(true);
};
/**
 * when you need to simple downalod a file
 * this function will create the default structure do to so.
 * can be used by acessor from downloadFile function
 * @var blob:Blob the blob file
 * @var filename:string the file name with extension
 */
base._makeFile = function(blob, filename){
    let anchor = document.createElement('a');
    anchor.download = filename;
    anchor.href = URL.createObjectURL(blob);
    document.body.appendChild(anchor);
    anchor.click();
    document.body.removeChild(anchor);
}
base.handle_error = function(data)
{
    var ret = [];
    if(data.message && typeof(data.message) == 'string'){
        try{
            var msg = JSON.parse(data.message);
            var keys = Object.keys(msg);
            ko.utils.arrayForEach(keys,function(k){
                ret.push(msg[k]);
            });
        } catch(e) {
            // se caiu aqui não veio um objeto na message
            ret.push(data.message);
        }
    }
    if(data.mensagem && typeof(data.mensagem) == 'string'){
        try{
            var msg = JSON.parse(data.mensagem);
            var keys = Object.keys(msg);
            ko.utils.arrayForEach(keys,function(k){
                ret.push(msg[k]);
            });
        } catch(e) {
            // se caiu aqui não veio um objeto na mensagem
            ret.push(data.mensagem);
        }
    }
    return ret;
}
base.handle_formRequest = function(data){
    var keys = Object.keys(data);
    ko.utils.arrayForEach(keys,function(k){
        return Alert.warning(data[k],lang('app.standards.alertTitle.error'), { displayDuration: 7000 });
    });
}

base._formatDoc = function(string)
{
    if(string)
    {
        if(string.length == 14) return string.toString().replace(/\D/g,'').replace(/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2}).*/,'$1.$2.$3/$4-$5');
        if(string.length == 11) return string.toString().replace(/\D/g,'').replace(/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2}).*/,'$1.$2.$3-$4');
    }
};

base._paginator = function()
{
    var me = this;
    me.total_de_paginas = ko.observable(0);
    me.itens_por_pagina = ko.observable(0);
    me.total_de_itens   = ko.observable(0);
    me.pagina_atual     = ko.observable(0);
};

base._encrypt = function(string) {
    // PROCESS
    const encodedWord = CryptoJS.enc.Utf8.parse(string); // encodedWord Array object
    const encoded = CryptoJS.enc.Base64.stringify(encodedWord); // string: 'NzUzMjI1NDE='
    return encoded;
    //return CryptoJS.AES.encrypt(string, '{!! config('app.key') !!}').toString();
}
 base._decode = function(string) {
    // INIT
    // const encoded = 'NzUzMjI1NDE='; // Base64 encoded string

    // PROCESS
    const encodedWord = CryptoJS.enc.Base64.parse(string); // encodedWord via Base64.parse()
    const decoded = CryptoJS.enc.Utf8.stringify(encodedWord); // decode encodedWord via Utf8.stringify() '75322541'
    return decoded;
}

base._ecryptSha1 = function(string)
{
    return hex_sha1(string);
}

base._fomartMoeda = function(string, symbol)
{
    //sem R$
    if(symbol){
        return string.toLocaleString('pt-br', {minimumFractionDigits: 2});
    }
    //com R$
    return string.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
}
