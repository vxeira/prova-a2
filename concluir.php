<?php
require_once 'conexao.php';
require_once 'sessao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$usuario_id = (int) $_SESSION['usuario_id'];

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$sql = 'UPDATE tarefas SET status = :st WHERE id = :id AND usuario_id = :uid';
$stmt = $conexao->prepare($sql);
$status = 'concluida';
$stmt->bindParam(':st', $status);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':uid', $usuario_id, PDO::PARAM_INT);
$stmt->execute();

header('Location: index.php');
exit;
