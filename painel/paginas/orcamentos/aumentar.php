<?php 
$tabela = 'itens_orc';
require_once("../../../conexao.php");

$id = $_POST['id'];
$quantidade = $_POST['quantidade'];

$query = $pdo->query("SELECT * from $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_produto = $res[0]['produto'];
$valor = $res[0]['valor'];

$nova_quant = $quantidade + 1;
$novo_total = $valor * $nova_quant;


$pdo->query("UPDATE $tabela SET quantidade = '$nova_quant', total = '$novo_total' WHERE id = '$id' ");


echo 'Excluído com Sucesso';

?>