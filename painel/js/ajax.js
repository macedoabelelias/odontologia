$(document).ready(function() { 
    $('#btn_carregando').hide();
    $('#listar').text("Carregando Dados...");   
    listar();    
} );

function listar(p1, p2, p3, p4, p5, p6){
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {p1, p2, p3, p4, p5, p6},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}

function inserir(){    
    $('#mensagem').text('');
    $('#titulo_inserir').text('Inserir Registro');
    $('#modalForm').modal('show');
    limparCampos();
}





$("#form").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem').text('Salvando...')
    $('#btn_salvar').hide();
    $('#btn_carregando').show();

    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar').click();
                sucesso();
                listar();

                $('#mensagem').text('')          

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }

            $('#btn_salvar').show();
            $('#btn_carregando').hide();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




function excluir(id){
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




function excluirMultiplos(id){   
    //$('#mensagem-excluir').text('Excluindo...')
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {                
                //listar();
                limparCampos()
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}



function ativar(id, acao){  
    $.ajax({
        url: 'paginas/' + pag + "/mudar-status.php",
        method: 'POST',
        data: {id, acao},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Alterado com Sucesso") {
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}


function mascara_moeda(valor) {

    var valorAlterado = $('#'+valor).val();
    valorAlterado = valorAlterado.replace(/\D/g, ""); // Remove todos os não dígitos
    valorAlterado = valorAlterado.replace(/(\d+)(\d{2})$/, "$1,$2"); // Adiciona a parte de centavos
    valorAlterado = valorAlterado.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // Adiciona pontos a cada três dígitos
    valorAlterado = valorAlterado;
    $('#'+valor).val(valorAlterado);
}





    
    
