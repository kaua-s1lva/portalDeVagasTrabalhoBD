<?php

    class VagaDAO implements IDAO
    {
        private $conexao;

        public function __construct(PDO $conexao)
        {
            $this->conexao = $conexao;
        }

        public function insert($entity): bool
        {
            if (!$entity instanceof Vaga) {
                throw new InvalidArgumentException("Expected instance of Vaga");
            }

            $sql = "INSERT INTO vagas (id_vaga, etapa_id, cargo, empresa_id, created_at, updated_at, deleted_at)
                    VALUES (:id_vaga, :etapa_id, :cargo, :empresa_id, :created_at, :updated_at, :deleted_at)";
            
            $stmt = $this->conexao->prepare($sql);
            
            $stmt->bindValue(':id_vaga', $entity->getIdVaga());
            $stmt->bindValue(':etapa_id', $entity->getEtapaId());
            $stmt->bindValue(':cargo', $entity->getCargo());
            $stmt->bindValue(':empresa_id', $entity->getEmpresaId());
            $stmt->bindValue(':created_at', $entity->getCreatedAt()->format('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', $entity->getUpdatedAt() ? $entity->getUpdatedAt()->format('Y-m-d H:i:s') : null);
            $stmt->bindValue(':deleted_at', $entity->getDeletedAt() ? $entity->getDeletedAt()->format('Y-m-d H:i:s') : null);

            return $stmt->execute();
        }

        public function update($entity): bool
        {
            if (!$entity instanceof Vaga) {
                throw new InvalidArgumentException("Expected instance of Vaga");
            }

            $sql = "UPDATE vagas SET
                    etapa_id = :etapa_id,
                    cargo = :cargo,
                    empresa_id = :empresa_id,
                    updated_at = :updated_at,
                    deleted_at = :deleted_at
                    WHERE id_vaga = :id_vaga";
            
            $stmt = $this->conexao->prepare($sql);
            
            $stmt->bindValue(':id_vaga', $entity->getIdVaga());
            $stmt->bindValue(':etapa_id', $entity->getEtapaId());
            $stmt->bindValue(':cargo', $entity->getCargo());
            $stmt->bindValue(':empresa_id', $entity->getEmpresaId());
            $stmt->bindValue(':updated_at', $entity->getUpdatedAt() ? $entity->getUpdatedAt()->format('Y-m-d H:i:s') : null);
            $stmt->bindValue(':deleted_at', $entity->getDeletedAt() ? $entity->getDeletedAt()->format('Y-m-d H:i:s') : null);

            return $stmt->execute();
        }

        public function delete($id): bool
        {
            $sql = "UPDATE vagas SET deleted_at = NOW() WHERE id_vaga = :id_vaga";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id_vaga', $id);

            return $stmt->execute();
        }

        public function findById($id)
        {
            $sql = "SELECT * FROM vagas WHERE id_vaga = :id_vaga AND deleted_at IS NULL";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id_vaga', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $vaga = new Vaga(
                    $row['id_vaga'],
                    $row['etapa_id'],
                    $row['cargo'],
                    $row['empresa_id']
                );

                $vaga->setCreatedAt(new DateTime($row['created_at']));
                $vaga->setUpdatedAt($row['updated_at'] ? new DateTime($row['updated_at']) : null);
                $vaga->setDeletedAt($row['deleted_at'] ? new DateTime($row['deleted_at']) : null);

                return $vaga;
            }

            return null;
        }

        public function findAll(): array
        {
            $sql = "SELECT * FROM vagas WHERE deleted_at IS NULL";
            $stmt = $this->conexao->query($sql);

            $vagas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $vaga = new Vaga(
                    $row['id_vaga'],
                    $row['etapa_id'],
                    $row['cargo'],
                    $row['empresa_id']
                );

                $vaga->setCreatedAt(new DateTime($row['created_at']));
                $vaga->setUpdatedAt($row['updated_at'] ? new DateTime($row['updated_at']) : null);
                $vaga->setDeletedAt($row['deleted_at'] ? new DateTime($row['deleted_at']) : null);

                $vagas[] = $vaga;
            }

            return $vagas;
        }
    }
?>