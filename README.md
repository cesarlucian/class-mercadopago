# class-mercadopago
Classe para integração com mercado pago utilizando sua SDK, versão 2.4.2

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
ideal salvar o id de um plano criado no banco de dados para utilizar depois em cancelamento de assinatura, e etc...

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