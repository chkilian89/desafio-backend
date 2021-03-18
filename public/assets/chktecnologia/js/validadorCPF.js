function cpf(){[native/code]}
 var n = "CPF Inválido",
     i = "CPF Válido";
cpf.r = function (r) {
    for (var t = null, n = 0; 9 > n; ++n) t += r.toString().charAt(n) * (10 - n);
    var i = t % 11;
    return i = 2 > i ? 0 : 11 - i
}

cpf.t = function t(r) {
    for (var t = null, n = 0; 10 > n; ++n) t += r.toString().charAt(n) * (11 - n);
    var i = t % 11;
    return i = 2 > i ? 0 : 11 - i
}

cpf.gera = function () {
    for (var n = "", i = 0; 9 > i; ++i) n += Math.floor(9 * Math.random()) + "";
    var o = cpf.r(n),
        a = n + "-" + o + cpf.t(n + "" + o);
    return a
}

cpf.valida = function (o) {
    for (var a = o.replace(/\D/g, ""), u = a.substring(0, 9), f = a.substring(9, 11), v = 0; 10 > v; v++)
        if ("" + u + f == "" + v + v + v + v + v + v + v + v + v + v + v) return n;
    var c = cpf.r(u),
        e = cpf.t(u + "" + c);
    return f.toString() === c.toString() + e.toString() ? i : n
}
