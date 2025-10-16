<?php 
require_once("verificar.php");
$pag = 'orcamentos';

if(@$orcamentos == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

?>

<div class="justify-content-between">
	<form action="rel/lista_orcamentos_class.php" target="_blank" method="POST">
 	<div class="left-content mt-2 mb-3">
 <a style="margin-bottom: 10px; margin-top: 5px" class="btn ripple btn-primary text-white <?php echo $inserir_orcamentos ?>" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i>Orçamento</a>


 <div style="display: inline-block; position:absolute; right:10px; margin-bottom: 10px">
			<button style="width:120px" type="submit" class="btn btn-danger ocultar_mobile_app" title="Gerar Relatório"><i class="fa fa-file-pdf-o"></i> Relatório</button>
		</div>

		<div class="dropdown" style="display: inline-block;">                      
                        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>



             

         <div class="cab_mobile"></div>               

         <div style="display: inline-block; margin-bottom: 10px">
			<input type="date" name="dataInicial" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo $data_inicio_mes ?>" onchange="buscar()">

			<input type="date" name="dataFinal" id="dataFinal" style="height:35px; width:49%; font-size: 13px" value="<?php echo $data_final_mes ?>" onchange="buscar()">	
		</div>	
		


		</div>	
		
		
		<input type="hidden" name="tipo_data" id="tipo_data">
		<input type="hidden" name="pago" id="pago">	

		<input type="hidden" id="id_produto_input">	
		<input type="hidden"  id="nome_input">		

		<input type="hidden"  id="tipo_busca" name="tipo_busca">
		
		</form>
		
	</div>	



<div class="row row-sm">
<div class="col-lg-12">
<div class="card custom-card">


<div class="card-body" id="listar">

</div>
</div>
</div>
</div>



<input type="hidden" id="ids">

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				 <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form_orc">
			<div class="modal-body">


					<div class="row">				

						<div class="col-md-9">							
							<label>Paciente</label>
							<div id="listar_clientes">

							</div>							
						</div>
						<div class="col-md-1" style="margin-top: 27px; padding:0">
							<button onclick="$('#btn-fechar').click();" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente" > <i class="fa fa-plus"></i> </button>	
						</div>
					


						<div class="col-md-2 mb-2 col-6">							
							<label>Dias Validade</label>
							<input type="number" name="dias_validade" id="dias_validade" value="" class="form-control">							
						</div>


						
						
					</div>



					<div class="row">				

						<div class="col-md-4 col-5">							
							<label>Procedimentos</label>
							<select name="produto" id="produto" class="sel2" style="width:100%" onchange="listarProdutos()">
								<?php 
								$query = $pdo->query("SELECT * from procedimentos where ativo = 'Sim' order by nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
										echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
									}
								}else{
									echo '<option value="0">Cadastre uma Procedimento</option>';
								}
								?>	
							</select>								
						</div>


						<div class="col-md-7 mb-2 col-12">							
							<label>Descrição se Houver</label>
							<input placeholder="Descrição para o procedimento" type="text" name="descricao" id="descricao" value="" class="form-control">							
						</div>


						

						<div class="col-md-1" style="margin-top: 27px; padding:0">
							<button onclick="addItens()" type="button" class="btn btn-success"  > <i class="fa fa-check"></i> </button>	
						</div>

					</div>


					<div class="row" id="listar_itens">	

					</div>


					


					<div class="row">

						<div class="col-md-2 ">						
											<label>Desc <a id="desc_reais" class="desconto_link_ativo" href="#" onclick="tipoDesc('reais')">R$</a> / <a id="desc_p" class="desconto_link_inativo" href="#" onclick="tipoDesc('%')">%</a></label>
											<input style="margin-top: -5px" type="number" class="form-control" id="desconto" name="desconto" placeholder="Desconto" onkeyup="listarItens()">						
										</div>
						
						

						<div class="col-md-2 col-6">							
							<label>Forma Pgto</label>
							<select name="forma_pgto" id="forma_pgto" class="form-select">
								<?php 
								$query = $pdo->query("SELECT * from formas_pgto order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
										echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
									}
								}else{
									echo '<option value="0">Cadastre uma Forma de Pagamento</option>';
								}
								?>	
							</select>								
						</div>


						<div class="col-md-4 col-5" id="div_usuario">							
							<label>Profissional</label>
							<select name="usuario" id="usuario" class="sel5" style="width:100%">
								<?php 
								$query = $pdo->query("SELECT * from usuarios where ativo = 'Sim' order by nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
										$id_user = $res[$i]['id'];
										$classe_user = '';
										if($id_user == $id_usuario){
											$classe_user = 'selected';
										}
										echo '<option value="'.$res[$i]['id'].'" '.$classe_user.'>'.$res[$i]['nome'].'</option>';
									}
								}else{
									echo '<option value="0">Cadastre uma Profissional</option>';
								}
								?>	
							</select>								
						</div>		




						<div class="col-md-4 col-5" id="">							
							<label>Odontograma</label>
							<div id="listar_odontogramas">
								
							</div>
														
						</div>					
						
						
					</div>


					<div class="row">
						<div class="col-md-10 mb-2">							
							<label>Observações</label>
							<input type="text" class="form-control" id="obs" name="obs" placeholder="Observações" >							
						</div>

						<div class="col-md-2 mb-2" style="margin-top: 27px">	
							<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>
						</div>

					</div>

										


					<input type="hidden" class="form-control" id="id" name="id">	
					<input type="hidden" name="tipo_desconto" id="tipo_desconto" value="reais">
					<input type="hidden" name="subtotal_venda" id="subtotal_venda">				

					<br>
					<small><div id="mensagem" align="center"></div></small>
				</div>
				
			</form>
		</div>
	</div>
