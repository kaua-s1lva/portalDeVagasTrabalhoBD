<?php

namespace app\dao;

interface IVagaDAO
{
    public function insert($vaga);
    public function update($vaga);
    public function delete($id);
    public function findById($id);
    public function findAll();
    public function findAllByIdEmpresa($id);
}
