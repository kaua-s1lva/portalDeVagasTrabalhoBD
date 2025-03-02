-- Inserir usuarios (auto incremento)
INSERT INTO usuario (nome, email, senha, created_at) VALUES
('Empresa 1', 'empresa1@email.com', 'senha123', NOW()),
('Empresa 2', 'empresa2@email.com', 'senha123', NOW()),
('Empresa 3', 'empresa3@email.com', 'senha123', NOW()),
('Carlos Souza', 'carlos@email.com', 'senha123', NOW()),
('Lucas Mendes', 'lucas@email.com', 'senha123', NOW());

-- Inserir empresas associadas aos usuarios (usando idUsuario)
-- Assumindo que o idUsuario auto-incrementado começa de 1.
INSERT INTO empresa (idEmpresa, cnpj) VALUES
(1, '12345678000195'),
(2, '98765432000110'),
(3, '56789012000122');

-- Inserir alunos (idAluno é igual ao idUsuario)
INSERT INTO aluno (idAluno, cpf) VALUES
(4, '11122233344');

-- Inserir egressos (idEgresso é igual ao idUsuario)
INSERT INTO egresso (idEgresso, idEmpresa, cpf) VALUES
(5, 1, '99988877766');

-- Inserir etapas
INSERT INTO etapa (nome, descricao, created_at) VALUES
('Abertura', 'Vaga aberta para candidaturas', NOW()),
('Entrevista', 'Entrevistas em andamento', NOW()),
('Finalizada', 'Vaga preenchida', NOW());

-- Inserir vagas
INSERT INTO vaga (etapa_idEtapa, created_at, cargo, empresa_idEmpresa) VALUES
(1, NOW(), 'Desenvolvedor Backend', 1),
(2, NOW(), 'Analista de Dados', 2),
(1, NOW(), 'Engenheiro de Software', 3),
(3, NOW(), 'Designer UX/UI', 1);

-- Inserir situacoes
INSERT INTO situacao (nome, descricao) VALUES
('Em análise', 'Candidatura em análise'),
('Aprovado', 'Candidato aprovado para a vaga'),
('Rejeitado', 'Candidatura não aceita');


-- Inserir candidaturas
INSERT INTO candidatura (idVaga, aluno_idAluno, curriculo, created_at, situacao_idSituacao) VALUES
(1, 4, '\xDEADBEEF', NOW(), 1),
(2, 4, '\xBEEFDEAD', NOW(), 2),
(3, 4, '\xCAFEBABE', NOW(), 3);

-- Inserir status
INSERT INTO status (nome, descricao) VALUES
('Pendente', 'Indicação pendente'),
('Finalizado', 'Indicação concluída'),
('Cancelado', 'Indicação cancelada');

-- Inserir indicacoes
INSERT INTO indicacao (egresso_idEgresso, aluno_idAluno, vaga_idVaga, created_at, status_idStatus) VALUES
(5, 4, 1, NOW(), 1),
(5, 4, 2, NOW(), 2);

-- Inserir requisitos
INSERT INTO requisito (nome, duracao) VALUES
('Experiência com Java', '2 anos'),
('SQL Avançado', '1 ano'),
('Desenvolvimento Frontend', '1,5 anos');

-- Inserir vaga_requisito
INSERT INTO vaga_requisito (vaga_idVaga, requisito_idRequisito) VALUES
(1, 1),
(2, 2),
(3, 3);