</div>










	<!-- Modal Arquivos -->
	<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>
					 <button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form-arquivos" method="post">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-8">						
								<div class="form-group"> 
									<label>Arquivo</label> 
									<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
								</div>	
							</div>
							<div class="col-md-4">	
								<div id="divImgArquivos">
									<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
								</div>					
							</div>




						</div>

						<div class="row" >
							<div class="col-md-8">
								<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
							</div>

							<div class="col-md-4">										 
								<button type="submit" class="btn btn-primary">Inserir</button>
							</div>
						</div>

						<hr>

						<small><div id="listar-arquivos"></div></small>

						<br>
						<small><div align="center" id="mensagem-arquivo"></div></small>

						<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">


					</div>
				</form>
			</div>
		</div>
	</div>







<!-- Modal Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content" style="overflow: scroll; max-height:600px; scrollbar-width: thin;">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel">Adicionar Cliente</h4>
				<button id="btn-fechar-cliente" aria-label="Close" class="btn-close" data-bs-toggle="modal" data-bs-target="#modalForm" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form-cliente">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6 mb-2 col-6 needs-validation was-validated">
							<label>Nome <span class="text-danger" style="font-size: 9px">(Obrigatório)</span></label>
							<div class="form-group has-success mg-b-0">
								<input class="form-control" id="nome" name="nome" placeholder="Digite o Nome" required type="text"
									value="">
							</div>
						</div>

						<div class="col-md-3 col-6">
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o Telefone">
						</div>

						<div class="col-md-3 mb-2">
							<label>Nascimento</label>
							<input type="date" class="form-control" id="data_nasc" name="data_nasc" placeholder="">
						</div>


					</div>



					<div class="row">

						<div class="col-md-3 mb-2 col-6">
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
								<option value="Física">Física</option>
								<option value="Jurídica">Jurídica</option>
							</select>
						</div>

						<div class="col-md-3 mb-2 col-6">
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF">
						</div>

						<div class="col-md-1 col-1" style="margin-top: 28px; margin-left: -10px">
							<a title="Buscar CNPJ" class="btn btn-primary" href="#" onclick="buscarCNPJ()" class="btn btn-primary"> <i
									class="bi bi-search"></i> </a>
						</div>



						<div class="col-md-5">
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Digite o Email">
						</div>


					</div>

					<div class="row">

						<div class="col-md-2 mb-2">
							<label>CEP</label>
							<input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP"
								onblur="pesquisacep(this.value);">
						</div>



						<div class="col-md-5 mb-2">
							<label>Rua</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Ex. Rua Central">
						</div>

						<div class="col-md-2 mb-2">
							<label>Número</label>
							<input type="text" class="form-control" id="numero" name="numero" placeholder="1500">
						</div>

						<div class="col-md-3 mb-2">
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Bloco B AP 104">
						</div>


					</div>


					<div class="row">

						<div class="col-md-4 mb-2">
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
						</div>

						<div class="col-md-5 mb-2">
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade">
						</div>

						<div class="col-md-3 mb-2">
							<label>Estado</label>
							<select class="form-select" id="estado" name="estado">
								<option value="">Selecionar</option>
								<option value="AC">Acre</option>
								<option value="AL">Alagoas</option>
								<option value="AP">Amapá</option>
								<option value="AM">Amazonas</option>
								<option value="BA">Bahia</option>
								<option value="CE">Ceará</option>
								<option value="DF">Distrito Federal</option>
								<option value="ES">Espírito Santo</option>
								<option value="GO">Goiás</option>
								<option value="MA">Maranhão</option>
								<option value="MT">Mato Grosso</option>
								<option value="MS">Mato Grosso do Sul</option>
								<option value="MG">Minas Gerais</option>
								<option value="PA">Pará</option>
								<option value="PB">Paraíba</option>
								<option value="PR">Paraná</option>
								<option value="PE">Pernambuco</option>
								<option value="PI">Piauí</option>
								<option value="RJ">Rio de Janeiro</option>
								<option value="RN">Rio Grande do Norte</option>
								<option value="RS">Rio Grande do Sul</option>
								<option value="RO">Rondônia</option>
								<option value="RR">Roraima</option>
								<option value="SC">Santa Catarina</option>
								<option value="SP">São Paulo</option>
								<option value="SE">Sergipe</option>
								<option value="TO">Tocantins</option>
								<option value="EX">Estrangeiro</option>
							</select>
						</div>


					</div>


					<div class="row">
						<div class="col-md-3 mb-2">
							<label>Tipo Sanguíneo</label>
							<input type="text" class="form-control" id="tipo_sanguineo" name="tipo_sanguineo" placeholder="Tipo Sanguineo">
						</div>

						<div class="col-md-2 mb-2">
							<label>Sexo</label>
							<select class="form-select" id="sexo" name="sexo">
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>								
							</select>
						</div>

						<div class="col-md-4 mb-2">
							<label>Profissão</label>
							<input type="text" class="form-control" id="profissao" name="profissao" placeholder="Tipo Sanguineo">
						</div>

						<div class="col-md-3 mb-2">
							<label>Estado Civil</label>
							<select class="form-select" id="estado_civil" name="estado_civil">
								<option value="Solteiro(a)">Solteiro(a)</option>
								<option value="Casado(a)">Casado(a)</option>		
								<option value="Divorciado(a)">Divorciado(a)</option>		
								<option value="Viúvo(a)">Viúvo(a)</option>								
							</select>
						</div>
					</div>


					<div class="row">
						<div class="col-md-2 mb-2">
							<label>Convênio</label>
							<select class="form-select" name="convenio" id="convenio">
									<option value="0">Nenhum</option>
									<?php 
									$query = $pdo->query("SELECT * from convenios order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
										for($i=0; $i<$linhas; $i++){
											?>
											<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
										<?php } } ?>
									</select>	
						</div>

							<div class="col-md-4 mb-2">
							<label>Responsável</label>
							<input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Se Houver preencha">
						</div>


						<div class="col-md-3 mb-2">
							<label>CPF Responsável</label>
							<input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel" placeholder="CPF Resposnável">
						</div>

						<div class="col-md-3 mb-2">
							<label>Telefone 2</label>
							<input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="Outro Telefone">
						</div>
					</div>



					<div class="row">						
						<div class="col-md-12 mb-2">
							<label>Observações</label>
							<input type="text" class="form-control" id="obs" name="obs" placeholder="Observações">
						</div>
					</div>


			


					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem_cliente" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" id="btn_salvar_cliente" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>




