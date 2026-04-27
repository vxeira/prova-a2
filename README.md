# Gerenciador de Tarefas (Prova A2)

Aplicação web em **PHP** com **PDO** e **MySQL/MariaDB** para cadastro de usuários (login) e gestão de tarefas por usuário. Interface com **Bootstrap 5** (CDN).

Repositório: [github.com/vxeira/prova-a2](https://github.com/vxeira/prova-a2)

## Funcionalidades

- Login com sessão (`usuarios`, senha com hash **MD5** conforme o script SQL)
- Listagem de tarefas do usuário logado (`pendente` / `concluida`)
- Criar, editar, excluir e marcar tarefa como concluída

## Requisitos

- PHP 8+ (recomendado: [XAMPP](https://www.apachefriends.org/))
- MySQL ou MariaDB
- Extensão **pdo_mysql** habilitada no PHP

## Instalação

1. Clone ou copie o projeto para a pasta do Apache, por exemplo:
   - `C:\xampp\htdocs\prova`
2. Ajuste **`conexao.php`** com o host, porta, usuário, senha e nome do banco do seu ambiente (no XAMPP o `root` costuma ter senha vazia; a porta pode ser `3306` ou `3307`, conforme sua instalação).

## Banco de dados

1. Abra o **phpMyAdmin** (ou cliente MySQL) e importe o arquivo **`tarefas.sql`**.  
   Ele cria o banco `tarefas`, as tabelas `usuarios` e `tarefas` e um usuário inicial.

2. Se você já tinha um banco antigo **sem** as colunas `usuario_id` e `data_criacao` na tabela `tarefas`, importe também **`complemento_banco_sala.sql`** *depois* do script principal (só faz sentido nesse caso; o `tarefas.sql` completo já inclui essas colunas).

## Acesso inicial (após importar `tarefas.sql`)

| Campo    | Valor   |
|----------|---------|
| Usuário | `admin` |
| Senha   | `123456` |

*(Definidos no `INSERT` do script SQL; a senha é armazenada como `MD5('123456')`.)*

## Estrutura principal

| Arquivo / pasta | Descrição |
|------------------|-----------|
| `conexao.php`    | Conexão PDO com MySQL |
| `login.php` / `logout.php` | Autenticação |
| `sessao.php`     | Proteção das páginas autenticadas |
| `index.php`      | Lista de tarefas |
| `nova.php`, `editar.php`, `excluir.php`, `concluir.php` | CRUD e conclusão |
| `layout.php`     | HTML base + Bootstrap |
| `tarefas.sql`    | Estrutura e dados iniciais do banco |

## Licença

Uso educacional / prova acadêmica —
