<?php
namespace app\chain;
interface IAutenticador {
    public function autenticar($email, $password);
}
?>