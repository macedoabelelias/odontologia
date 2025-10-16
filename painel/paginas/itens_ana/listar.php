<?php 
$tabela = 'itens_ana';
require_once("../../../conexao.php");
$grupo = @$_POST['p1'];

if($grupo == ""){
	$query = $pdo->query("SELECT * from $tabela order by id desc");
}else{
	$query = $pdo->query("SELECT * from $tabela where grupo = '$grupo' order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-striped table-hover table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th>Descrição</th>	
	<th>Grupo</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$grupo = $res[$i]['grupo'];
	$descricao = $res[$i]['descricao'];
	
$query2 = $pdo->query("SELECT * from grupo_ana where id = '$grupo' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_grupo = $res2[0]['nome'];
}else{
	$nome_grupo = 'Sem Grupo';
}
		
echo <<<HTML
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>

<td>
{$nome}
</td>
<td class="esc">{$descricao}</td>
<td class="esc">{$nome_grupo}</td>
<td>
	<big><a class="btn btn-info-light btn-sm" href="#" onclick="editar('{$id}','{$nome}','{$descricao}','{$grupo}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>
	

	<big><a href="#" class="btn btn-danger-light btn-sm" onclick="excluir('{$id}')" title="Excluir"><i class="fa fa-trash-can text-danger"></i></a></big>

</td>
</tr>
HTML;
}
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?>
<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>
<script type="text/javascript">
	function editar(id, nome, descricao, grupo){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');
    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#descricao').val(descricao);
    	$('#grupo').val(grupo).change();
    	
    
    	$('#modalForm').modal('show');
	}
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#descricao').val('');
    	$('#grupo').val('0').change();
    	$('#pagina').val('Sim').change();
    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}
	function selecionar(id){
		var ids = $('#ids').val();
		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}
		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}
	

	function deletarSel() {
		//$('#mensagem-excluir').text('Excluindo...')


		$('body').removeClass('timer-alert');
		swal({
			title: "Deseja Excluir?",
			text: "Você não conseguirá recuperá-lo novamente!",
			type: "error",
			showCancelButton: true,
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Sim, Excluir!",
			closeOnConfirm: true

		},
			function () {

				//swal("Excluído(a)!", "Seu arquivo imaginário foi excluído.", "success");

				var ids = $('#ids').val();
				var id = ids.split("-");

				for (i = 0; i < id.length - 1; i++) {
					excluirMultiplos(id[i]);
				}

				setTimeout(() => {
                    excluido();
                    listar();
                }, 1000);

				limparCampos();



			});

	}
</script>