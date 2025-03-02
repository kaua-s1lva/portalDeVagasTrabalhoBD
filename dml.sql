-- Inserir usuarios (25 ao todo, incluindo empresas, alunos e egressos)
INSERT INTO USUARIO (nomeUsuario, emailUsuario, senhaUsuario, created_at) VALUES
('Empresa 1', 'empresa1@email.com', 'senha123', NOW()),
('Empresa 2', 'empresa2@email.com', 'senha123', NOW()),
('Empresa 3', 'empresa3@email.com', 'senha123', NOW()),
('Empresa 4', 'empresa4@email.com', 'senha123', NOW()),
('Empresa 5', 'empresa5@email.com', 'senha123', NOW()),
('Carlos Souza', 'carlos@email.com', 'senha123', NOW()),
('Lucas Mendes', 'lucas@email.com', 'senha123', NOW()),
('Maria Oliveira', 'maria@email.com', 'senha123', NOW()),
('João Silva', 'joao@email.com', 'senha123', NOW()),
('Fernanda Costa', 'fernanda@email.com', 'senha123', NOW()),
('Ricardo Lima', 'ricardo@email.com', 'senha123', NOW()),
('Ana Santos', 'ana@email.com', 'senha123', NOW()),
('Paulo Rocha', 'paulo@email.com', 'senha123', NOW()),
('Juliana Almeida', 'juliana@email.com', 'senha123', NOW()),
('Rafael Souza', 'rafael@email.com', 'senha123', NOW()),
('Daniela Lima', 'daniela@email.com', 'senha123', NOW()),
('Carlos Henrique', 'carloshenrique@email.com', 'senha123', NOW()),
('Tatiane Santos', 'tatiane@email.com', 'senha123', NOW()),
('Vitor Costa', 'vitor@email.com', 'senha123', NOW()),
('Fabiana Oliveira', 'fabiana@email.com', 'senha123', NOW()),
('Renato Costa', 'renato@email.com', 'senha123', NOW()),
('Beatriz Pereira', 'beatriz@email.com', 'senha123', NOW()),
('Leandro Costa', 'leandro@email.com', 'senha123', NOW()),
('Gabriela Martins', 'gabriela@email.com', 'senha123', NOW()),
('Marcos Silva', 'marcos@email.com', 'senha123', NOW()); -- Adicionando o 25º usuário

-- Inserir empresas associadas aos usuarios (usando idUsuario)
-- Os idUsuarios começam de 1 para empresas
INSERT INTO EMPRESA (idEmpresa, cnpj) VALUES
(1, '12345678000195'),
(2, '98765432000110'),
(3, '56789012000122'),
(4, '23456789000133'),
(5, '34567890100144');

-- Inserir alunos (idAluno é igual ao idUsuario, começando de 6 até 15)
INSERT INTO ALUNO (idAluno, cpf) VALUES
(6, '11122233344'),
(7, '22334455666'),
(8, '33445566777'),
(9, '44556677888'),
(10, '55667788999'),
(11, '66778899000'),
(12, '77889900111'),
(13, '88990011222'),
(14, '99001122333'),
(15, '10111223344');

-- Inserir egressos (idEgresso é igual ao idUsuario, começando de 16 até 25)
INSERT INTO EGRESSO (idEgresso, idEmpresa, cpf) VALUES
(16, 1, '99988877766'),
(17, 2, '88877766655'),
(18, 3, '77766655544'),
(19, 4, '66655544433'),
(20, 5, '55544433322'),
(21, 1, '44433322211'),
(22, 2, '33322211100'),
(23, 3, '22211100099'),
(24, 4, '11100099988'),
(25, 5, '00099988877');

-- Inserir etapas
INSERT INTO ETAPA (nomeEtapa, descricaoEtapa, created_at) VALUES
('Abertura', 'Vaga aberta para candidaturas', NOW()),
('Entrevista', 'Entrevistas em andamento', NOW()),
('Finalizada', 'Vaga preenchida', NOW()),
('Aprovada', 'Vaga com candidato aprovado', NOW()),
('Em andamento', 'Vaga em processo de preenchimento', NOW());

