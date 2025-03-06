<?php

namespace app\dao;

interface IEtapaDAO
{
    public function insert($etapa);
    public function update($etapa);
    public function delete($idEtapa);
    public function findById($id);
    public function findAll();
}
