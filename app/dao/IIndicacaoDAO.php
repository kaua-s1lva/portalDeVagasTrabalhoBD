<?php

namespace app\dao;

interface IIndicacaoDAO
{
    public function insert($indicacao);
    public function update($indicacao);
    public function delete($id);
    public function findById($id);
    public function findAll();
}
