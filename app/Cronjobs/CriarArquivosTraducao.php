<?php

namespace App\Cronjobs;

use Illuminate\Support\Facades\DB;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\Log;

class CriarArquivosTraducao
{
	use HelperTrait;
	public function exec()
	{
		 Log::info(trans("app.std.msg.criando_arquivos_traducao"));
		// Log::info("<<< Criando Arquivos de Tradução >>>");
		$trans = DB::table('traducoes')->orderBy('trd_chave')->get();
		$skippedKeys = ['trd_id','trd_chave'];
		$translations = [];
		if($trans)
		{
			$fields = array_keys(get_object_vars($trans[0]));
			foreach($fields as $key)
			{
				if(!in_array($key,$skippedKeys)) $translations[$key] = [];
			}
			foreach ($trans as $key => $value)
			{
				foreach($fields as $field)
				{
					if(!in_array($field, $skippedKeys))
					{
						$this->insertInArray(
							$translations[$field],
							$value->trd_chave,
							$value->$field
						);
					}
				}
			}
		}
		$this->makeFile($translations);
		return 'OK';
	}
	private function insertInArray(&$data, $stringKey, $value)
	{
		$parts = explode('.',$stringKey);
		$temp = &$data;
		foreach ( $parts as $key )
		{
			$temp = &$temp[$key];
		}
		$temp = $value ?? 'none';
	}
	public function makeFile($translations)
	{
		$this->_checkIfFolderExists(resource_path('/lang'));
		if(!empty($translations))
		{
			/* removendo os arquivos antigos para repopular */
			foreach(glob(resource_path('/lang/*/*.php')) as $file)
			{
				unlink($file);
			}
			foreach($translations as $directory => $files)
			{
				foreach($files as $file_name => $content)
				{
					$this->_checkIfFolderExists(resource_path('lang/'.$directory));
					$file_content = "<?php\n"
						."/**\n"
						." * ESSE ARQUIVO É AUTO GERADO\n"
						." * POR FAVOR NAO EDITE ESSE DOCUMENTO\n"
						." * EDITE OS DADOS NA TABELA traducoes E O MESMO SERÁ \n"
						." * RECRIADO COM A CHAMADA DE UM SERVIÇO\n"
						." * para executar o service chame a url <projeto>/cronjobs/traduzir \n"
						." */\n"
						." return ";
					$file_content .= var_export($content,true).';';
					$file_content = preg_replace('/=>\s+\n\s+array\s+\(/','=> array (',$file_content);
					$file_content = preg_replace('/ array\s+\(/',' [',$file_content);
					$file_content = preg_replace('/(\s+)\)/','$1]',$file_content);

					file_put_contents(resource_path('lang/'.$directory."/{$file_name}.php"),$file_content);
				}
			}
		}
	}
}
