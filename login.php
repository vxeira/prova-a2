<?php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_form = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $senha_form = md5(isset($_POST['senha']) ? $_POST['senha'] : '');

    $sql = 'SELECT id, usuario FROM usuarios WHERE usuario = :u AND senha = :s';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':u', $user_form);
    $stmt->bindParam(':s', $senha_form);
    $stmt->execute();

    $dados = $stmt->fetch(PDO::FETCH_OBJ);
    if ($dados !== false) {
        $_SESSION['usuario_id'] = $dados->id;
        $_SESSION['usuario'] = $dados->usuario;
        header('Location: index.php');
        exit;
    }
    $erro = 'Usuário ou senha incorretos!';
}

$titulo_pagina = 'Login';
require_once 'layout.php';
?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title text-center mb-3">Login</h4>
                <?php if ($erro !== '') { ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php } ?>
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label class="form-label" for="usuario">Usuário</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'rodape.php'; ?>
