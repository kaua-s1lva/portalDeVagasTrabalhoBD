-- Inserir usuarios (25 ao todo, incluindo empresas, alunos e egressos)
INSERT INTO USUARIO (nomeUsuario, emailUsuario, senhaUsuario) VALUES
('Empresa 1', 'empresa1@email.com', 'senha123'),
('Empresa 2', 'empresa2@email.com', 'senha123'),
('Empresa 3', 'empresa3@email.com', 'senha123'),
('Empresa 4', 'empresa4@email.com', 'senha123'),
('Empresa 5', 'empresa5@email.com', 'senha123'),
('Carlos Souza', 'carlos@edu.ufes.br', 'senha123'),
('Lucas Mendes', 'lucas@edu.ufes.br', 'senha123'),
('Maria Oliveira', 'maria@edu.ufes.br', 'senha123'),
('João Silva', 'joao@edu.ufes.br', 'senha123'),
('Fernanda Costa', 'fernanda@edu.ufes.br', 'senha123'),
('Ricardo Lima', 'ricardo@edu.ufes.br', 'senha123'),
('Ana Santos', 'ana@edu.ufes.br', 'senha123'),
('Paulo Rocha', 'paulo@edu.ufes.br', 'senha123'),
('Juliana Almeida', 'juliana@edu.ufes.br', 'senha123'),
('Rafael Souza', 'rafael@edu.ufes.br', 'senha123'),
('Daniela Lima', 'daniela@email.com', 'senha123'),
('Carlos Henrique', 'carloshenrique@email.com', 'senha123'),
('Tatiane Santos', 'tatiane@email.com', 'senha123'),
('Vitor Costa', 'vitor@email.com', 'senha123'),
('Fabiana Oliveira', 'fabiana@email.com', 'senha123'),
('Renato Costa', 'renato@email.com', 'senha123'),
('Beatriz Pereira', 'beatriz@email.com', 'senha123'),
('Leandro Costa', 'leandro@email.com', 'senha123'),
('Gabriela Martins', 'gabriela@email.com', 'senha123'),
('Marcos Silva', 'marcos@email.com', 'senha123');

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
INSERT INTO ETAPA (nomeEtapa, descricaoEtapa) VALUES
('Em Aberto', 'Vaga aberta para candidaturas'),
('Em triagem', 'Vaga em Triagem'),
('Em entrevista', 'Entrevista em andamento'),
('Concluído', 'Vaga preenchida');

-- Inserir vagas
INSERT INTO VAGA (idEtapa, idEmpresa, cargo) VALUES
(1, 1, 'Desenvolvedor Backend'),
(2, 2, 'Analista de Dados'),
(3, 3, 'Engenheiro de Software'),
(4, 1, 'Designer UX/UI'),
(2, 2, 'Gerente de Projetos'),
(1, 3, 'Desenvolvedor Frontend'),
(3, 1, 'Analista de Sistemas'),
(2, 3, 'Arquiteto de Software'),
(4, 2, 'Product Owner'),
(2, 1, 'Desenvolvedor Full Stack');

-- Inserir situacoes
INSERT INTO SITUACAO (nomeSituacao, descricaoSituacao) VALUES
('Em análise', 'Candidatura em análise'),
('Aprovado', 'Candidato aprovado para a vaga'),
('Rejeitado', 'Candidatura não aceita'),
('Entrevista agendada', 'Entrevista agendada com o candidato'),
('Em processo', 'Candidatura em andamento');

-- Inserir candidaturas
INSERT INTO CANDIDATURA (idVaga, idAluno, curriculo, idSituacao) VALUES
(1, 6, '\xDEADBEEF', 1),
(2, 7, '\xBEEFDEAD', 2),
(3, 8, '\xCAFEBABE', 3),
(4, 9, '\xDECAF000', 4),
(5, 10, '\xFEEDC0FFEE', 2),
(6, 11, '\xBAADF00D', 1),
(7, 12, '\x12345678', 5),
(8, 13, '\xABCD1234', 2),
(9, 14, '\x56789ABC', 3),
(10, 15, '\x9ABCDEF0', 4);

-- Inserir status
INSERT INTO STATUS (nomeStatus, descricaoStatus) VALUES
('Pendente', 'Indicação pendente'),
('Finalizado', 'Indicação concluída'),
('Cancelado', 'Indicação cancelada'),
('Em progresso', 'Indicação em processo'),
('Rejeitado', 'Indicação não aceita');

-- Inserir indicacoes
INSERT INTO INDICACAO (idEgresso, idAluno, idVaga, idStatus) VALUES
(16, 6, 1, 1),
(17, 7, 2, 2),
(18, 8, 3, 3),
(19, 9, 4, 4),
(20, 10, 5, 1),
(21, 11, 6, 1),
(22, 12, 7, 5),
(23, 13, 8, 3),
(24, 14, 9, 5),
(25, 15, 10, 1);

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