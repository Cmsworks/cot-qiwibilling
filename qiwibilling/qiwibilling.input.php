<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=input
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

$r = cot_import('r', 'G', 'ALP');

if ($r == 'qiwibilling')
{
	$cfg['referercheck'] = false;
	define('COT_NO_ANTIXSS', TRUE);
}
?>