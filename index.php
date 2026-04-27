<?php
/**
 * Framework visual escolhido: Bootstrap 5
 * Importação: layout.php (CDN Bootstrap 5.3.0 no <head>)
 */
require_once 'conexao.php';
require_once 'sessao.php';

$titulo_pagina = 'Minhas tarefas';
require_once 'layout.php';

$idUsuario = (int) $_SESSION['usuario_id'];
$sql = 'SELECT id, titulo, descricao, status, data_criacao FROM tarefas WHERE usuario_id = '.$idUsuario.' ORDER BY data_criacao DESC';
$consulta = $conexao->query($sql);
$temLinhas = false;
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0">Minhas tarefas</h1>
    <a href="nova.php" class="btn btn-success">+ Nova tarefa</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Data de criação</th>
                        <th class="text-center text-nowrap">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = $consulta->fetch(PDO::FETCH_OBJ)) {
                        $temLinhas = true;
                        $dataFmt = date('d/m/Y H:i', strtotime($linha->data_criacao));
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha->titulo, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($linha->status === 'concluida') { ?>
                                    <span class="badge bg-success">concluida</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning text-dark">pendente</span>
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($dataFmt, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center text-nowrap">
                                <a href="editar.php?id=<?php echo (int) $linha->id; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="concluir.php?id=<?php echo (int) $linha->id; ?>" class="btn btn-sm btn-info text-white">Concluir</a>
                                <a href="excluir.php?id=<?php echo (int) $linha->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta tarefa?');">Excluir</a>
                            </td>
                        </tr>
                        <?php
                    }
                    if (!$temLinhas) {
                        ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Nenhuma tarefa cadastrada.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'rodape.php'; ?>
