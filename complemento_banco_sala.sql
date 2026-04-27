-- Rode ESTE arquivo no phpMyAdmin DEPOIS do script do professor
-- (CREATE DATABASE / usuarios / tarefas / INSERT admin).
-- Ele adiciona o que o sistema PHP da prova precisa: dono da tarefa + data.

USE tarefas;

-- Garante engine com suporte a chave estrangeira (ignore o erro se já for InnoDB)
ALTER TABLE usuarios ENGINE=InnoDB;
ALTER TABLE tarefas ENGINE=InnoDB;

ALTER TABLE tarefas
  ADD COLUMN usuario_id INT NOT NULL DEFAULT 1 COMMENT 'FK usuarios.id' AFTER descricao;

ALTER TABLE tarefas
  ADD COLUMN data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER status;

ALTER TABLE tarefas
  ADD CONSTRAINT fk_tarefas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE;

-- Tarefas antigas (se existirem) ficam com usuario_id = 1 (admin).
-- Ajuste manualmente se precisar: UPDATE tarefas SET usuario_id = X WHERE ...
