<?php

require_once("vendor/autoload.php");

/*

-- EXEMPLO CRIANDO PLANO -- 

$plano = new Plano();

$plano->setNome($_POST['nome']);
$plano->setSubtitulo($_POST['subtitulo']);
$plano->setDescricao($_POST['descricao']);
$plano->setRegramento($_POST['regramento']);
$plano->setValor($_POST['valor']);
$plano->setRecorrencia($_POST['recorrencia']);

$mercadopago = new MercadoPago();

switch ($plano->getRecorrencia()) {
    case 'Mensal':
    $frequency_type = "months";
    $frequency      = "1";
    break;
    
    case 'Anual':
    $frequency_type = "years";
    $frequency      = "1";
    break;

    case 'Semestral':
    $frequency_type = "months";
    $frequency      = "6";
    break;
}

$mercadopago->setFreeTrial($frequency_type, $frequency);
$mercadopago->setAutoRecurring($frequency, $frequency_type, (float)$plano->getValor(), "BRL", $mercadopago->getFreeTrial());
$mercadopago->setDataCurl($plano->getNome(), $mercadopago->getAutoRecurring());
$mercadopago->setPlan($mercadopago->getDataCurl());

-- EXEMPLO FAZENDO ASSINATURA -- 

$mercadopago = new MercadoPago();

$datapost->idplano = ID do plano do mercadopago, pode ser encontrado em MercadoPago > Minha Conta > Planos de Assinatura ou no retorno do metodo setPlan() e getPlan();
$mercadopago->setSignature($datapost->idplano, $datapost->token, $datapost->payer->email);

-- EXEMPLO CANCELANDO ASSINATURA --

$mercadopago = new MercadoPago();
$mercadopago->cancelSignature(id_assinatura_aqui); (salve no banco o id da assinatura qnd criar uma assinatura com setSignature para utilizar depois)


-- EXEMPLO PAGAMENTO NORMAL -- 

$mercadopago = new MercadoPago();

$mercadopago->setIdentification($datapost->payer->identification->type, $datapost->payer->identification->number);
$mercadopago->payer($datapost->payer->email, $mercadopago->getIdentification());

$mercadopago->payment(
	(float)$datapost->transaction_amount,
	$datapost->token,
	"Contratação de Serviço",
	1,
	$datapost->payment_method_id,
	(int)$datapost->issuer_id
);

if($mercadopago->paymentResponse("status") == "approved") 
{	
	// code
}

*/

/**
*
*
* CONTROL F thats it
*
* @param $id = id do pagamento no retorno do mercado pago;
* @param $status  = status do pagamento no retorno do mercadopago (approved, in_process, rejected)
* @param $status_detail = detalhes do status no retorno do mercado pago
* 
* -- SUGESTÃO DE MENSAGENS DE ERRO --
* 
* if($mercadopago->paymentResponse("status_detail") == "cc_rejected_bad_filled_card_number")
* {
* 	$mensagem = "Revise o número do cartão.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_bad_filled_date")
* {
* 	$mensagem = "Revise a data de vencimento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_bad_filled_other")
* {
* 	$mensagem = "Revise os dados.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_bad_filled_security_code")
* {
* 	$mensagem = "Revise o código de segurança do cartão.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_blacklist")
* {
* 	$mensagem = "Não pudemos processar seu pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_call_for_authorize")
* {
* 	$mensagem = "Pagamento não autorizado.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_card_disabled")
* {
* 	$mensagem = "Ligue para o seu banco para ativar seu cartão. O telefone está no verso do seu cartão.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_card_error")
* {
* 	$mensagem = "Não conseguimos processar seu pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_duplicated_payment")
* {
* 	$mensagem = "Você já efetuou um pagamento com esse valor. Caso precise pagar novamente, utilize outro cartão ou outra forma de pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_high_risk")
* {
* 	$mensagem = "Seu pagamento foi recusado.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_insufficient_amount")
* {
* 	$mensagem = "Saldo insuficiente.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_invalid_installments")
* {
* 	$mensagem = "Não conseguimos processar seu pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_max_attempts")
* {
* 	$mensagem = "Você atingiu o limite de tentativas permitido. Escolha outro cartão ou outra forma de pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* else if($mercadopago->paymentResponse("status_detail") == "cc_rejected_other_reason")
* {
* 	$mensagem = "Não conseguimos processar seu pagamento.";
* 	$retorno = array('status' => "erro", 'mensagem' => $mensagem);
* 	echo json_encode($retorno);
* }
* 
* @param $paymentMercadoPago = onde o pagamento e realizado
* @param $payerMercadoPago   = onde pegamos os dados do pagador
* @param $response           = resposta para validar erros, salvar id de pagamento e etc
* @param $identification     = dados de identificação do pagador
*
* - ASSINATURAS -
*
* @param $plan     = Plano criado
* @param $free_trial     = Define um período de teste inicial e retarda a primeira cobrança.
* @param $auto_recurring = Indica o tempo ou ciclo com base no tipo de frequência.
* @param $dataCurl       = Array com os dados necessarios no CURL para criar um plano no mercado pago
* @param $headers        = Necessário no array $dataCurl ('Content-Type: application/json', 'Authorization: Bearer ENV_ACCESS_TOKEN')
* @param $testuser       = Usuario de teste criado
*
**/

