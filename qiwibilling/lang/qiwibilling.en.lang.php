<?php
/**
 * qiwibilling plugin
 *
 * @package qiwibilling
 * @version 1.0
 * @author devkont (Yusupov)
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */
$L['cfg_from'] = array('Qiwi-id');
$L['cfg_rate'] = array('Exchange rate');

$L['qiwibilling_title'] = 'Qiwi';
$L['plu_title'] = 'Qiwi';

$L['qiwibilling_formtext'] = 'In order to continue the payment via QIWI enter, please, your mobile phone number.';
$L['qiwibilling_formbuy'] = 'Go to payment';
$L['qiwibilling_error_process'] = 'Payment is by check. Please wait.';
$L['qiwibilling_error_paid'] = 'Payment was successful. In the near future the service will be activated!';
$L['qiwibilling_error_done'] = 'Payment was successful.';
$L['qiwibilling_error_incorrect'] = 'The signature is incorrect!';
$L['qiwibilling_error_otkaz'] = 'Failure to pay.';
$L['qiwibilling_error_title'] = 'Result of the operation of payment';
$L['qiwibilling_error_fail'] = 'Payment is not made! Please try again. If the problem persists, contact your site administrator';

$L['qiwibilling_mobilephone'] = 'Mobile number';
?>