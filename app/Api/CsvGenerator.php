<?php

namespace App\Api;

abstract class CsvGenerator
{
	public static function make(array $dados = array(), $nomeArquivo = 'default.csv')
	{
		if(!empty($dados))
		{
			$chavesDoCsv = array_keys($dados[0]);
			$caminho = storage_path().DIRECTORY_SEPARATOR.'csv'.DIRECTORY_SEPARATOR;
			$arquivo = $caminho.$nomeArquivo;
			$pointer = fopen($arquivo, 'w');
			fputcsv($pointer, $chavesDoCsv,';','"');
			foreach ($dados as $k => $v)
			{
				$t = [];
				foreach($v as $pos => $txt)
				{
					array_push($t, addslashes($txt));
				}
				fputcsv($pointer, $t,';','"');
			}
			fclose($pointer);
			return ['caminho' => $arquivo];
		}
		return null;
	}
}
