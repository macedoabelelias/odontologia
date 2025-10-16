<?php 
$pag = 'itens_ana';
if(@$itens_ana == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}	
 ?>



<div class="breadcrumb-header justify-content-between">
	<div class="left-content mt-2">
		<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-1"></i>
			Adicionar Itens Anamnese</a>




<big><a class="btn btn-danger" href="#" onclick="deletarSel()" title="Excluir" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a></big>	
							
	</div>

		<select class="form-select" name="grupo" id="grupo_busca" onchange="buscar()" style="display:inline-block; width:250px">	
									<option value="">Filtrar Grupo</option>					
								<?php 
									$query = $pdo->query("SELECT * from grupo_ana order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
								 ?>
								  <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
								<?php } } ?>
									
								</select>	


</div>




<li class="dropdown head-dpdn2" style="display: inline-block;">		
		<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>
		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>
<div class="bs-example widget-shadow" style="padding:15px; margin-top: -10px" id="listar">
</div>
<input type="hidden" id="ids">



<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
			<div class="modal-body">
				
					<div class="row">
						<div class="col-md-6">						
								<label>Nome</label>
								<input maxlength="255" type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Ingere bebida álcoolica?" required>	
						</div>
						<div class="col-md-6">						
								<label>Grupo</label>
								<select class="form-select" name="grupo" id="grupo" required>								
								<?php 
									$query = $pdo->query("SELECT * from grupo_ana order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
								 ?>
								  <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
								<?php } } ?>
									
								</select>	
						</div>
					
					</div>
						<div class="row">						
						<div class="col-md-12">						
								<label>Descrição</label>
								<input maxlength="1000" type="text" class="form-control" id="descricao" name="descricao" placeholder="Se houver" >	
						</div>
					
						
					</div>
			
					<input type="hidden" class="form-control" id="id" name="id">					
				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>
<script type="text/javascript">
	function buscar(){
		var grupo = $('#grupo_busca').val();
		listar(grupo)
	}
</script>