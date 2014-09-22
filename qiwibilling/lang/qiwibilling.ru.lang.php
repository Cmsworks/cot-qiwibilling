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
$L['cfg_rate'] = array('Соотношение суммы к валюте сайта');

$L['qiwibilling_title'] = 'Qiwi';
$L['plu_title'] = 'Qiwi';

$L['qiwibilling_formtext'] = 'Для того чтобы продолжить оплату через платежную систему QIWI введите, пожалуста, номер вашего мобильного телефона.';
$L['qiwibilling_formbuy'] = 'Перейти к оплате';
$L['qiwibilling_error_process'] = 'Платеж находится на проверке. Пожалуйста, подождите.';
$L['qiwibilling_error_paid'] = 'Оплата прошла успешно. В ближайшее время услуга будет активирована!';
$L['qiwibilling_error_done'] = 'Оплата прошла успешно.';
$L['qiwibilling_error_incorrect'] = 'Некорректная подпись';
$L['qiwibilling_error_otkaz'] = 'Отказ от оплаты.';
$L['qiwibilling_error_title'] = 'Результат операции оплаты';
$L['qiwibilling_error_fail'] = 'Оплата не произведена! Пожалуйста, повторите попытку. Если ошибка повторится, обратитесь к администратору сайта';

$L['qiwibilling_mobilephone'] = 'Номер мобильного';
?>