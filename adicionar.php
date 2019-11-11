<?php
include_once "funcoes.php";

//Puxando os dados do formulario e protegendo com a função anti_hacker
$m = anti_hacker($_POST['medicamento']);
$l = anti_hacker($_POST['lote']);
$q = anti_hacker($_POST['quantidade']);
$v = anti_hacker($_POST['validade']);

//Caso a quantidade seja menor que 2 numeros apresentará isso
if(empty($q)){
js("index.php","Quantidade não pode está vazio."); }

//Caso o nome do medicamento esteja vazio
else if(empty($m)){
js("index.php","Nome do medicamento não pode ficar vazio."); }

//Se estiver tudo correto ele adicionara o item !
else{
$sql = executa("INSERT INTO medicamentos SET nome='".anti_hacker($m)."', lote='".anti_hacker($l)."', quantidade='".anti_hacker($q)."', validade='".anti_hacker($v)."'"); ?>


<!-- Modal para dizer que foi realizado com sucesso ! -->
 <div class="modal fade" id="modalok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">OK</h4> <!-- Aqui é o titulo do modal -->
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">

<!-- Conteudo do modal -->
<p>Medicamento adicionado com sucesso !</p> 
</div>

<!-- Rodape do modal -->
<div class="modal-footer">
<a href="index.php" class="btn btn-primary">Fechar</a>
</div></div></div></div>


<!-- Script rodando o modal ! -->
<script>
$(document).ready(function() {
    $('#modalok').modal();
});
</script>

<?php } ?>
<!---------------------------------------------------------------------------->
<!-- Javascript para funcionar o modal -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body></html>