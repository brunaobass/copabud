

<div class="partida" id="partida<?=$jogo['id']?>">
    <p class="data-jogo">10/10/2020 | 15:00</p>


    <figure class="mandante float-left">
        <input type="hidden" class="id_playoff" value="<?=$jogo['id_playoffs']?>">
        <?php
            if($jogo['ida_volta'] == 2):
        ?>
        <div class="penalti confronto<?=$jogo['id_playoffs']?>">
            <span class="float-left">Penaltis</span>
            <span class="penalti-span float-left" id="penalti_mandante<?=$jogo['id']?>">-</span>
            <input type="text" class="gols-input float-left">          
        </div>
        <?php
            endif;
        ?>
        <figcaption class="float-right" id="sigla_mandante<?=$jogo['id']?>">
            MAN
        </figcaption>
        <img class="float-right" src="<?=BASE_URL?>assets/images/clube.png"
             id="imagem_mandante<?=$jogo['id']?>">    
    </figure>
    <div class="resultado float-left">
        <input type="hidden" class="id_partida" value="<?=$jogo['id']?>">
        <input type="hidden" class="partida_jogada" value="<?=$jogo['partida_jogada']?>">
        <input type="hidden" class="fase" value="<?=$jogo['fase']?>">
        <div>
            <span class="gols-span float-left"><?=$gols_mandante?></span>
            <input type="text"class="gols-input float-left">
            <!--<input type="hidden" class="id_mandante" value="">-->
        </div>

        <span class="float-left">X</span>

        <div>
            <span class="gols-span float-right" ><?=$gols_visitante?></span>
            <input type="text"class="gols-input float-right">
            <!--<input type="hidden" class="id_mandante" value="">-->
        </div>


    </div><!--resultado-left-->

    <figure class="visitante float-right">
        <input type="hidden" class="id_playoff" value="<?=$jogo['id_playoffs']?>">
        <figcaption class="float-left" id="sigla_visitante<?=$jogo['id']?>">
            VIS</figcaption>
        <img class="float-left" src="<?=BASE_URL?>assets/images/clube.png"
             id="imagem_visitante<?=$jogo['id']?>">
        <?php
            if($jogo['ida_volta'] == 2):
        ?>
            <div class="penalti confronto<?=$jogo['id_playoffs']?>">
                <span class="penalti-span float-left" id="penalti_visitante<?=$jogo['id']?>">-</span>
                <input type="text" class="gols-input float-left">
            </div>
        <?php
            endif;
        ?>
    </figure>
    <div class="clear"></div>
    <div class="partida-rodape"></div>
</div><!--partida-->
