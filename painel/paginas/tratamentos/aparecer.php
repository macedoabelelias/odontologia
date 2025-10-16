<?php 

$tabela = 'tratamentos';

require_once("../../../conexao.php");



$vezes = $_POST['vezes'];





echo '
<div class="row">
<div class="col-md-2">
<label>Segunda</label>
								</div>

								<div class="col-md-2">
<label>Terça</label>
								</div>

								<div class="col-md-2">
<label>Quarta</label>
								</div>

								<div class="col-md-2">
<label>Quinta</label>
								</div>

								<div class="col-md-2">
<label>Sexta</label>
								</div>
								<div class="col-md-2">
<label>Sabado</label>
								</div>
								</div>
								<div class="row">

<div class="col-md-2">
	<input type="time" class="form-control " name="hora1"  id="hora1" >

								</div>
								
<div class="col-md-2">
	<input type="time" class="form-control " name="hora2"  id="hora2"  >

								</div>

								<div class="col-md-2">
	<input type="time" class="form-control " name="hora3"  id="hora3" >

								</div>
								<div class="col-md-2">
	<input type="time" class="form-control " name="hora4"  id="hora4" >

								</div>
								<div class="col-md-2">
	<input type="time" class="form-control " name="hora5"  id="hora5" >

								</div>
								<div class="col-md-2">
	<input type="time" class="form-control " name="hora6"  id="hora6" >

								</div>
								</div>
							';
	


?>