<?php include_once "funcoes.php"; ?>
<!---------------------------------------------------------------------------->
<!-- Navbar com logo -->
<nav class="navbar navbar-dark bg-dark" style="border-box: 5px;">

<!-- Logo com link do index.php -->
<a class="navbar-brand" href="index.php"> 
<img src="imagens/logo.png" class="d-inline-block align-top" alt=""></a>

<!-- Botão de adicionar medicamento -->
<form class="form-inline">
<button class="btn btn-success" data-toggle="modal" data-target="#modaladd" type="button">
<i class="fa fa-plus" aria-hidden="true"></i> Adicionar Medicamento</button>
</form></nav>
<!---------------------------------------------------------------------------->
<!-- Modal de adicionar item -->
 <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Adicionando item</h4> <!-- Aqui é o titulo do modal -->
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
<div class="modal-body">

<!-- Formulario para adicionar o medicamento -->
<form action="adicionar.php" method="POST">
<div class="form-row">

<!-- Input do medicamento -->
<div class="form-group col-md-6">
<label for="medicamento">Medicamento</label>
<input type="text" class="form-control" name="medicamento" placeholder="Nome do Medicamento" required autofocus></div>

<!-- Input do lote -->
<div class="form-group col-md-6">
<label for="lote">Lote</label>
<input type="text" class="form-control" name="lote" placeholder="Numero do Lote"></div>

<!-- Input da quantidade -->
<div class="form-group col-md-6">
<label for="quantidade">Quantidade</label>
<input type="text" class="form-control" name="quantidade" placeholder="Quantidade"></div>

<!-- Input da validade -->
<div class="form-group col-md-6">
<label for="inputAddress2">Validade</label>
<input type="date" class="form-control" name="validade" placeholder="Data de Validade" required>
</div></div></div>

<!-- Rodape do modal -->
<div class="modal-footer">
<input type="submit" class="btn btn-primary" value="Adicionar">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</form>
</div></div></div></div>

<!-- Fim do modal -->
<!---------------------------------------------------------------------------->
<!-- Busca na tabela -->

<!---------------------------------------------------------------------------->
<!-- Tabela para mostrar os medicamentos -->
<table id="table" class="table table-bordered table-hover table-striped">
<thead class="thead-light">
<tr>
<th scope="col">N°</th>
<th scope="col">Medicação <a href="?ord=1"><img src="imagens/up.png"></a>
<a href="?ord=2"><img src="imagens/down.png"></a></th>
<th scope="col">Lote <a href="?ord=3"><img src="imagens/up.png"></a>
<a href="?ord=4"><img src="imagens/down.png"></a></th>
<th scope="col">Quantidade <a href="?ord=5"><img src="imagens/up.png"></a>
<a href="?ord=6"><img src="imagens/down.png"></a></th>
<th scope="col">Validade <a href="?ord=7"><img src="imagens/up.png"></a>
<a href="?ord=8"><img src="imagens/down.png"></a></th>
<th scope="col">Ações</th>
</tr></thead><tbody><tr>
<!-- Fim do inicio da tabela -->
<!---------------------------------------------------------------------------->
<!-- Switch para definir a filtragem -->
<?php 
$ord = anti_hacker($_GET["ord"]);
switch( $ord ) {
default:
$complemento.= " ORDER BY id";
break; case "1":
$complemento.= " ORDER BY nome ASC";
break; case "2":
$complemento.= " ORDER BY nome DESC";
break; case "3":
$complemento.= " ORDER BY lote ASC";
break; case "4":
$complemento.= " ORDER BY lote DESC";
break; case "5":
$complemento.= " ORDER BY quantidade ASC";
break; case "6":
$complemento.= " ORDER BY quantidade DESC";
break; case "7":
$complemento.= " ORDER BY validade ASC";
break; case "8":
$complemento.= " ORDER BY validade DESC";
break;
}
#----------------------------------------------------------------------------

//Selecionando a tabela medicamentos
$sql = executa("SELECT * FROM medicamentos $complemento");

