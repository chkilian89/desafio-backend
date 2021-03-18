<?php

namespace App\Traits;

use phpseclib\Crypt\RSA;

trait EncryptTrait
{
    private $response;

    public function _generateParKey($size = 4096)
	{
		return (new RSA)->createKey($size);
    }
    public function _public_encrypt($chave, $data)
    {
        openssl_public_encrypt($data, $this->response, $chave);
        return base64_encode($this->response);
    }
    public function _private_encrypt($chave, $data)
    {
        openssl_private_encrypt($data, $this->response, $chave);
        return base64_encode($this->response);
    }
    public function _public_decrypt($chave, $data)
    {
        openssl_public_decrypt(base64_decode($data), $this->response, $chave);
        return $this->response;
    }
    public function _private_decrypt($chave, $data)
    {
        openssl_private_decrypt(base64_decode($data), $this->response, $chave);
        return $this->response;
    }
}