<?php
session_start();
error_reporting(0);
ini_set("display_errors", 0);
date_default_timezone_set("America/Sao_Paulo");
include_once "conteudo.php";
#----------------------------------------------------------------
//Conexão com o banco de dados
$conecta = mysqli_connect("localhost","root","vertrigo","medicamentos");
#----------------------------------------------------------------
//Caso não consiga se conectar com o banco de dados mostrará isso
if(!($conecta)){
echo "<center><h1>Banco de dados sem conexão !</h1></center>"; exit; }
#----------------------------------------------------------------
//Caso tentem acessar esse arquivo de configuração
$bloquearacesso="funcoes.php";
if(basename($_SERVER["PHP_SELF"])==$bloquearacesso){
ob_start();
echo '<SCRIPT Language="javascript">
alert("SEM PERMISSÃO DE ACESSO !");
location.href="index.php";
</SCRIPT>';
die("<script>alert('Sem permição de acesso!')</script>\n<script>window.location=('/')</script>"); }
#----------------------------------------------------------------
//função sistema, para pegar dados da tabela sistema.
function sistema($id){ global $conecta;
$sql = mysqli_fetch_array(mysqli_query($conecta, "SELECT valor FROM sistema WHERE id='".$id."'"));
return $sql[0]; }
#----------------------------------------------------------------
//Função anti hacker
function anti_hacker($string){ global $conecta;
$string = @trim($string);//remove todos os espaços dos lados diretos e esquerdos
$string = @strip_tags($string);
$string = @stripslashes($string);
$string = @mysqli_real_escape_string($conecta, $string);
return $string; }
#----------------------------------------------------------------
//Função de redirecionamento
function js($url, $msg){
echo "<script type='text/javascript'>
alert('$msg');
window.location='$url';
</script>"; }
#----------------------------------------------------------------
//Função de query
function executa($query){ global $conecta;
$sql = mysqli_query($conecta, $query);
return $sql; }
#----------------------------------------------------------------
//Proteção anti_hacker
$_GET = array_map("anti_hacker", $_GET);
$_GET = array_map("addslashes", $_GET);
$_GET = array_map("strip_tags", $_GET);
$_GET = array_map('trim', $_GET);

$_POST = array_map("anti_hacker", $_POST);
$_POST = array_map("addslashes", $_POST);
$_POST = array_map("strip_tags", $_POST);
$_POST = array_map('trim', $_POST);
#-------------------------------------------------------
// Definindo charset
mysqli_query($conecta,"SET NAMES 'utf8'");
mysqli_query($conecta,'SET character_set_connection=utf8');
mysqli_query($conecta,'SET character_set_client=utf8');
mysqli_query($conecta,'SET character_set_results=utf8');
#-------------------------------------------------------
?>