-- Inserir usuarios
INSERT INTO usuario (idUsuario, nome, email, senha, created_at) VALUES
(1, 'João Silva', 'joao@email.com', 'senha123', NOW()),
(2, 'Maria Oliveira', 'maria@email.com', 'senha123', NOW()),
(3, 'Carlos Souza', 'carlos@email.com', 'senha123', NOW()),
(4, 'Ana Pereira', 'ana@email.com', 'senha123', NOW()),
(5, 'Lucas Mendes', 'lucas@email.com', 'senha123', NOW());

-- Inserir etapas
INSERT INTO etapa (idEtapa, nome, descricao, created_at) VALUES
(1, 'Abertura', 'Vaga aberta para candidaturas', NOW()),
(2, 'Entrevista', 'Entrevistas em andamento', NOW()),
(3, 'Finalizada', 'Vaga preenchida', NOW());

-- Inserir empresas
INSERT INTO empresa (idEmpresa, cnpj) VALUES
(1, '12345678000195'),
(2, '98765432000110'),
(3, '56789012000122');

-- Inserir vagas
INSERT INTO vaga (idVaga, etapa_idEtapa, created_at, cargo, empresa_idEmpresa) VALUES
(1, 1, NOW(), 'Desenvolvedor Backend', 1),
(2, 2, NOW(), 'Analista de Dados', 2),
(3, 1, NOW(), 'Engenheiro de Software', 3),
(4, 3, NOW(), 'Designer UX/UI', 1);

-- Inserir situacoes
INSERT INTO situacao (idSituacao, nome, descricao) VALUES
(1, 'Em análise', 'Candidatura em análise'),
(2, 'Aprovado', 'Candidato aprovado para a vaga'),
(3, 'Rejeitado', 'Candidatura não aceita');

-- Inserir alunos
INSERT INTO aluno (idAluno, cpf) VALUES
(2, '11122233344'),
(3, '55566677788'),
(4, '99988877755');

-- Inserir candidaturas
INSERT INTO candidatura (idVaga, aluno_idAluno, curriculo, created_at, situacao_idSituacao) VALUES
(1, 2, '\xDEADBEEF', NOW(), 1),
(2, 3, '\xBEEFDEAD', NOW(), 2),
(3, 4, '\xCAFEBABE', NOW(), 3);

-- Inserir egressos
INSERT INTO egresso (idEgresso, idEmpresa, cpf) VALUES
(3, 1, '99988877766'),
(4, 2, '11223344556');

-- Inserir status
INSERT INTO status (idstatus, nome, descricao) VALUES
(1, 'Pendente', 'Indicação pendente'),
(2, 'Finalizado', 'Indicação concluída'),
(3, 'Cancelado', 'Indicação cancelada');

-- Inserir indicacoes
INSERT INTO indicacao (egresso_idEgresso, aluno_idAluno, vaga_idVaga, created_at, status_idStatus) VALUES
(3, 2, 1, NOW(), 1),
(4, 3, 2, NOW(), 2);

-- Inserir requisitos
INSERT INTO requisito (idRequisito, nome, duracao) VALUES
(1, 'Experiência com Java', '2 anos'),
(2, 'SQL Avançado', '1 ano'),
(3, 'Desenvolvimento Frontend', '1,5 anos');

-- Inserir vaga_requisito
INSERT INTO vaga_requisito (vaga_idVaga, requisito_idRequisito) VALUES
(1, 1),
(2, 2),
(3, 3);