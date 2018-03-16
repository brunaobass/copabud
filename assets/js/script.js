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
    $("#btn-addparticipante").on('click',inserirParticipante);
});

function trocarImagem(){
    
    if(typeof(FileReader) !="undefined"){
        var imagem_preview = $("#img_preview");
        var reader = new FileReader();

        reader.onload = function(e){
            imagem_preview.attr("src",e.target.result);
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
           $(area_participantes).append('<select name="participante[]" class="participante"></select>');
           for(var i in json){
               $(area_participantes).find('.participante').append('<option value="'+json[i].id+'">'+json[i].nome+'</option>');
               console.log("Participante:"+json[i].nome);
               console.log("Indice:"+i);
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
           console.log("SAI DO CAIXÃO TANCREDO");
           
           $(area_participantes).append('<select name="time[]" class="time"></select>');
           var last_id;
           for(var i in json){
               $(area_participantes).find('.time').append('<option value="'+json[i].id+'">'+json[i].nome+'</option>');
               console.log("Times:"+json[i].nome);
               
           }
           last_id = 0;
           $(area_participantes).find('#time').append('<option value="'+last_id+'">...Nova Equipe</option>');
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