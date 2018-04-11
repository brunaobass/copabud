var url_imagem;
var id_participante = 1;
var primeiro;
var realizada;
var id_edicao;
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
    $('#btn-resetar-classificacao').on('click',function(e){
       e.preventDefault();
       resetaPartidas(6);
       resetaClassificacao(6);
       
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
       var campo_clicado = $(this);
       var parent_parent = $(this).parent().parent();
       var id_partida = parent_parent.find('.id_partida').val();
       var partida_jogada = parent_parent.find('.partida_jogada').val();
       id_edicao = $("#id_edicao").val();
       
       console.log("ID da partida:"+id_partida);
       
       var input = $(this).parent().find('input[type=text]');
       
       var gols = $(this).html();
       var gols_mandante = Array();;
       var gols_visitante = Array();
       //PEGANDO OS GOLS A PARTIR DO HTML DO SPAN
       gols_mandante[0] = parent_parent.find('.gols-span').eq(0).html();
       gols_visitante[0]= parent_parent.find('.gols-span').eq(1).html();

       gols_mandante[1] = gols_mandante[0];
       gols_visitante[1] = gols_visitante[0];


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
             
                noBlur = true;
                $(this).hide(); 
                gols = $(this).val();

                if(gols.match(regra)){//verifica se o valor digitado foi um número inteiro
                    campo_clicado.html(gols);//caso seja, atualiza o resultado
                    gols_mandante[1] = parent_parent.find('.gols-span').eq(0).html();
                    gols_visitante[1]= parent_parent.find('.gols-span').eq(1).html();
                }
                else{
                    campo_clicado.html('-');//caso contrário não atualiza e insere o hífen para sinalizar que a partida
                    //ainda não possui resultados
                }
                
                if(gols_mandante[1].match(regra) && gols_visitante[1].match(regra)){
                    //verifica se ambos os campos estão preenchidos com resultados numéricos
                    if(gols_mandante[0].match(regra) && gols_visitante[0].match(regra)){
                        anularResultado(id_partida,gols_mandante[0],gols_visitante[0],parent_parent);
                        console.log("CAMPO CLICADO:"+campo_clicado.html());
                    }
                    
                    if(campo_clicado.html() != '-'){
                        salvarResultado(id_partida,gols_mandante[1],gols_visitante[1],parent_parent);
                    }   
  
                }
                campo_clicado.show(); 
           }   
       });
       
    });
});