<!-- Modal Quantidade -->
<div class="modal fade" id="modalQuantidade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel">Quantidade: <span id="nome_do_prod"></span></h4>
				<button id="btn-fechar-quant" aria-label="Close" class="btn-close" data-bs-toggle="modal" data-bs-target="#modalForm" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			
			<div class="modal-body">
				
				<div class="row">
						<div class="col-md-8 mb-2">							
								<label>Quantidade em <span id="uni_do_prod"></span></label>
								<input type="text" class="form-control" id="quantidade_prod" placeholder="0.5" onkeyup="mascara_decimal('quantidade_prod')">							
						</div>

						<div class="col-md-4" style="margin-top: 22px">							
								<a onclick="addItens('quant')" href="#"  class="btn btn-primary">Adicionar</a>					
						</div>

						<input type="hidden" id="id_do_p">

						
					</div>

			
			</div>		
			
		</div>
	</div>
</div>



<div style="display:none">
	<form action="rel/orcamento_class.php" method="POST" target="_blank">
		<input type="hidden" name="id" id="id_relatorio">
		<button type="submit" id="btn_relatorio"></button>
	</form>
</div>



	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>


	<script type="text/javascript">
		$(document).ready(function() {

			listarItens();
			listarOdontogramas();
			
			$('.sel2').select2({
				dropdownParent: $('#modalForm')
			});

			$('.sel5').select2({
				dropdownParent: $('#div_usuario')
			});



			$(document).on('select2:open', () => {
					document.querySelector('.select2-search__field').focus();
				});

			listarClientes();
			listarProdutos();
			
		});
	</script>




	




	<script type="text/javascript">
		function buscar(){
			var tipo = $('#tipo_busca').val();					
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();			
			listar(dataInicial, dataFinal, tipo)

		}	

	</script>


	<script type="text/javascript">
			$("#form-baixar").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/' + pag + "/baixar.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-baixar').text('');
						$('#mensagem-baixar').removeClass()
						if (mensagem.trim() == "Baixado com Sucesso") {                    
							$('#btn-fechar-baixar').click();
							buscar();
						} else {
							$('#mensagem-baixar').addClass('text-danger')
							$('#mensagem-baixar').text(mensagem)
						}

					},

					cache: false,
					contentType: false,
					processData: false,

				});

			});
		</script>






