<?php
session_start();

require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Egresso.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EgressoDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

SessaoUsuarioSingleton::getInstance()->logout();