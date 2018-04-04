<section class="classificacao-jogos">
        <h2>Classificação e Resultados</h2>
        <ul class="classificacao"> 
            <li class="cabecalho cabecalho-classificacao">
                <div class="nome-time float-left">Equipe</div>
                <div class="pontos smallbox float-left">P</div>
                <div class="jogos-classificacao smallbox float-left">J</div>
                <div class="vitorias smallbox float-left">V</div>
                <div class="empates smallbox float-left">E</div>
                <div class="derrotas smallbox float-left">D</div>
                <div class="saldo-gols smallbox float-left">SG</div>
                <div class="gols-pro smallbox float-left">GP</div>
                <div class="gols-contra smallbox float-left">GC</div>
                <div class="clear"></div>
            </li>
           
            <?php
                for ($i = 0; $i < count($classificacao);$i++) :
            ?>
            <li class="item-classificacao">
                <div class="posicao smallbox float-left"><?=($i+1)?></div>
                <div class="escudo smallbox float-left"><img src="<?=BASE_URL?>assets/images/<?=$classificacao[$i]['imagem']?>"></div>
                <div class="nome-time float-left"><?=$classificacao[$i]['equipe']?></div>
                <div class="pontos smallbox float-left"><?=$classificacao[$i]['pontos']?></div>
                <div class="jogos-classificacao smallbox float-left"><?=$classificacao[$i]['jogos']?></div>
                <div class="vitorias smallbox float-left"><?=$classificacao[$i]['vitorias']?></div>
                <div class="empates smallbox float-left"><?=$classificacao[$i]['empates']?></div>
                <div class="derrotas smallbox float-left"><?=$classificacao[$i]['derrotas']?></div>
                <div class="saldo-gols smallbox float-left"><?=$classificacao[$i]['saldo_gols']?></div>
                <div class="gols-pro smallbox float-left"><?=$classificacao[$i]['gols_pro']?></div>
                <div class="gols-contra smallbox float-left"><?=$classificacao[$i]['gols_contra']?></div>
                <div class="clear"></div>
            </li>
            <?php
                endfor;
            ?>    
        </ul>
        <article class="jogos">
            <h3 class="cabecalho cabecalho-jogos">Jogos</h3>
            <?php
                for($i=0;$i<$num_rodadas;$i++):
            ?>
            <div class="rodada">
                <h3 class="cabecalho cabecalho-jogos"><?=($i+1)?>ª Rodada
                    <!--<button class="prev"><i class="fa fa-chevron-left"></i></button>
                    <button class="next"><i class="fa fa-chevron-right"></i></button>-->
                </h3>

                <?php   
                    $inicio = ($i*$num_partidas_rodada);
                    $fim = ($i*$num_partidas_rodada)+$num_partidas_rodada;
                    for ($j=$inicio;$j< $fim ; $j++):
                ?>
                <div class="partida">
                    <p class="data-jogo">10/10/2020 | 15:00</p>
                    <figure class="mandante float-left">
                        <figcaption class="float-right"><?=$partidas[$j]['mandante']['sigla']?></figcaption>
                        <img class="float-right" src="<?=BASE_URL?>assets/images/<?=$partidas[$j]['mandante']['imagem']?>">    
                    </figure>
                    <div class="resultado float-left">
                        <input type="hidden" class="id_partida" value="<?=$partidas[$j]['id']?>">
                        <div>
                            <span class="gols-span float-left">-</span>
                            <input type="text"class="gols-input float-left">
                            <input type="hidden" class="id_mandante" value="8">
                        </div>
                        
                        <span class="float-left">X</span>
                        
                        <div>
                            <span class="gols-span float-right" >-</span>
                            <input type="text"class="gols-input float-right">
                            <input type="hidden" class="id_visitante" value="5">
                        </div>
                        
                        
                    </div>
                    
                    <figure class="visitante float-right">
                        <figcaption class="float-left"><?=$partidas[$j]['visitante']['sigla']?></figcaption>
                        <img class="float-left" src="<?=BASE_URL?>assets/images/<?=$partidas[$j]['visitante']['imagem']?>"> 
                    </figure>
                    <div class="clear"></div>
                    <div class="partida-rodape"></div>
                </div>
                <?php
                    endfor;
                ?>
            </div>
            <?php
                endfor;
            ?>
        </article>
    </section>
