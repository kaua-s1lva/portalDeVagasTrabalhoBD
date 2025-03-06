<?php

namespace app\dao;

interface IUsuarioDAO
{
    public function insert($usuario);
    public function update($usuario);
    public function delete($id);
}