<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/' + pag + "/arquivos.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});
		</script>

		<script type="text/javascript">
			function listarArquivos(){
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-arquivos.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}

		</script>




<script type="text/javascript">
		function carregarImgArquivos() {
			var target = document.getElementById('target-arquivos');
			var file = document.querySelector("#arquivo_conta").files[0];

			var arquivo = file['name'];
			resultado = arquivo.split(".", 2);

			if(resultado[1] === 'pdf'){
				$('#target-arquivos').attr('src', "images/pdf.png");
				return;
			}

			if(resultado[1] === 'rar' || resultado[1] === 'zip'){
				$('#target-arquivos').attr('src', "images/rar.png");
				return;
			}

			if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
				$('#target-arquivos').attr('src', "images/word.png");
				return;
			}


			if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
				$('#target-arquivos').attr('src', "images/excel.png");
				return;
			}


			if(resultado[1] === 'xml'){
				$('#target-arquivos').attr('src', "images/xml.png");
				return;
			}



			var reader = new FileReader();

			reader.onloadend = function () {
				target.src = reader.result;
			};

			if (file) {
				reader.readAsDataURL(file);

			} else {
				target.src = "";
			}
		}
	</script>




		<script type="text/javascript">
	$("#form-cliente").submit(function () { 

    $('#mensagem_cliente').text('Salvando!!');
    $('#btn_salvar_cliente').hide();

    event.preventDefault();
    var formData = new FormData(this);
    var nova_pag = 'clientes';

    $.ajax({
        url: 'paginas/' + nova_pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem_cliente').text('');
            $('#mensagem_cliente').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-cliente').click();
                listar();
                listarClientes('1'); 


            } else {

                $('#mensagem_cliente').addClass('text-danger')
                $('#mensagem_cliente').text(mensagem)
            }

             $('#btn_salvar_cliente').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


	function listarClientes(valor){
	$.ajax({
        url: 'paginas/' + pag + "/listar_clientes.php",
        method: 'POST',
        data: {valor},
        dataType: "html",

        success:function(result){
            $("#listar_clientes").html(result);           
        }
    });
}



function listarProdutos(){
	var categoria = $("#categoria").val();
	$.ajax({
        url: 'paginas/' + pag + "/listar_produtos.php",
        method: 'POST',
        data: {categoria},
        dataType: "html",

        success:function(result){
            $("#listar_produtos").html(result);           
        }
    });
}

</script>






<script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>



<script type="text/javascript">
	function addItens(quant){

		var id_produto = $('#produto').val();		
		var produto = $('#nome_input').val();
		var descricao = $('#descricao').val();
		
		var id =  $('#id').val();				
				
				$('#nome_do_prod').text(produto);	
								
				$.ajax({
					url: 'paginas/' + pag + "/inserir_item.php",
					method: 'POST',
					data: {id_produto, id, descricao},
					dataType: "html",

					success:function(mensagem){

						if (mensagem.trim() == "Inserido com Sucesso") {  
							$('#descricao').val('');
							listarItens();							
						}else{
							alert(mensagem)
						}
					}
				});


				
			}



				function listarItens(){
				var id = $("#id").val();
				var desconto = $("#desconto").val();
			
				
				var tipo_desconto = $("#tipo_desconto").val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar_itens.php",
					method: 'POST',
					data: {desconto, tipo_desconto, id},
					dataType: "html",

					success:function(result){
						$("#listar_itens").html(result);            
					}
				});
				
			}



			function tipoDesc(p){
	$('#desc_reais').removeClass()
	$('#desc_p').removeClass()

	if(p == '%'){
		$('#desconto').attr('placeholder', '%');
		$('#desc_reais').addClass('desconto_link_inativo')
		$('#desc_p').addClass('desconto_link_ativo')
	}else{
		$('#desconto').attr('placeholder', 'R$');
		$('#desc_reais').addClass('desconto_link_ativo')
		$('#desc_p').addClass('desconto_link_inativo')
	}

	 $("#tipo_desconto").val(p);
	 listarItens();  
}
</script>




<script type="text/javascript">	

			$("#form_orc").submit(function () {	

				event.preventDefault();				
				var formData = new FormData(this);


				$('#mensagem').text('Salvando...')
   				 $('#btn_salvar').hide();

				$.ajax({
					url: 'paginas/' + pag + "/salvar.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {  

						var msg = mensagem.split("-");        	
						
						$('#mensagem').text('');
						$('#mensagem').removeClass()
						if (msg[0].trim() == "Salvo com Sucesso") {	
							sucesso();
							buscar(); 
							$("#btn-fechar").click();
							$("#id_relatorio").val(msg[1]);
							$("#btn_relatorio").click();

							
						} else {
							alert(msg[0]);               
							
						}

						 $('#btn_salvar').show();					

					},

					cache: false,
					contentType: false,
					processData: false,

				});

			});
		</script>


<script type="text/javascript">
	
function excluirOrc(id){
    $('#mensagem-excluir').text('Excluindo...')


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
		function(){
			
		  //swal("Excluído(a)!", "Seu arquivo imaginário foi excluído.", "success");


           $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                excluido();              
                listar();
                limparCampos()
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
		});

}
</script>


<script type="text/javascript">
	function listarOdontogramas(){
	var paciente = $("#cliente").val();
	$.ajax({
        url: 'paginas/' + pag + "/listar_odontogramas.php",
        method: 'POST',
        data: {paciente},
        dataType: "html",

        success:function(result){
        	
            $("#listar_odontogramas").html(result);           
        }
    });
}
</script>