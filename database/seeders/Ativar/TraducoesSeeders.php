<?php

namespace Database\Seeders\Ativar;

use App\Models\Traducoes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TraducoesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('traducoes')->insert([
            [
                'trd_chave' => "auth.failed",
                'pt-br' => "Essas credenciais não foram encontradas em nossos registros.",
                'en' => "These credentials do not match our records."
            ],
            [
                'trd_chave' => "auth.throttle",
                'pt-br' => "Muitas tentativas de login. Por favor, tente novamente em :seconds segundos",
                'en' => "Too many login attempts. Please try again in :seconds seconds."
            ],
            [
                'trd_chave' => "pagination.next",
                'pt-br' => "Próximo &raquo;",
                'en' => "Next &raquo;"
            ],
            [
                'trd_chave' => "pagination.previous",
                'pt-br' => "&laquo; Anterior",
                'en' => "&laquo; Previous"
            ],
            [
                'trd_chave' => "passwords.password",
                'pt-br' => "Senha deve ter ao menos seis caracteres e ser igual a confirmação",
                'en' => "Passwords must be at least six characters and match the confirmation."
            ],
            [
                'trd_chave' => "passwords.reset",
                'pt-br' => "Sua senha foi redefinida!",
                'en' => "Your password has been reset!"
            ],
            [
                'trd_chave' => "passwords.sent",
                'pt-br' => "Um e-mail com o link de alteração da senha foi enviado para você!",
                'en' => "We have e-mailed your password reset link!"
            ],
            [
                'trd_chave' => "passwords.token",
                'pt-br' => "Esse token de alteração de senha é inválido.",
                'en' => "This password reset token is invalid."
            ],
            [
                'trd_chave' => "passwords.user",
                'pt-br' => "Não foi encontrado um usuário com o e-mail informado.",
                'en' => "We can't find a user with that e-mail address."
            ],
            [
                'trd_chave' => "passwords.throttled",
                'pt-br' => "Este token de redefinição de senha é inválido.",
                'en' => "This password reset token is invalid."
            ],
            [
                'trd_chave' => "validation.accepted",
                'pt-br' => "O :attribute deve ser aceito.",
                'en' => "The :attribute must be accepted."
            ],
            [
                'trd_chave' => "validation.active_url",
                'pt-br' => "O :attribute não é uma URL válida.",
                'en' => "The :attribute is not a valid URL."
            ],
            [
                'trd_chave' => "validation.after",
                'pt-br' => "O :attribute deve ser uma data depois de :date.",
                'en' => "The :attribute must be a date after :date."
            ],
            [
                'trd_chave' => "validation.after_or_equal",
                'pt-br' => "O :attribute deve ser uma data depois ou igual á :date.",
                'en' => "The :attribute must be a date after or equal to :date."
            ],
            [
                'trd_chave' => "validation.alpha",
                'pt-br' => "O :attribute deve conter apenas letras.",
                'en' => "The :attribute may only contain letters."
            ],
            [
                'trd_chave' => "validation.alpha_dash",
                'pt-br' => "O :attribute deve conter apenas letras, números, e traços.",
                'en' => "The :attribute may only contain letters, numbers, and dashes."
            ],
            [
                'trd_chave' => "validation.alpha_num",
                'pt-br' => "O :attribute deve conter apenas letras e números.",
                'en' => "The :attribute may only contain letters and numbers."
            ],
            [
                'trd_chave' => "validation.array",
                'pt-br' => "O :attribute deve ser um array.",
                'en' => "The :attribute must be an array."
            ],
            [
                'trd_chave' => "validation.before",
                'pt-br' => "O :attribute deve ser uma data antes :date.",
                'en' => "The :attribute must be a date before :date."
            ],
            [
                'trd_chave' => "validation.before_or_equal",
                'pt-br' => "O :attribute deve ser uma data antes ou igual á :date.",
                'en' => "The :attribute must be a date before or equal to :date."
            ],
            [
                'trd_chave' => "validation.between.array",
                'pt-br' => "O campo :attribute deve ter entre :min e :max itens.",
                'en' => "The :attribute must have between :min and :max items."
            ],
            [
                'trd_chave' => "validation.between.file",
                'pt-br' => "O campo :attribute deve ser entre :min e :max kilobytes.",
                'en' => "The :attribute must be between :min and :max kilobytes."
            ],
            [
                'trd_chave' => "validation.between.numeric",
                'pt-br' => "O :attribute deve ser entre :min e :max.",
                'en' => "The :attribute must be between :min and :max."
            ],
            [
                'trd_chave' => "validation.between.string",
                'pt-br' => "O :attribute deve ser entre :min e :max caracteres.",
                'en' => "The :attribute must be between :min and :max characters."
            ],
            [
                'trd_chave' => "validation.boolean",
                'pt-br' => "O campo :attribute deve ser true ou false.",
                'en' => "The :attribute field must be true or false."
            ],
            [
                'trd_chave' => "validation.confirmed",
                'pt-br' => "O :attribute confirmação não corresponde.",
                'en' => "The :attribute confirmation does not match."
            ],
            [
                'trd_chave' => "validation.custom.attribute-name.rule-name",
                'pt-br' => "custom-message",
                'en' => "custom-message"
            ],
            [
                'trd_chave' => "validation.date",
                'pt-br' => "O :attribute não é uma data válida.",
                'en' => "The :attribute is not a valid date."
            ],
            [
                'trd_chave' => "validation.date_format",
                'pt-br' => "O :attribute não corresponde ao formato :format.",
                'en' => "The :attribute does not match the format :format."
            ],
            [
                'trd_chave' => "validation.different",
                'pt-br' => "O :attribute e :other devem ser diferentes.",
                'en' => "The :attribute and :other must be different."
            ],
            [
                'trd_chave' => "validation.digits",
                'pt-br' => "O :attribute deve ser :digits digitos.",
                'en' => "The :attribute must be :digits digits."
            ],
            [
                'trd_chave' => "validation.digits_between",
                'pt-br' => "O :attribute deve ser entre :min e :max digitos.",
                'en' => "The :attribute must be between :min and :max digits."
            ],
            [
                'trd_chave' => "validation.dimensions",
                'pt-br' => "O :attribute tem dimensões de imagem inválidas.",
                'en' => "The :attribute has invalid image dimensions."
            ],
            [
                'trd_chave' => "validation.distinct",
                'pt-br' => "O campo :attribute tem valor duplicado.",
                'en' => "The :attribute field has a duplicate value."
            ],
            [
                'trd_chave' => "validation.email",
                'pt-br' => "O :attribute deve ser um endereço de e-mail válido.",
                'en' => "The :attribute must be a valid email address."
            ],
            [
                'trd_chave' => "validation.excel_upload.row",
                'pt-br' => ":attribute na linha :linha ",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.exists",
                'pt-br' => "O :attribute selecionado é inválido.",
                'en' => "The selected :attribute is invalid."
            ],
            [
                'trd_chave' => "validation.file",
                'pt-br' => "O :attribute deve ser um arquivo.",
                'en' => "The :attribute must be a file."
            ],
            [
                'trd_chave' => "validation.filled",
                'pt-br' => "O campo :attribute deve ter valor.",
                'en' => "The :attribute field must have a value."
            ],
            [
                'trd_chave' => "validation.gt.numeric",
                'pt-br' => "O campo :attribute deve ser maior que :value.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gt.file",
                'pt-br' => "O campo :attribute deve ser maior que :value kilobytes.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gt.string",
                'pt-br' => "O campo :attribute deve ser maior que :value caracteres.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gt.array",
                'pt-br' => "O campo :attribute deve conter mais de :value itens.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gte.numeric",
                'pt-br' => "O campo :attribute deve ser maior que :value.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gte.file",
                'pt-br' => "O campo :attribute deve ser maior que :value kilobytes.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gte.string",
                'pt-br' => "O campo :attribute deve ser maior que :value caracteres.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.gte.array",
                'pt-br' => "O campo :attribute deve conter mais de :value itens.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.image",
                'pt-br' => "O :attribute deve ser uma image.",
                'en' => "The :attribute must be an image."
            ],
            [
                'trd_chave' => "validation.in",
                'pt-br' => "O :attribute selecionado é inválido.",
                'en' => "The selected :attribute is invalid."
            ],
            [
                'trd_chave' => "validation.in_array",
                'pt-br' => "O campo :attribute não existe em :other.",
                'en' => "The :attribute field does not exist in :other."
            ],
            [
                'trd_chave' => "validation.integer",
                'pt-br' => "O :attribute deve ser um inteiro.",
                'en' => "The :attribute must be an integer."
            ],
            [
                'trd_chave' => "validation.ip",
                'pt-br' => "O :attribute deve ser um endereço de IP válido .",
                'en' => "The :attribute must be a valid IP address."
            ],
            [
                'trd_chave' => "validation.ipv4",
                'pt-br' => "O :attribute deve ser um endereço de IPv4 válido .",
                'en' => "The :attribute must be a valid IPv4 address."
            ],
            [
                'trd_chave' => "validation.ipv6",
                'pt-br' => "O :attribute deve ser um endereço de IPv6 válido .",
                'en' => "The :attribute must be a valid IPv6 address."
            ],
            [
                'trd_chave' => "validation.json",
                'pt-br' => "O :attribute deve ser um texto JSON válido .",
                'en' => "The :attribute must be a valid JSON string."
            ],
            [
                'trd_chave' => "validation.lt.numeric",
                'pt-br' => "O campo :attribute deve ser maior que :value.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lt.file",
                'pt-br' => "O campo :attribute deve ser maior que :value kilobytes.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lt.string",
                'pt-br' => "O campo :attribute deve ser maior que :value caracteres.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lt.array",
                'pt-br' => "O campo :attribute deve conter mais de :value itens.",
                'en' => NULL
            ],

            [
                'trd_chave' => "validation.lte.numeric",
                'pt-br' => "O campo :attribute deve ser maior que :value.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lte.file",
                'pt-br' => "O campo :attribute deve ser maior que :value kilobytes.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lte.string",
                'pt-br' => "O campo :attribute deve ser maior que :value caracteres.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.lte.array",
                'pt-br' => "O campo :attribute deve conter mais de :value itens.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.max.array",
                'pt-br' => "O :attribute não deve ter mais que :max itens.",
                'en' => "The :attribute may not have more than :max items."
            ],
            [
                'trd_chave' => "validation.max.file",
                'pt-br' => "O :attribute não deve ser maior que :max kilobytes.",
                'en' => "The :attribute may not be greater than :max kilobytes."
            ],
            [
                'trd_chave' => "validation.max.numeric",
                'pt-br' => "O :attribute não deve ser maior que :max.",
                'en' => "The :attribute may not be greater than :max."
            ],
            [
                'trd_chave' => "validation.max.string",
                'pt-br' => "O :attribute não deve ser maior que :max caracteres.",
                'en' => "The :attribute may not be greater than :max characters."
            ],
            [
                'trd_chave' => "validation.mimes",
                'pt-br' => "O :attribute deve ser um arquivo do tipo: :values.",
                'en' => "The :attribute must be a file of type: :values."
            ],
            [
                'trd_chave' => "validation.mimetypes",
                'pt-br' => "O :attribute deve ser um arquivo do tipo: :values.",
                'en' => "The :attribute must be a file of type: :values."
            ],
            [
                'trd_chave' => "validation.min.array",
                'pt-br' => "O :attribute must have pelo menos :min itens.",
                'en' => "The :attribute must have at least :min items."
            ],
            [
                'trd_chave' => "validation.min.file",
                'pt-br' => "O :attribute deve ser pelo menos :min kilobytes.",
                'en' => "The :attribute must be at least :min kilobytes."
            ],
            [
                'trd_chave' => "validation.min.numeric",
                'pt-br' => "O :attribute deve ser pelo menos :min.",
                'en' => "The :attribute must be at least :min."
            ],
            [
                'trd_chave' => "validation.min.string",
                'pt-br' => "O :attribute deve ser pelo menos :min caracteres.",
                'en' => "The :attribute must be at least :min characters."
            ],
            [
                'trd_chave' => "validation.not_in",
                'pt-br' => "O :attribute selecionado é inválido.",
                'en' => "The selected :attribute is invalid."
            ],
            [
                'trd_chave' => "validation.not_regex",
                'pt-br' => "O formato do :attribute é inválido.",
                'en' => "The :attribute format is invalid."
            ],
            [
                'trd_chave' => "validation.numeric",
                'pt-br' => "O :attribute deve ser a number.",
                'en' => "The :attribute must be a number."
            ],
            [
                'trd_chave' => "validation.password",
                'pt-br' => "A senha está incorreta.",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.present",
                'pt-br' => "O campo :attribute deve ser present.",
                'en' => "The :attribute field must be present."
            ],
            [
                'trd_chave' => "validation.regex",
                'pt-br' => "O formato do :attribute é inválido.",
                'en' => "The :attribute format is invalid."
            ],
            [
                'trd_chave' => "validation.required",
                'pt-br' => "O campo :attribute é obrigatório.",
                'en' => "The :attribute field is required."
            ],
            [
                'trd_chave' => "validation.required_if",
                'pt-br' => "O campo :attribute é obrigatório quando :other é :value.",
                'en' => "The :attribute field is required when :other is :value."
            ],
            [
                'trd_chave' => "validation.required_unless",
                'pt-br' => "O campo :attribute é obrigatório a não ser que :other é em :values.",
                'en' => "The :attribute field is required unless :other is in :values."
            ],
            [
                'trd_chave' => "validation.required_with",
                'pt-br' => "O campo :attribute é obrigatório quando :values está presente.",
                'en' => "The :attribute field is required when :values is present."
            ],
            [
                'trd_chave' => "validation.required_with_all",
                'pt-br' => "O campo :attribute é obrigatório quando :values está presente.",
                'en' => "The :attribute field is required when :values is present."
            ],
            [
                'trd_chave' => "validation.required_without",
                'pt-br' => "O campo :attribute é obrigatório quando :values não está presente.",
                'en' => "The :attribute field is required when :values is not present."
            ],
            [
                'trd_chave' => "validation.required_without_all",
                'pt-br' => "O campo :attribute é obrigatório quando nenhum dos :values estão presentes.",
                'en' => "The :attribute field is required when none of :values are present."
            ],
            [
                'trd_chave' => "validation.same",
                'pt-br' => "O :attribute e :other devem ser iguais.",
                'en' => "The :attribute and :other must match."
            ],
            [
                'trd_chave' => "validation.size.array",
                'pt-br' => "O :attribute deve conter :size itens.",
                'en' => "The :attribute must contain :size items."
            ],
            [
                'trd_chave' => "validation.size.file",
                'pt-br' => "O :attribute deve ser :size kilobytes.",
                'en' => "The :attribute must be :size kilobytes."
            ],
            [
                'trd_chave' => "validation.size.numeric",
                'pt-br' => "O :attribute deve ser :size.",
                'en' => "The :attribute must be :size."
            ],
            [
                'trd_chave' => "validation.size.string",
                'pt-br' => "O :attribute deve ser :size caracteres.",
                'en' => "The :attribute must be :size characters."
            ],
            [
                'trd_chave' => "validation.starts_with",
                'pt-br' => "O campo :attribute deve começar com um dos seguintes valores: :values",
                'en' => NULL
            ],
            [
                'trd_chave' => "validation.string",
                'pt-br' => "O :attribute deve ser um texto.",
                'en' => "The :attribute must be a string."
            ],
            [
                'trd_chave' => "validation.timezone",
                'pt-br' => "O :attribute deve ser um fuso horário válido.",
                'en' => "The :attribute must be a valid zone."
            ],
            [
                'trd_chave' => "validation.unique",
                'pt-br' => "O :attribute já está em uso.",
                'en' => "The :attribute has already been taken."
            ],
            [
                'trd_chave' => "validation.uploaded",
                'pt-br' => "O :attribute falhou o upload.",
                'en' => "The :attribute failed to upload."
            ],
            [
                'trd_chave' => "validation.url",
                'pt-br' => "O formato do :attribute é inválido.",
                'en' => "The :attribute format is invalid."
            ],
            [
                'trd_chave' => "app.db.perfil.administrador",
                'pt-br' => "Administrador",
                'en' => "Administrator"
            ],
            [
                'trd_chave' => "app.db.perfil.comum",
                'pt-br' => "Comum",
                'en' => "Common"
            ],
            [
                'trd_chave' => "app.screen.register.add",
                'pt-br' => "Cadastro realizado com sucesso.",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.screen.register.remove",
                'pt-br' => "Cadastro removido com sucesso.",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.question.msgRemove",
                'pt-br' => "Deseja realmente excluir ?",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.standards.alertTitle.success",
                'pt-br' => "SUCESSO !",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.standards.alertTitle.error",
                'pt-br' => "ERRO !",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.standards.warning",
                'pt-br' => "ATENÇÃO !",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.standards.mensages.defaultError",
                'pt-br' => "Ocorreu um erro. Por favor contate o administrador.",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.jan",
                'pt-br' => "Jan",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.fev",
                'pt-br' => "Fev",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.mar",
                'pt-br' => "Mar",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.abr",
                'pt-br' => "Abr",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.mai",
                'pt-br' => "Mai",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.jun",
                'pt-br' => "Jun",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.jul",
                'pt-br' => "Jul",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.ago",
                'pt-br' => "Ago",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.set",
                'pt-br' => "Set",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.out",
                'pt-br' => "Out",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.nov",
                'pt-br' => "Nov",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.curto.dez",
                'pt-br' => "Dez",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.jan",
                'pt-br' => "Janeiro",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.fev",
                'pt-br' => "Fevereiro",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.mar",
                'pt-br' => "Março",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.abr",
                'pt-br' => "Abril",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.mai",
                'pt-br' => "Maio",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.jun",
                'pt-br' => "Junho",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.jul",
                'pt-br' => "Julho",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.ago",
                'pt-br' => "Agosto",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.set",
                'pt-br' => "Setembro",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.out",
                'pt-br' => "Outubro",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.nov",
                'pt-br' => "Novembro",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.longo.dez",
                'pt-br' => "Dezembro",
                'en' => NULL
            ],
            [

                'trd_chave' => "app.meses.dias_semana.curto.dom",
                'pt-br' => "Dom",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.seg",
                'pt-br' => "Seg",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.ter",
                'pt-br' => "Ter",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.qua",
                'pt-br' => "Qua",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.qui",
                'pt-br' => "Qui",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.sex",
                'pt-br' => "Sex",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.curto.sab",
                'pt-br' => "Sáb",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.dom",
                'pt-br' => "Domingo",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.seg",
                'pt-br' => "Segunda-Feira",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.ter",
                'pt-br' => "Terça-Feira",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.qua",
                'pt-br' => "Quarta-Feira",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.qui",
                'pt-br' => "Quinta-Feira",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.sex",
                'pt-br' => "Sexta-Feira",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.longo.sab",
                'pt-br' => "Sábado",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.dom",
                'pt-br' => "D",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.seg",
                'pt-br' => "S",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.ter",
                'pt-br' => "T",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.qua",
                'pt-br' => "Q",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.qui",
                'pt-br' => "Q",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.sex",
                'pt-br' => "S",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.meses.dias_semana.min.sab",
                'pt-br' => "S",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.datePicker.today",
                'pt-br' => "Hoje",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.datePicker.clear",
                'pt-br' => "Limpar",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.datePicker.format",
                'pt-br' => "dd/mm/yyyy",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.datePicker.titleFormat",
                'pt-br' => "MM yyyy",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.screen.produto.remove",
                'pt-br' => "Produto removido com sucesso.",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.screen.cotacao.remove",
                'pt-br' => "Cotação excluída com sucesso.",
                'en' => NULL
            ],
            [
                'trd_chave' => "app.std.msg.pagina_nao_encontrada",
                'pt-br' => "Página não encontrada.",
                'en' => NULL
            ]
        ]);
    }
}