/**
* @package Classe: MercadoPago
* Descrição: Responsável em fornecer métodos de manipulação e integração com mercado pago
* @author Base em Tecnologia
* Data: 11/08/2021
*/

class MercadoPago
{
	const PUBLIC_KEY              = "";
	const ACCESS_TOKEN            = "APP_USR-3772728885875445-081216-2e8e669c33a8de4e8a180ef5d4a62169-782779792";
	const URL_JS                  = "https://sdk.mercadopago.com/js/v2";

	const BACK_URL                = "https://www.mercadopago.com.br";

	const URL_CREATE_PLAN         = "https://api.mercadopago.com/preapproval_plan";
	const URL_GET_PAYER_SIGNATURE = "https://api.mercadopago.com/preapproval/search?";
	const URL_CANCEL_SIGNATURE    = "https://api.mercadopago.com/preapproval/";
	const URL_CREATE_SIGNATURE    = "https://api.mercadopago.com/preapproval";
	const URL_CREATE_TEST_USER    = "https://api.mercadopago.com/users/test_user";

	public $id;
	public $status;
	public $status_detail;

	public $paymentMercadoPago;
	public $payerMercadoPago;
	public $response;

	public $identification = [];

	// Se for assinatura estes são obrigatórios para funcionar

	public $plan           = [];
	public $signature      = [];
	public $free_trial     = [];
	public $auto_recurring = [];
	public $dataCurl       = [];
	public $headers        = [];

	// Usuario teste
	public $testuser;

	/**
	* @method Método: construtor 
	* Descrição: Responsável por definir o ACESS TOKEN que pode ser obtido no menu credenciais do mercado pago
	*
	* @author Base em Tecnologia
	* @access public
	* @return 
	*
	*
	* Data: 11/08/2021
	*/

	public function __construct()
	{
		MercadoPago\SDK::setAccessToken(self::ACCESS_TOKEN);
	}

	/**
	* @method Método: payment() 
	* Descrição: Responsável por enviar os dados de pagamento para a classe do mercado pago, estes dados são retornados no formulario pelo script JS do mercadopago
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $transaction_amount = valor do serviço, compra etc
	* @param $token = este token é retornado no post do script JS do mercado pago, este é o token do cartão de crédito
	* @param $description = descrição do serviço 
	* @param $installments = numero de parcelas
	* @param $payment_method_id = id do metodo de pagamento 
	* @param $issuer_id = id da emissora do cartão
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function payment(float $transaction_amount, $token, string $description, int $installments, string $payment_method_id, int $issuer_id)
	{
		$payment = new MercadoPago\Payment();
		$payment->transaction_amount = $transaction_amount;
		$payment->token              = $token;
		$payment->description        = $description;
		$payment->installments       = $installments;
		$payment->payment_method_id  = $payment_method_id;
		$payment->issuer_id          = $issuer_id;
		$payment->payer              = $this->payerMercadoPago;

		if($payment->save())
		{
			$this->paymentMercadoPago = $payment;

			$this->status        = $payment->status;
			$this->status_detail = $payment->status_detail;
			$this->id            = $payment->id;
		}
	}

	/**
	* @method Método: payer() 
	* Descrição: Responsável por enviar os dados do pagador para a classe do mercado pago, estes dados são retornados no formulario pelo script JS do mercadopago
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $email = email do pagador
	* @param $identification = array com dados de identificação do pagador
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function payer(string $email, array $identification)
	{
		$payer = new MercadoPago\Payer();
		$payer->email = $email;
		$payer->identification = array(
	    	"type"   => $identification["type"],
	    	"number" => $identification["number"]
		);

		$this->payerMercadoPago = $payer;
	}

	/**
	* @method Método: setPlan() 
	* Descrição: Responsável por reembolsar um valor na fatura do cartão
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $payment_id = id do pagamento
	*
	* @return reposta do mercado pago via curl
	* Data: 11/08/2021
	*/

