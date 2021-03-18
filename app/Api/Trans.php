<?php

namespace App\Api;
use App\Translations;
use Illuminate\Support\Facades\DB;
class Trans
{
    protected $translations;
    public function exec()
    {
        $this->translations = [];
                // return $this->loadLangDirFiles();
        return $this->compileTransFiles();
    }
    private function compileTransFiles()
    {
        $trans = DB::table('traducoes')->orderBy('trd_chave')->get();
        $skippedKeys = ['trd_id', 'trd_chave'];
        $this->translations = [];
        if ($trans) {
            $fields = array_keys(get_object_vars($trans[0]));
            foreach ($fields as $key) {
                if (!in_array($key, $skippedKeys)) $this->translations[$key] = [];
            }
            foreach ($trans as $key => $value) {
                foreach ($fields as $field) {
                    if (!in_array($field, $skippedKeys)) {
                        $this->insertInArray(
                            $this->translations[$field],
                            $value->trd_chave,
                            $value->$field
                        );
                    }
                }
            }
        }
        $this->makeFile();
    }
    private function loadLangDirFiles()
    {
        $ds = DIRECTORY_SEPARATOR;
        foreach (glob(resource_path("lang{$ds}*")) as $k => $v) {
            $t = explode($ds, $v);
            $lang = array_pop($t);
            foreach (glob("{$v}{$ds}*.php") as $fk => $file) {
                $tmp = explode($ds, $file);
                $trans = preg_replace('/.php/', '', array_pop($tmp));
                $this->process(trans($trans, [], $lang), ($lang . '.' . $trans));
            }
        }
        return $this->toDatabase();
    }
    private function process($list, $prefix)
    {
        foreach ($list as $chave => $valor) {
            $_chave = $prefix . '.' . $chave;
            $this->getValue($valor, $_chave);
        }
        return $this;
    }
    private function getValue($valor, $_chave)
    {
        if (!is_array($valor)) {
            $this->translations[$_chave] = $valor;
        } else {
            foreach ($valor as $key => $val) {
                $this->getValue($val, ($_chave . '.' . $key));
            }
        }
    }
    private function reorder()
    {
        foreach ($this->translations as $key => $val) {
            $this->toArray($key, $val);
            unset($this->translations[$key]); // free memory
        }
        debug($this->arc);
    }
    private function toArray($key, $val)
    {
        $exp = explode('.', $key);
        $tmp = &$this->arc;
        foreach ($exp as $k) {
            $tmp = &$tmp[$k];
        }
        $tmp = $val;
    }
    private function toDatabase()
    {
        foreach ($this->translations as $key => $val) {
            $k = explode('.', $key);
            $table_field = array_first($k);
            $table_key = substr($key, (strlen($table_field) + 1));
            $row = Translations::where('trans', $table_key)->first();
            if (!$row) $row = new Translations;
            $row->trans = $table_key;
            $row->{$table_field} = $val;
            $row->save();
        }
    }
    private function makeFile()
    {
        $ds = DIRECTORY_SEPARATOR;
        if (!empty($this->translations)) {
            $this->_checkIfFolderExists(resource_path('lang'));
            foreach ($this->translations as $directory => $files) {
                $this->_checkIfFolderExists(resource_path("lang{$ds}{$directory}{$ds}"));
                foreach ($files as $filename => $content) {
                    $file_content = "<?php\n"
                        . "/**\n"
                        . " * THIS FILE IS SELF GENERATED SO PLEASE DON'T EDIT\n"
                        . " * TO UPDATE THIS CONTENT PLEASE CHECK DATABASE TABLE TRANSLATIONS\n"
                        . " * TO UPDATE THE KEY YOU NEED SO RUN COMMAND php artisan app:trans\n"
                        . " * @author Christian H. Kilian <chkilian89@.com>\n"
                        . " */\n"
                        . "return ";
                    $file_content .= var_export($content, true) . ';';
                    $file_content = preg_replace('/=>\s+\n\s+array\s+\(/', '=> array (', $file_content);
                    $file_content = preg_replace('/ array\s+\(/', ' [', $file_content);
                    $file_content = preg_replace('/\)/', ']', $file_content);
                    file_put_contents(resource_path("lang{$ds}{$directory}{$ds}{$filename}.php"), $file_content);
                }
            }
        }
    }
    private function _checkIfFolderExists($path)
    {
        if (!is_dir($path)) mkdir($path, 751);
    }
    private function insertInArray(&$data, $stringKey, $value)
    {
        $parts = explode('.', $stringKey);
        $temp = &$data;
        foreach ($parts as $key) {
            $temp = &$temp[$key];
        }
        $temp = $value ?? 'undefined key on database';
    }
}
