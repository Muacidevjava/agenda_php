<?php
   namespace app\models\service;

use app\core\Validacao;
use app\models\validacao\Clientevalidacao;

   class ClienteService {
    public static function salvar($cliente,$campo,$validacao,$tabela){
              $validacao = Clientevalidacao::salvar($cliente);
              return Service::salvar($cliente, $campo,$validacao->listaErros(),$tabela);
      }
   }