	public function refund($payment_id)
	{
		$payment = MercadoPago\Payment::find_by_id($payment_id);
		$payment->refund();
	}

	public function setPlan($data)
	{
		$url = self::URL_CREATE_PLAN;

		$this->setHeaders("Content-Type: application/json", "Authorization: Bearer " . self::ACCESS_TOKEN);

		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$this->plan = json_decode($resp);
	}

	/**
	* @method Método: getPlan() 
	* Descrição: Responsável retornar o objeto plan
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return plan
	* Data: 11/08/2021
	*/

	public function getPlan()
	{
		return $this->plan;
	}

	/**
	* @method Método: getSignaturePayer() 
	* Descrição: Responsável por buscar a assinatura ativa de um pagador
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $find_by = nome do campo q sera usado pra buscar a assinatura
	* @param $find_by_value = valor do campo q sera usado para buscar a assinatura
	*
	* @return free_trial
	* Data: 11/08/2021
	*/

	public function getSignaturePayer($find_by, $find_by_value)
	{	
		$find_url = $find_by . "=" . $find_by_value;
		$url = self::URL_GET_PAYER_SIGNATURE . $find_url;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Bearer " . self::ACCESS_TOKEN,
		);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
	
		$resp = json_decode($resp);

		var_dump($resp);

