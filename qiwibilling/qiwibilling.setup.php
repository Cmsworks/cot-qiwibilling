<?php

/**
 * [BEGIN_COT_EXT]
 * Code=qiwibilling
 * Name=Qiwibilling
 * Category=Payments
 * Description=Qiwi billing system
 * Version=1.0.3
 * Date=
 * Author=
 * Copyright=&copy; CMSWorks Team 2013
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=payments
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * from=01:string:::Qiwi-id
 * protocol=02:select:soap,rest:soap:Протокол взаимодействия с QIWI
 * currency=03:string::RUB:Код валюты, в которой происходит оплата (для REST-протокола)
 * restid=04:string:::ID-магазина (для REST-протокола) 
 * restpass=05:string:::Пароль (для REST-протокола) 
 * rate=06:string::1:Соотношение суммы к валюте сайта
 * [END_COT_EXT_CONFIG]
 */

/**
 * Qiwi billing Plugin
 *
 * @package qiwibilling
 * @version 1.0.3
 * @author devkont (Yusupov)
 * @copyright (c) CMSWorks Team 2013
 * @license BSD
 */
?>