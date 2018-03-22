
        <div class="modal-time">
        <div class="conteudo-modal">
            <form id="form-time" class="form-cadastro">
                <h3>Nova Equipe</h3>
                <figure id="preview">
                    <img src="<?=BASE_URL?>assets/images/photo.png" id="img_preview" alt="Prévia da imagem do usuário">
                    <figcaption><a href="javascript:;" id="btn_trocar_imagem">Trocar imagem</a></figcaption>
                    <input type="file" name="arquivo" id="imagem_usuario" onchange="trocarImagem()">
                </figure>
                <fieldset>
                    <label>Nome:</label>
                    <input type="text" name="nome">

                    <label>Sigla:</label>
                    <input type="text" name="nome">

                    <button id="btn-inserir" class="btn">Inserir</button>
                    <button id="btn-cancelar" class="btn">Cancelar</button>
                </fieldset>
            </form>
        </div>
        </div>
