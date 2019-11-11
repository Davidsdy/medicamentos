<?php
include_once "funcoes.php";

//Puxando os dados do formulario e protegendo com a função anti_hacker
$id = anti_hacker($_POST['idmedicamento']);

//Deletando medicamento.
$sql = executa("DELETE FROM medicamentos WHERE id='".anti_hacker($id)."'");
?>


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
<p>Medicamento excluído com sucesso !</p> 
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

<!---------------------------------------------------------------------------->
<!-- Javascript para funcionar o modal -->
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body></html>
