<?php

namespace app\dao;

interface ICandidaturaDAO
{
    public function insert($candidatura);
    public function update($candidatura);
    public function delete($id);
    public function findById($idVaga, $idAluno);
    public function findAll();
    public function findByIdAluno($idAluno);
}
