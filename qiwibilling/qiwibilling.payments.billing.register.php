<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
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
defined('COT_CODE') or die('Wrong URL.');

$cot_billings['qiwi'] = array(
	'plug' => 'qiwibilling',
	'title' => 'Qiwi Кошелек',
	'icon' => $cfg['plugins_dir'] . '/qiwibilling/images/qiwi.png'
);

?>