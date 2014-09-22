<?php

/**
 * Qiwi billing plugin
 *
 * @package qiwibilling
 * @version 1.0
 * @author devkont (Yusupov)
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
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

// Requirements
require_once cot_langfile('qiwibilling', 'plug');

function cot_qiwibilling_rest_send($url, $loginPass, $requestType = 'POST', $parameters = array())
{
	$headers = array(
		"Accept: text/json",
		"Content-Type: application/x-www-form-urlencoded; charset=utf-8"
	);
			
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $loginPass);
	
	$results = curl_exec ($ch) or die(curl_error($ch));
	curl_close ($ch);
	
	return $results;
}