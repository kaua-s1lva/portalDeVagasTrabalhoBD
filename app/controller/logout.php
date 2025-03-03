<?php

use app\singleton\SessaoUsuarioSingleton;

session_start();

SessaoUsuarioSingleton::getInstance()->logout();