		$this->signature = $resp->results[0];
	}

	/**
	* @method Método: cancelSignature() 
	* Descrição: Responsável por buscar a assinatura ativa de um pagador
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $status = cancelled para cancelar, paused = para pausar
	* @param $signature_id = id da assinatura a ser cancelada retorna de getSignaturePayer (ou do banco de dados se foi salvo no momento q a assinatura foi criada)
	*
	* @return free_trial
	* Data: 11/08/2021
	*/

	public function cancelSignature($signature_id, $status = "cancelled")
	{
		$this->setHeaders("Content-Type: application/json", "Authorization: Bearer " . self::ACCESS_TOKEN);

		$url = self::URL_CANCEL_SIGNATURE . $signature_id;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_PUT, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());

		$data = ["status" => $status];

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$this->signature = json_decode($resp);
	}

	/**
	* @method Método: setSignature() 
	* Descrição: Responsável por efetuar a assinatura
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $preapproval_plan_id = id do plano do mercadopago
	* @param $token = token gerado do cartao de credito
	* @param $payer_email = email do pagador
	*
	* @return free_trial
	* Data: 11/08/2021
	*/

	public function setSignature($preapproval_plan_id, $card_token_id, $payer_email)
	{
		$this->setHeaders("Content-Type: application/json", "Authorization: Bearer " . self::ACCESS_TOKEN);

		$url = self::URL_CREATE_SIGNATURE;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());

		$data = [
			"preapproval_plan_id" => $preapproval_plan_id,
			"card_token_id"       => $card_token_id,
			"payer_email"         => $payer_email
		];

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$this->signature = json_decode($resp);
	}

	/**
	* @method Método: getSignature() 
	* Descrição: Responsável retornar o objeto signature
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return signature
	* Data: 11/08/2021
	*/

	public function getSignature()
	{
		return $this->signature;
	}

	/**
	* @method Método: getFreeTrial() 
	* Descrição: Responsável retornar o objeto free_trial
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return free_trial
	* Data: 11/08/2021
	*/

	public function getFreeTrial()
	{
		return $this->free_trial;
	}

	/**
	* @method Método: setFreeTrial() 
	* Descrição: Responsável definir as configurações de periodo de teste antes de começar o pagamento mensal
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $frequency_type = tipo de frequencia, meses, anos, dias..
	* @param $frequeny = numero da frequencia
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function setFreeTrial($frequency_type, $frequency)
	{
		$this->free_trial = [
			"frequency_type" => $frequency_type,
			"frequency"      => $frequency
		];
	}

	/**
	* @method Método: getAutoRecurring() 
	* Descrição: Responsável retornar o objeto auto_recurring
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return auto_recurring
	* Data: 11/08/2021
	*/

	public function getAutoRecurring()
	{
		return $this->auto_recurring;
	}

	/**
	* @method Método: setAutoRecurring() 
	* Descrição: Responsavel por definir as configurações de recorrencia de uma assinatura
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $frequency = frequencia da recorrencia
	* @param $frequency_type = tipo de frequencia meses, anos, dias
	* @param $transaction_amount = valor da assinatura
	* @param $currency_id = id da recorrencia
	* @param $repetitions = quanto tempo ira durar a recorrencia se nao definida é ate ser cancelada
	* @param $free_trial = objeto getFreeTrial
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function setAutoRecurring($frequency, $frequency_type, $transaction_amount, $currency_id, $free_trial, $repetitions = null)
	{

		$this->auto_recurring = [
			"frequency"          => $frequency,
			"frequency_type"     => $frequency_type,
			"transaction_amount" => $transaction_amount,
			"currency_id"        => $currency_id,
			"repetitions"        => $repetitions,
			"free_trial"         => $free_trial
		];
	}

	/**
	* @method Método: getHeaders() 
	* Descrição: Responsável retornar o objeto headers
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return objeto headers
	* Data: 11/08/2021
	*/

	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	* @method Método: setHeaders() 
	* Descrição: Responsável definir o cabeçalho do CURL do mercado pago
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $contentType = tipo de conteudo que precisa ser enviado para o mercadopago
	* @param $authorization
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function setHeaders($contentType, $authorization)
	{
		$this->headers = [
			"contentType"   => $contentType,
			"authorization" => $authorization
		];
	}

	/**
	* @method Método: getIdentification() 
	* Descrição: Responsável retornar o objeto identification
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return objeto identification
	* Data: 11/08/2021
	*/

	public function getIdentification()
	{
		return $this->identification;
	}

	/**
	* @method Método: setIdentification() 
	* Descrição: Responsável por definir os dados de identificação do pagador
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $type = tipo de documento
	* @param $number = numero do documento
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function setIdentification($type, $number)
	{
		$this->identification = [
			"type"   => $type,
			"number" => $number
		];
	}

	/**
	* @method Método: getDataCurl() 
	* Descrição: Responsável retornar o objeto dataCurl
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return objeto dataCurl
	* Data: 11/08/2021
	*/

	public function getDataCurl()
	{
		return $this->dataCurl;
	}

	/**
	* @method Método: setDataCurl() 
	* Descrição: Responsável por definir os dados do CURL de criar um plano do mercadopago
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $reason = descrição que irá aparecer na fatura do cartão
	* @param $auto_recurring = dados de configuração da recorrencia da assinatura
	*
	* @return 
	* Data: 11/08/2021
	*/

	public function setDataCurl($reason, $auto_recurring)
	{
		$back_url = self::BACK_URL;

		$this->dataCurl = [
			"back_url"        => $back_url,
			"reason"         => $reason,
			"auto_recurring" => $auto_recurring
		];
	}

	/**
	* @method Método: paymentResponse() 
	* Descrição: Responsável por retornar a resposta do mercado pago
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param $return = escolha entre 3 retornos , status, status_detail e id do pagamento
	*
	* @return retorna o dado solicitado no parametro
	* Data: 11/08/2021
	*/

	public function paymentResponse($return)
	{
		$this->response = [
		    'status'        => $this->status,
		    'status_detail' => $this->status_detail,
		    'id'            => $this->id
		];

		switch ($return) {
			case 'status':
			return $this->status;
			break;

			case 'status_detail':
			return $this->status_detail;
			break;

			case 'id':
			return $this->id;
			break;
		}
	}

	/**
	* @method Método: setTestUser() 
	* Descrição: Criar um usuario de teste, limite de 10 usuarios de teste por conta mercadopago, anote os dados do usuario assim que gerar q ele ira funcionar.
	* necessario acess token da produção...
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @return retorna a resposta do curl do mercadopago
	* Data: 11/08/2021
	*/

	public function setTestUser()
	{
		$url = self::URL_CREATE_TEST_USER;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Content-Type: application/json",
		   "Authorization: Bearer " . self::ACCESS_TOKEN,
		);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{"site_id":"MLB"}';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$this->testuser = json_decode($resp);
	}

	/**
	* @method Método: getTestUser() 
	* Descrição: Responsável retornar o objeto testuser
	*
	* @author Base em Tecnologia
	* @access public
	*
	* @param
	*
	* @return objeto testuser
	* Data: 11/08/2021
	*/

	public function getTestUser()
	{
		return $this->testuser;
	}
}

?>