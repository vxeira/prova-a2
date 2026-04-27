<?php
require_once 'conexao.php';
require_once 'sessao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$usuario_id = (int) $_SESSION['usuario_id'];

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$sql_busca = 'SELECT id, titulo, descricao, status FROM tarefas WHERE id = :id AND usuario_id = :usuario_id';
$stmt_busca = $conexao->prepare($sql_busca);
$stmt_busca->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_busca->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt_busca->execute();
$tarefa = $stmt_busca->fetch(PDO::FETCH_OBJ);

if ($tarefa === false) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'pendente';
    if ($status !== 'pendente' && $status !== 'concluida') {
        $status = 'pendente';
    }

    if ($titulo === '') {
        $erro = 'O título é obrigatório.';
    } else {
        $sql_update = 'UPDATE tarefas SET titulo = :t, descricao = :d, status = :s WHERE id = :id AND usuario_id = :uid';
        $stmt = $conexao->prepare($sql_update);
        $stmt->bindParam(':t', $titulo);
        $stmt->bindParam(':d', $descricao);
        $stmt->bindParam(':s', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
}

$statusParaForm = isset($_POST['status']) ? $_POST['status'] : $tarefa->status;
if ($statusParaForm !== 'pendente' && $statusParaForm !== 'concluida') {
    $statusParaForm = 'pendente';
}

$titulo_pagina = 'Editar tarefa';
require_once 'layout.php';
?>
<div class="mb-3">
    <a href="index.php" class="btn btn-outline-secondary btn-sm">&larr; Voltar</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="h5 mb-3">Editar tarefa</h3>
        <?php if ($erro !== '') { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>
        <form method="post" action="editar.php?id=<?php echo (int) $tarefa->id; ?>">
            <div class="mb-3">
                <label class="form-label" for="titulo">Título <span class="text-danger">*</span></label>
                <input type="text" name="titulo" id="titulo" class="form-control" required maxlength="255"
                       value="<?php echo htmlspecialchars(isset($_POST['titulo']) ? $_POST['titulo'] : $tarefa->titulo, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="3"><?php echo htmlspecialchars(isset($_POST['descricao']) ? $_POST['descricao'] : $tarefa->descricao, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="pendente"<?php echo $statusParaForm === 'pendente' ? ' selected' : ''; ?>>pendente</option>
                    <option value="concluida"<?php echo $statusParaForm === 'concluida' ? ' selected' : ''; ?>>concluida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar tarefa</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php require_once 'rodape.php'; ?>
