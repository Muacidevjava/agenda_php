<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\ClienteService;
use Soap\Url;

class ClienteController extends Controller
{

    private $tabela = "cliente";
    private $campo = "id_cliente";

    public function index()
    {
        $dados["lista"] = Service::lista($this->tabela);
        $dados["view"]  = "Cliente/Index";
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["cliente"] = Flash::getForm();
        $dados["view"] = "Cliente/Create";
        $this->load("template", $dados);
    }

    public function edit($id)
    {
        // Get client data
        $cliente = Service::get($this->tabela, $this->campo, $id);
        
        if (!$cliente) {
            Flash::setMsg("Cliente não encontrado", "erro");
            $this->redirect(URL_BASE . "cliente");
        }
        
        $dados["cliente"] = $cliente;
        $dados["view"] = "Cliente/Create";  // Using the same view as Create
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $cliente = new \stdClass();

        $cliente->id_cliente = !empty($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
        $cliente->cliente = $_POST['cliente'];
        $cliente->endereco = $_POST['endereco'];
        $cliente->numero = $_POST['numero'];
        $cliente->bairro = $_POST['bairro'];
        $cliente->cidade = $_POST['cidade'];
        $cliente->uf = $_POST['uf'];
        $cliente->cep = $_POST['cep'];
        $cliente->ddd = $_POST['ddd'] ?? ''; // Add the ddd field
        $cliente->celular = $_POST['celular'];
        $cliente->cpf = $_POST['cpf'];
        $cliente->sexo = $_POST['sexo'];
        $cliente->email = $_POST['email'];
        $cliente->data_cadastro = date("Y-m-d");

        Flash::setForm($cliente);
        if (ClienteService::salvar($cliente, $this->campo, null, $this->tabela)) {
            $this->redirect(URL_BASE . "cliente");
        } else {
            $this->redirect(URL_BASE . "cliente/create");
        }
    }

    public function excluir($id) {}
}
