<?php
require_once 'conexao.php';
require_once 'sessao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $usuario_id = (int) $_SESSION['usuario_id'];

    if ($titulo === '') {
        $erro = 'O título é obrigatório.';
    } else {
        $sql = 'INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (:t, :d, :uid)';
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':t', $titulo);
        $stmt->bindParam(':d', $descricao);
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
}

$titulo_pagina = 'Nova tarefa';
require_once 'layout.php';
?>
<div class="mb-3">
    <a href="index.php" class="btn btn-outline-secondary btn-sm">&larr; Voltar</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="h5 mb-3">Nova tarefa</h3>
        <?php if ($erro !== '') { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>
        <form method="post" action="nova.php">
            <div class="mb-3">
                <label class="form-label" for="titulo">Título <span class="text-danger">*</span></label>
                <input type="text" name="titulo" id="titulo" class="form-control" required maxlength="255"
                       value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="3"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Salvar tarefa</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php require_once 'rodape.php'; ?>
