<?php
$host = 'localhost';
$user = 'root';
$porta = '3307';
$password = '';
$db = 'tarefas';

$conexao = new PDO('mysql:host='.$host.';port='.$porta.';dbname='.$db, $user, $password);