-- Inserir vagas
INSERT INTO VAGA (idEtapa, idEmpresa, cargo, created_at) VALUES
(1, 1, 'Desenvolvedor Backend', NOW()),
(2, 2, 'Analista de Dados', NOW()),
(3, 3, 'Engenheiro de Software', NOW()),
(4, 1, 'Designer UX/UI', NOW()),
(5, 2, 'Gerente de Projetos', NOW()),
(1, 3, 'Desenvolvedor Frontend', NOW()),
(3, 1, 'Analista de Sistemas', NOW()),
(2, 3, 'Arquiteto de Software', NOW()),
(4, 2, 'Product Owner', NOW()),
(5, 1, 'Desenvolvedor Full Stack', NOW());

-- Inserir situacoes
INSERT INTO SITUACAO (nomeSituacao, descricaoSituacao) VALUES
('Em análise', 'Candidatura em análise'),
('Aprovado', 'Candidato aprovado para a vaga'),
('Rejeitado', 'Candidatura não aceita'),
('Entrevista agendada', 'Entrevista agendada com o candidato'),
('Em processo', 'Candidatura em andamento');

-- Inserir candidaturas
INSERT INTO CANDIDATURA (idVaga, idAluno, curriculo, idSituacao, created_at) VALUES
(1, 6, '\xDEADBEEF', 1, NOW()),
(2, 7, '\xBEEFDEAD', 2, NOW()),
(3, 8, '\xCAFEBABE', 3, NOW()),
(4, 9, '\xDECAF000', 4, NOW()),
(5, 10, '\xFEEDC0FFEE', 2, NOW()),
(6, 11, '\xBAADF00D', 1, NOW()),
(7, 12, '\x12345678', 5, NOW()),
(8, 13, '\xABCD1234', 2, NOW()),
(9, 14, '\x56789ABC', 3, NOW()),
(10, 15, '\x9ABCDEF0', 4, NOW());

-- Inserir status
INSERT INTO STATUS (nomeStatus, descricaoStatus) VALUES
('Pendente', 'Indicação pendente'),
('Finalizado', 'Indicação concluída'),
('Cancelado', 'Indicação cancelada'),
('Em progresso', 'Indicação em processo'),
('Rejeitado', 'Indicação não aceita');

-- Inserir indicacoes
INSERT INTO INDICACAO (idEgresso, idAluno, idVaga, idStatus, created_at) VALUES
(16, 6, 1, 1, NOW()),
(17, 7, 2, 2, NOW()),
(18, 8, 3, 3, NOW()),
(19, 9, 4, 4, NOW()),
(20, 10, 5, 5, NOW()),
(21, 11, 6, 1, NOW()),
(22, 12, 7, 2, NOW()),
(23, 13, 8, 3, NOW()),
(24, 14, 9, 4, NOW()),
(25, 15, 10, 5, NOW());

-- Inserir requisitos
INSERT INTO REQUISITO (nomeRequisito) VALUES
('Experiência com Java'),
('SQL Avançado'),
('Desenvolvimento Frontend'),
('Gerenciamento de Projetos'),
('Metodologias Ágeis'),
('Arquitetura de Software');

-- Inserir vaga_requisito
INSERT INTO VAGA_REQUISITO (idVaga, idRequisito, duracaoVagaRequisito) VALUES
(1, 1, '2 anos'),
(2, 2, '1 ano'),
(3, 3, '1,5 anos'),
(4, 4, '3 anos'),
(5, 5, '2 anos'),
(6, 6, '4 anos'),
(7, 1, '5 anos'),
(8, 3, '3,5 anos'),
(9, 5, '2,5 anos'),
(10, 4, '3,5 anos');