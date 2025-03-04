<?php
    namespace app\dao;
    interface IDAO {
        public function insert($entity);
        public function update($entity);
        public function delete($id);
        //public function findById($id);
        //public function findAll();
    }
?>