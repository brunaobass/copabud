<section class="criar">
    <button id="btn-addparticipante" class="btn btn-enviar">Adicionar Participante</button>
    <?php
        if(isset($_SESSION['erro']) && !empty($_SESSION['erro'])){
            echo '<p class="erro">'.$_SESSION['erro'].'</p>';
            unset($_SESSION['erro']);
        }
    ?>
    <form method="POST" action="<?=BASE_URL?>edicao/gerar_tabela">
        <fieldset class="area_edicao">
            <label for="edicao">Edição</label>
            <input type="text" name="edicao">
            
        </fieldset>
        <fieldset class="area_edicao">
            <label for="classificados">Número de classificados para a próxima fase</label>
            <input type="text" name="classificados" pattern="[0-9]+$" required title="Digite somente valores numéricos">
            
        </fieldset>
        <fieldset class="area_participantes"></fieldset>
        <button class="btn btn-enviar">Criar</button>
    </form>
    
</section>
<div class="modal-time">
    <div class="conteudo-modal">
        <form id="form-time" class="form-cadastro" enctype="multipart/form-data">
            <h3>Nova Equipe</h3>
            <figure id="preview">
                <img src="<?=BASE_URL?>assets/images/photo.png" id="img_preview" alt="Prévia da imagem do usuário">
                <figcaption><a href="javascript:;" id="btn_trocar_imagem">Trocar imagem</a></figcaption>
                <input type="file" name="arquivo" id="imagem_usuario" onchange="trocarImagem()">
            </figure>
            <fieldset>
                <label>Nome:</label>
                <input type="text" name="nome" id="nome-time">

                <label>Sigla:</label>
                <input type="text" name="sigla" id="sigla">

                <button id="btn-inserir" class="btn">Inserir</button>
                <button id="btn-cancelar" class="btn">Cancelar</button>
            </fieldset>
        </form>
    </div>
</div>