function salvarResultado(id_partida,gols_mandante,gols_visitante, parent_parent){
    salvarPartida(id_partida,gols_mandante,gols_visitante);
    console.log("ENTROU EM SALVAR RESULTADO...");
    var id_mandante = parseInt(parent_parent.find('.id_mandante').val()) ;
    var id_visitante = parseInt(parent_parent.find('.id_visitante').val());
    var id_vencedor;
    var id_perdedor;
    var gols_vencedor;
    var gols_perdedor;
    if(gols_mandante === gols_visitante){
        atualizaClassificacao(id_mandante,1,"empate",gols_mandante,gols_visitante,0);
        atualizaClassificacao(id_visitante,1,"empate",gols_visitante,gols_mandante,0);
    }
    else{
        if(gols_mandante > gols_visitante){
            id_vencedor = id_mandante;
            id_perdedor = id_visitante;
            gols_vencedor = gols_mandante;
            gols_perdedor = gols_visitante;
        }
        else{
            id_vencedor = id_visitante;
            id_perdedor = id_mandante;
            gols_vencedor = gols_visitante;
            gols_perdedor = gols_mandante;
        }
        atualizaClassificacao(id_vencedor,3,"vitoria",gols_vencedor,gols_perdedor,0);
        atualizaClassificacao(id_perdedor,0,"derrota",gols_perdedor,gols_vencedor,0);
    }
    //atualizaResultado(id_partida, id_mandante,id_visitante,gols_mandante,gols_visitante);
}
function anularResultado(id_partida,gols_mandante,gols_visitante,parent_parent){
    
    cancelaPartida(id_partida);
    var id_mandante = parseInt(parent_parent.find('.id_mandante').val()) ;
    var id_visitante = parseInt(parent_parent.find('.id_visitante').val());
    var id_vencedor;
    var id_perdedor;
    var gols_vencedor;
    var gols_perdedor;
    if(gols_mandante === gols_visitante){
        atualizaClassificacao(id_mandante,1,"empate",gols_mandante,gols_visitante,1);
        atualizaClassificacao(id_visitante,1,"empate",gols_visitante,gols_mandante,1);
    }
    else{
        if(gols_mandante > gols_visitante){
            id_vencedor = id_mandante;
            id_perdedor = id_visitante;
            gols_vencedor = gols_mandante;
            gols_perdedor = gols_visitante;
        }
        else{
            id_vencedor = id_visitante;
            id_perdedor = id_mandante;
            gols_vencedor = gols_visitante;
            gols_perdedor = gols_mandante;
        }
        atualizaClassificacao(id_vencedor,3,"vitoria",gols_vencedor,gols_perdedor,1);
        atualizaClassificacao(id_perdedor,0,"derrota",gols_perdedor,gols_vencedor,1);
    }
}
function salvarPartida(id_partida,gols_mandante,gols_visitante){
    $.ajax({
        url:'http://localhost/copabud/partida/salva_partida/',
        type:'POST',
        data:{
            id_partida:id_partida,
            gols_mandante:gols_mandante,
            gols_visitante:gols_visitante
        },
        success:function(){
            //console.log("Partida salva com sucesso...");
        },
        error:function(){
            //console.log("Erro ao salvar partida...");
        }
    });
}
function cancelaPartida(id){
    $.ajax({
        url:'http://localhost/copabud/partida/cancela_partida/',
        type:'POST',
        data:{id:id},
        success:function(){
            //console.log("Partida cancelada com sucesso...");
        },
        error:function(){
            //console.log("Erro ao cancelar partida...");
        }
    });
}
function atualizaClassificacao(id_equipe,pontos,tipo_resultado,gols_pro,gols_contra,anula){
    $.ajax({
        url:'http://localhost/copabud/classificacao/atualiza_classificacao/',
        type:'POST',
        data:{
            id_edicao:id_edicao,
            id_equipe:id_equipe,
            pontos:pontos,
            tipo_resultado:tipo_resultado,
            gols_pro:gols_pro,
            gols_contra:gols_contra,
            anula:anula,
        },
        dataType:'json',
        success:function(json){
          var base_url_imagem = 'http://localhost/copabud/assets/images/';
          for(var i in json){
              $('#classif-imagem-'+i).attr('src',(base_url_imagem+json[i].imagem));
              $('#classif-equipe-'+i).html(json[i].equipe);
              $('#classif-pontos-'+i).html(json[i].pontos);
              $('#classif-jogos-'+i).html(json[i].jogos);
              $('#classif-vitorias-'+i).html(json[i].vitorias);
              $('#classif-empates-'+i).html(json[i].empates);
              $('#classif-saldo_gols-'+i).html(json[i].saldo_gols);
              $('#classif-gols_pro-'+i).html(json[i].gols_pro);
              $('#classif-gols_contra-'+i).html(json[i].gols_contra);
              
          }
        },
        error:function(){
           console.log("Classificacao não foi atualizada"); 
        }
 
    });
}

function salvarTime(e){
    e.preventDefault();
    var dados = new FormData(this);
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
       type:'POST',
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

function resetaClassificacao(id_edicao){
    $.ajax({
        url:'http://localhost/copabud/classificacao/resetar',
        type:'POST',
        data:{id_edicao:id_edicao},
        success:function(){
            //location.reload();
            console.log("Resetou a classificação");
        },
        error:function(){
            console.log("Não Resetou a classificação");
        }
    });
}

function resetaPartidas(id_edicao){
    $.ajax({
        url:'http://localhost/copabud/partida/resetar',
        type:'POST',
        data:{id_edicao:id_edicao},
        success:function(){
            location.reload();
            console.log("Resetou as partidas");
        },
        error:function(){
            console.log("Não Resetou as partidas");
        }
    });
}