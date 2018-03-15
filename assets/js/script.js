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
           $(area_participantes).append('<select name="participante"></select>');
           for(var i in json){
               $(area_participantes).find('select').append('<option value="'+json[i].id+'">'+json[i].nome+'</option>');
               console.log("Participante:"+json[i].nome);
           }
       },
       error:function(){
           console.log("DEU RUIM");
       }
    });
}