//Criando um while
while($exc = mysqli_fetch_assoc($sql)){

//Criando as variaveis com seus devidos campos
$i = $exc['id']; 
$m = $exc['nome']; 
$l = $exc['lote']; 
$q = $exc['quantidade']; 
$v = $exc['validade']; 

//Criando uma variavel para saber data atual e do DB
$timestampDB  = $v;
$timestamp    = date('Y-m-d');

//Convertendo as datas
$date =  new DateTime( $timestamp );
$date1 = new DateTime( $timestampDB );
$date2 = new DateTime( $timestamp );

//calculando a diferenca entre as duas datas
$diff = $date1->diff($date2);
?>
<!---------------------------------------------------------------------------->
<!-- Continuando a tabela criada no começo -->
<th scope="row" class="table-light">
<?php echo $i; ?></th>

<!-- Aqui mostra os medicamentos do banco de dados -->
<td class="table-light">
<img src="imagens/medicamento.png" width="24" height="24"> 
<?php echo strtoupper($m); ?></td>

<!-- Aqui mostra os lotes dos medicamentos -->
<td class="table-light">
<span style="color: orange">
<i class="fa fa-cogs" aria-hidden="true"></i></span>
<?php echo $l; ?></td>

<!-- Aqui mostra a quantidade de cada medicamentos -->
<td class="table-light">
<?php if($q < 10){ ?>
<span style="color: red">
<i class="fa fa-arrow-down" aria-hidden="true"></i></span>  <?php } ?>
<?php if($q >= 10){ ?>
<span style="color: blue">
<i class="fa fa-arrow-up" aria-hidden="true"></i></span>  <?php } ?>
<?php echo $q; ?></td>

<!-- Aqui mostra se algum medicamento já se venceu -->
<td class="table-light">
<?php if( $date->format( 'Y-m-d' ) > $timestampDB ){ ?>
<span style="color: orange">
<i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> <b><?php 
echo date('d/m/Y', strtotime($v)); ?></b> <?php echo '( Se venceu há <span style="color: red;">'. $diff->days .'</span> dias ! )'; ?>  

<!-- Aqui mostra se algum medicamento está se vecendo hoje -->
<?php }elseif( $date->format( 'Y-m-d' ) == $timestampDB ){ ?> 
<span style="color: orange">
<i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> <b><?php 
echo date('d/m/Y', strtotime($v)); ?></b> ( Se vence <span style="color: red;">hoje</span> ! )

<!-- Aqui mostra quando algum medicamento vai se vencer em até 60 dias -->
<?php }else{ ?>
<span style="color: green">
<i class="fa fa-check" aria-hidden="true"></i></span><b>
<?php echo date('d/m/Y', strtotime($v)); ?></b> 
<?php if($diff->days <= 60){ ?>
<?php echo '( Se vence em <i style="color: red">'. $diff->days .'</i> dias ! )'; ?> 
<?php }} //Fim do if e do else ?> 

</td> <!-- Aqui é o fechamento do TD de validade -->

<!-- Aqui é os botões de Editar e Excluir -->
<td class="table-light">
<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalexcluir<?php echo $i; ?>">Excluir</button>
<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditar<?php echo $i; ?>">Editar</button>
</td></tr><!-- Aqui é o fechamento do TD dos botoes e da TR -->


<!---------------------------------------------------------------------------->
<!-- Modal de exluir item -->
<div class="modal fade" id="modalexcluir<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Alerta</h4> <!-- Aqui é o titulo do modal -->
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">

<!-- Formulario para enviar o ID -->
<form action="apagar.php" method="POST">
<input type="hidden" name="idmedicamento" value="<?php echo $i; ?>">

<!-- Conteudo do modal -->
<p>Tem certeza que deseja excluir este item ?</p> 
</div>

<!-- Rodape do modal -->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<input type="submit" class="btn btn-primary" value="Continuar"></form>
</div></div></div></div>

<!-- Fim do modal -->
<!---------------------------------------------------------------------------->
<!-- Modal para editar item -->
 <div class="modal fade" id="modaleditar<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Editando item</h4> <!-- Aqui é o titulo do modal -->
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">

<!-- Formulario para editar o medicamento -->
<form action="editar.php" method="POST">
<input type="hidden" name="idmedicamento" value="<?php echo $i; ?>">
<div class="form-row">

<!-- Input do medicamento -->
<div class="form-group col-md-6">
<label for="medicamento">Medicamento</label>
<input type="text" class="form-control" name="medicamento" value="<?php echo $m; ?>" required autofocus>
</div>

<!-- Input do lote -->
<div class="form-group col-md-6">
<label for="lote">Lote</label>
<input type="text" value="<?php echo $l; ?>" class="form-control" name="lote" placeholder="Numero do Lote">
</div>

<!-- Input da quantidade -->
<div class="form-group col-md-6">
<label for="quantidade">Quantidade</label>
<input type="text" value="<?php echo $q; ?>" class="form-control" name="quantidade" placeholder="Quantidade">
</div>

<!-- Input da validade -->
<div class="form-group col-md-6">
<label for="inputAddress2">Validade</label>
<input type="date" value="<?php echo $v; ?>" class="form-control" name="validade" placeholder="Data de Validade" required>
</div></div></div>

<!-- Rodape do modal -->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<input type="submit" class="btn btn-primary" value="Continuar"></form>
</div></div></div></div>

<!-- Fim do modal -->
<!---------------------------------------------------------------------------->

<?php } //Fechamento do while ?>

</tbody></table> <!-- Fim da tabela -->


<!---------------------------------------------------------------------------->
<!-- Javascript para funcionar o modal -->
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body></html>