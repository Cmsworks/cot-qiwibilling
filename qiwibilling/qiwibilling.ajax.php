<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
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
defined('COT_CODE') or die('Wrong URL');

/**
 * На этот скрипт приходят уведомления от QIWI Кошелька.
 * SoapServer парсит входящий SOAP-запрос, извлекает значения тегов login, password, txn, status,
 * помещает их в объект класса Param и вызывает функцию updateBill объекта класса TestServer.
 *
 * Логика обработки магазином уведомления должна быть в updateBill.
 */

chdir('plugins/qiwibilling/');

$s = new SoapServer('IShopClientWS.wsdl', array('classmap' => array('tns:updateBill' => 'Param', 'tns:updateBillResponse' => 'Response')));
$s->setClass('MyQiwiServer');
$s->handle();

class Response
{
	public $updateBillResult;
}

class Param
{
	public $login;
	public $password;
	public $txn;      
	public $status;
}

class MyQiwiServer
{

	function updateBill($param)
	{		
		// В зависимости от статуса счета $param->status меняем статус заказа в магазине
		if ($param->status == 60)
			{
			// заказ оплачен
			// найти заказ по номеру счета ($param->txn), пометить как оплаченный

			chdir('../..');
			require_once cot_incfile('payments', 'module');
			if(cot_payments_updatestatus($param->txn, 'paid'))
			{		
				$ResultCode = 0;
			}
			else
			{
				$ResultCode = 210;
			}
		}
		else if ($param->status > 100)
		{
			// заказ не оплачен (отменен пользователем, недостаточно средств на балансе и т.п.)
			// найти заказ по номеру счета ($param->txn), пометить как неоплаченный
			$ResultCode = 210;

		}
		else if ($param->status >= 50 && $param->status < 60)
		{
			// счет в процессе проведения
			$ResultCode = 13;
		}
		else
		{
			// неизвестный статус заказа
			$ResultCode = 300;
		}

		// формируем ответ на уведомление
		// если все операции по обновлению статуса заказа в магазине прошли успешно, отвечаем кодом 0
		// $temp->updateBillResult = 0
		// если произошли временные ошибки (например, недоступность БД), отвечаем ненулевым кодом
		// в этом случае QIWI Кошелёк будет периодически посылать повторные уведомления пока не получит код 0
		// или не пройдет 24 часа
		$temp = new Response();
		$temp->updateBillResult = $ResultCode;
		return $temp;
	}
}
