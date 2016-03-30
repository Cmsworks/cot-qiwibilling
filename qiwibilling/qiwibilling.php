<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */
/**
 * Qiwi billing Plugin
 *
 * @package qiwibilling
 * @version 1.0
 * @author devkont (Yusupov)
 * @copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

$L['plu_title'] = $L['qiwibilling_title'];

require_once cot_incfile('qiwibilling', 'plug');
require_once cot_incfile('payments', 'module');

$m = cot_import('m', 'G', 'ALP');
$pid = cot_import('pid', 'G', 'INT');
$order = cot_import('order', 'G', 'INT');

if (empty($m))
{
	// Получаем информацию о заказе
	if (!empty($pid) && $pinfo = cot_payments_payinfo($pid))
	{
		cot_block($usr['id'] == $pinfo['pay_userid']);
		cot_block($pinfo['pay_status'] == 'new' || $pinfo['pay_status'] == 'process');
		
		$summ = number_format($pinfo['pay_summ']*$cfg['plugin']['qiwibilling']['rate'], 2, '.', '');
		
		if($cfg['plugin']['qiwibilling']['protocol'] == 'rest')
		{
			$to = cot_import('to', 'P', 'TXT', 15);
			
			if($a == 'send' && !empty($to))
			{
				$timePlusHour = $sys['now'] + 24*60*60;
				$loginPass = $cfg['plugin']['qiwibilling']['restid'].':'.$cfg['plugin']['qiwibilling']['restpass'];
				
				$parameters = array(
					'user' => 'tel:+'.$to,
					'amount' => $summ,
					'ccy' => $cfg['plugin']['qiwibilling']['currency'],
					'comment' => $pinfo['pay_desc'],
					'pay_source' => 'qw',
					'lifetime' => date('c', $timePlusHour),
					'prv_name' => $cfg['maintitle'],
				);

				$response = cot_qiwibilling_rest_send('https://w.qiwi.com/api/v2/prv/'.$cfg['plugin']['qiwibilling']['from'].'/bills/'.$pid, $loginPass, 'PUT', $parameters);
				$response = json_decode($response);
				
//				echo '<br/><br/><pre>';
//				print_r($response);
//				echo '</pre>';
				
				if($response->response->result_code == 0 && $response->response->bill->bill_id == $pid){
					cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"
					
					$successUrl =  urlencode($cfg['mainurl'] . "/" . cot_url('qiwibilling', 'm=success', '', true));
					$failUrl = urlencode($cfg['mainurl'] . "/" . cot_url('qiwibilling', 'm=fail', '', true));
					header("Location: https://w.qiwi.com/order/external/main.action?shop=".$cfg['plugin']['qiwibilling']['from']."&transaction=".$pid."&successUrl=" . $successUrl . "&failUrl=" . $failUrl);
					exit;
				}
			}
			
			$qiwi_form = "<form id=\"qiwiform\" class=\"form-inline\" name=pay method=\"POST\" action=\"".cot_url('qiwibilling', 'pid='.$pid.'&a=send')."\">
				".$L['qiwibilling_mobilephone'].": <input type=\"text\" name=\"to\" placeholder=\"79171234567\" value=\"".$to."\">
				<button class=\"btn btn-success\" type=\"submit\">".$L['qiwibilling_formbuy']."</button>
			</form>";

			$t->assign(array(
				'QIWI_FORM' => $qiwi_form,
			));
			$t->parse("MAIN.QIWIFORM");
		}
		else
		{
			$qiwi_form = "<form id=\"qiwiform\" class=\"form-inline\" name=pay method=\"POST\" action=\"http://w.qiwi.ru/setInetBill_utf.do\" target=\"_blank\">
				<input type=\"hidden\" name=\"from\" value=\"".$cfg['plugin']['qiwibilling']['from']."\">
				<input type=\"hidden\" name=\"summ\" value=\"".$summ."\">
				<input type=\"hidden\" name=\"com\" value=\"".$pinfo['pay_desc']."\">
				<input type=\"hidden\" name=\"lifetime\" value=\"5\">
				<input type=\"hidden\" name=\"check_agt\" value=\"true\">
				<input type=\"hidden\" name=\"txn_id\" value=\"".$pid."\">
				<input type=\"hidden\" name=\"create\" value=\"1\">
				".$L['qiwibilling_mobilephone'].": <input type=\"text\" name=\"to\" placeholder=\"9171234567\" value=\"".$to."\">
				<button class=\"btn btn-success\" type=\"submit\">".$L['qiwibilling_formbuy']."</button>
			</form>";

			$t->assign(array(
				'QIWI_FORM' => $qiwi_form,
			));
			$t->parse("MAIN.QIWIFORM");

			cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"
		}
	}
	else
	{
		cot_die();
	}
}
elseif ($m == 'success')
{
	$plugin_body = $L['qiwibilling_error_incorrect'];
	
	if (is_numeric($order))
	{
		$pinfo = cot_payments_payinfo($order);
		if ($pinfo['pay_status'] == 'done')
		{
			$plugin_body = $L['qiwibilling_error_done'];
		}
		elseif ($pinfo['pay_status'] == 'process')
		{
			$plugin_body = $L['qiwibilling_error_process'];
		}
		elseif ($pinfo['pay_status'] == 'paid')
		{
			$plugin_body = $L['qiwibilling_error_paid'];
		}
	}
	$t->assign(array(
		"QIWI_TITLE" => $L['qiwibilling_error_title'],
		"QIWI_ERROR" => $plugin_body
	));
	$t->parse("MAIN.ERROR");
}
elseif ($m == 'fail')
{
	$t->assign(array(
		"QIWI_TITLE" => $L['qiwibilling_error_title'],
		"QIWI_ERROR" => $L['qiwibilling_error_fail']
	));
	$t->parse("MAIN.ERROR");
}
?>