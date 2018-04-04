var url_imagem;
var id_participante = 1;
var primeiro;

/******************
 *MODAL DE IMAGENS
 *****************/
$(function(){
    $("#btn_trocar_imagem").on('click',function(){
        $("#imagem_usuario").trigger("click");
    });
    $("#btn-menu").on("click",function(){
        $(".menu-navegacao").show();
        $(this).hide();
        $("#btn-fechar").show();
    });
    $("#btn-fechar").on("click",function(){
        $(".menu-navegacao").hide();
        $(this).hide();
        $("#btn-menu").show();
    });
 /******************
 *MODAL DE IMAGENS
 *****************/

/*******************************
 * GERADOR DE TABELAS E PARTIDAS
 ******************************/
    $("#btn-addparticipante").on('click',inserirParticipante);
    
    $(document).on('change',".time",function(){
        var opcao = $(this).val();
        id_selecionado = "#"+$(this).attr('id');
        primeiro = $(id_selecionado).find('option').eq(0);

        $(primeiro).removeAttr("selected");
        if(opcao == 0){
            $(".modal-time").fadeIn('fast'); 
        }
    });
    
    $("#btn-cancelar").on('click',function(e){
            e.preventDefault();
            $(primeiro).attr("selected",'selected');
            $(".modal-time").fadeOut('fast');        
    });
    $("#form-time").on('submit',salvarTime);
/*******************************
 * GERADOR DE TABELAS E PARTIDAS
 ******************************/
 
/*******************************
 * ATUALIZAÇÃO DE RESULTADOS NA PÁGINA CLASSIFICAÇÃO
 ******************************/
    $(".gols-span").on('click',function(){
       var campo = $(this);
       var parent_parent = $(this).parent().parent();
       var id_partida = parent_parent.find('.id_partida').val();
       console.log("ID da partida:"+id_partida);
       var input = $(this).parent().find('input[type=text]');
       
       var gols = $(this).html();
       var gols_mandante;
       var gols_visitante;
       var regra = /^[0-9]+$/;
       $(this).hide();
       
       if(gols.match(regra)){
           input.val(gols);
       }
       else{
           input.val('');
       }
       input.show();
       input.select();
      
       var noBlur = false;
       input.blur(function(){
           if(!noBlur){//evita que o evento blur dispare mais de uma vez sem necessidade
                gols_mandante = parent_parent.find('input[type=text]').eq(0).val();
                gols_visitante = parent_parent.find('input[type=text]').eq(1).val();
                noBlur = true;
                $(this).hide();
                gols = $(this).val();

                if(gols.match(regra)){//verifica se o valor digitado foi um número inteiro
                    campo.html(gols);//caso seja, atualiza o resultado
                }
                else{
                    campo.html('-');//caso contrário não atualiza e insere o hífen para sinalizar que a partida
                    //ainda não possui resultados
                }
                if(gols_mandante.match(regra) && gols_visitante.match(regra)){
                    //verifica se ambos os campos estão preenchidos com resultados numéricos
                    if(verificaPartidaJogada(id_partida)){
                        anularResultado(id_partida,gols_mandante,gols_visitante,parent_parent);
                    }
                    salvarResultado(id_partida,gols_mandante,gols_visitante,parent_parent);
                }
                campo.show(); 
           }
           
       });
       
    });
});

function salvarResultado(gols_mandante,gols_visitante, parent_parent){
    

    var id_mandante = parent_parent.find('.id_mandante').val()
    var id_visitante = parent_parent.find('.id_visitante').val();
    var id_vencedor;
    var id_perdedor;
    
    if(gols_mandante === gols_visitante){
        atualizaEmpate(id_mandante,id_visitante);
    }
    else{
        if(gols_mandante > gols_visitante){
            id_vencedor = id_mandante;
            id_perdedor = id_visitante;
        }
        else{
            id_vencedor = id_mandante;
            id_perdedor = id_visitante;
        }
        atualizaVitoria(id_vencedor,id_perdedor);
    }
}

function atualizaEmpate(id_mandante,id_visitante){
    
}

function atualizaVitoria(){
    
}

function verificaPartidaJogada(id_partida){
    
    var realizada;//condição que verifica se a partida já ocorreu
    $.ajax({
        url:''
    });
}
function salvarTime(e){
    e.preventDefault();
    var dados = new FormData(this);
    console.log(dados);
    $.ajax({
        url:'http://localhost/copabud/edicao/inserir_time',
        type: 'POST',
        data: dados,  
        dataType:'json',
        success:function(json){
            if(typeof(json.erro)!='undefined'){
                alert(json.erro);
                $('.area_participantes').find('.time').first().attr("selected",'selected');
            }
            else{
               $('.novo-time').before('<option value="'+json.id+'">'+json.nome+'('+json.sigla+')</option>'); 
            }
            
            console.log(json);
        },
        cache:false,
        contentType:false,
        processData:false,
        
        xhr:function(){
            var myXhr = $.ajaxSettings.xhr();
            
            if(myXhr.upload){//verifica se há suporte à propriedade upload
                myXhr.upload.addEventListener('progress',function(){
                    //realiza alguma ação durante o processo de upload
                },false);
            }
            
            return myXhr;
        },
        error:function(){
            console.log("Erro ao inserir equipe...");
        }
    });
    $(".modal-time").fadeOut('fast'); 
}
function muda(){
   var opcao = $(this).val();
        alert(opcao);
}
function trocarImagem(){
    
    if(typeof(FileReader) !="undefined"){
        var imagem_preview = $("#img_preview");
        var reader = new FileReader();

        reader.onload = function(e){
            imagem_preview.attr("src",e.target.result);
            url_imagem = e.target.result;
        }
        reader.readAsDataURL($("#imagem_usuario")[0].files[0]);
    }
    else{
        alert("Seu navegador não suporta FileReader!");
    }
}

function inserirParticipante(){
    var area_participantes = $(".area_participantes");
    
    
    $.ajax({
       url:'http://localhost/copabud/edicao/listar_players',
       dataType:'json',
       success:function(json){
           console.log("ENTROU");
            addLabels(area_participantes);
           $(area_participantes).append('<select name="participante[]" class="participante" id="player_'+id_participante+'"></select>');
           for(var i in json){
               $(area_participantes).find('.participante').last().append('<option value="'+json[i].id+'">'
                       +json[i].nome+'</option>');
           }
           
           inserirTime(area_participantes);
           
       },
       error:function(){
           console.log("DEU RUIM");
       }
    });
    $(area_participantes).append('<br><br>');
    
}

function inserirTime(area_participantes){
    $.ajax({
       url:'http://localhost/copabud/edicao/listar_times',
       dataType:'json',
       success:function(json){
           
           $(area_participantes).append('<select name="time[]" class="time" id="player_team_'+id_participante+'"></select>');
           var last_id;
           for(var i in json){
               $(area_participantes).find('.time').last().append('<option value="'+json[i].id+'">'+json[i].nome+
                       ' ('+json[i].sigla+')</option>');    
           }
           last_id = 0;
           $(area_participantes).find('.time').last().append('<option value="'+last_id+'" class="novo-time">...Nova Equipe</option>');
           id_participante++;
       },
       error:function(){
           console.log("DEU RUIM");
       }
    });
}

function addBotoes(area_participantes){
    $(area_participantes).append("<button class='btn-confirmar'>Confirmar</button>");
}
function addLabels(area_participantes){
    $(area_participantes).append('<label>Jogador</label>');
    $(area_participantes).append('<label>Time</label>');
    $(area_participantes).append('<br>');
}