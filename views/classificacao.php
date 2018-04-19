<section class="classificacao-jogos">
        <h2>Classificação e Resultados</h2>
        <h3 class="titulo-edicao">Escolha a edição:</h3>
        <!--<button class="btn btn-enviar" id="btn-resetar-classificacao">Resetar</button>-->
        <form method="POST" id="form-edicoes">
            <select name="edicao">
                <?php
                    foreach ($edicoes as $edicao):
                ?>
                    <option value="<?=$edicao['id']?>"><?=$edicao['edicao']?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <button type="submit" class="btn btn-edicao">Enviar</button>
        </form>
        <ul class="classificacao" id="tabela_classificacao"> 
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
                <div class="escudo smallbox float-left">
                    <img src="<?=BASE_URL?>assets/images/<?=$classificacao[$i]['imagem']?>" id="classif-imagem-<?=$i?>"     >
                </div>
                <div class="nome-time float-left" id="classif-equipe-<?=$i?>"><?=$classificacao[$i]['equipe']?></div>
                <div class="pontos smallbox float-left" id="classif-pontos-<?=$i?>"><?=$classificacao[$i]['pontos']?></div>
                <div class="jogos-classificacao smallbox float-left" id="classif-jogos-<?=$i?>"><?=$classificacao[$i]['jogos']?></div>
                <div class="vitorias smallbox float-left" id="classif-vitorias-<?=$i?>"><?=$classificacao[$i]['vitorias']?></div>
                <div class="empates smallbox float-left" id="classif-empates-<?=$i?>"><?=$classificacao[$i]['empates']?></div>
                <div class="derrotas smallbox float-left" id="classif-derrotas-<?=$i?>"><?=$classificacao[$i]['derrotas']?></div>
                <div class="saldo-gols smallbox float-left" id="classif-saldo_gols-<?=$i?>"><?=$classificacao[$i]['saldo_gols']?></div>
                <div class="gols-pro smallbox float-left" id="classif-gols_pro-<?=$i?>"><?=$classificacao[$i]['gols_pro']?></div>
                <div class="gols-contra smallbox float-left" id="classif-gols_contra-<?=$i?>"><?=$classificacao[$i]['gols_contra']?></div>
                <div class="clear"></div>
            </li>
            <?php
                endfor;
            ?>    
        </ul>
        <article class="jogos">
            <h3 class="cabecalho cabecalho-jogos">Jogos</h3>
            <input type="hidden" id="id_edicao" value="<?=$id_edicao?>">
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
                        if($partidas[$j]['partida_jogada']==0){
                            $gols_mandante = '-';
                            $gols_visitante = '-';
                        }
                        else{
                            $gols_mandante = $partidas[$j]['gols_mandante'];
                            $gols_visitante = $partidas[$j]['gols_visitante'];
                        }
                ?>
                <div class="partida">
                    <p class="data-jogo">10/10/2020 | 15:00</p>
                    <figure class="mandante float-left">
                        <figcaption class="float-right"><?=$partidas[$j]['mandante']['sigla']?></figcaption>
                        <img class="float-right" src="<?=BASE_URL?>assets/images/<?=$partidas[$j]['mandante']['imagem']?>">    
                    </figure>
                    <div class="resultado float-left">
                        <input type="hidden" class="id_partida" value="<?=$partidas[$j]['id']?>">
                        <input type="hidden" class="partida_jogada" value="<?=$partidas[$j]['partida_jogada']?>">
                        <div>
                            <span class="gols-span float-left"><?=$gols_mandante?></span>
                            <input type="text"class="gols-input float-left">
                            <input type="hidden" class="id_mandante" value="<?=$partidas[$j]['mandante']['id']?>">
                        </div>
                        
                        <span class="float-left">X</span>
                        
                        <div>
                            <span class="gols-span float-right" ><?=$gols_visitante?></span>
                            <input type="text"class="gols-input float-right">
                            <input type="hidden" class="id_visitante" value="<?=$partidas[$j]['visitante']['id']?>">
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
                
                if(isset($playoffs)):
            ?>
            <div id="playoffs">
                
                <h3 class="cabecalho cabecalho-jogos">Final</h3>
                <?php
                    echo '<br>TOTAL PARTIDAS FINAIS:'.count($playoffs);
                    for($i=0;$i<count($playoffs);$i++):
                ?>
                <div class="partida">
                    <p class="data-jogo">10/10/2020 | 15:00</p>
                    <figure class="mandante float-left">
                        <figcaption class="float-right"><?=$finalistas[0]['sigla']?></figcaption>
                        <img class="float-right" src="<?=BASE_URL?>assets/images/<?=$finalistas[0]['imagem']?>">    
                    </figure>
                    <div class="resultado float-left">
                        <div>
                            <span class="gols-span float-left"><?=$gols_mandante?></span>
                            <input type="text"class="gols-input float-left">
                            <input type="hidden" class="id_mandante" value="<?=$finalistas[0]['id']?>">
                        </div>
                        
                        <span class="float-left">X</span>
                        
                        <div>
                            <span class="gols-span float-right" ><?=$gols_visitante?></span>
                            <input type="text"class="gols-input float-right">
                            <input type="hidden" class="id_visitante" value="<?=$finalistas[0]['id']?>">
                        </div>
                        
                        
                    </div><!--resultado-left-->
                    
                    <figure class="visitante float-right">
                        <figcaption class="float-left"><?=$finalistas[1]['sigla']?></figcaption>
                        <img class="float-left" src="<?=BASE_URL?>assets/images/<?=$finalistas[1]['imagem']?>"> 
                    </figure>
                    <div class="clear"></div>
                    <div class="partida-rodape"></div>
                </div><!--partida-->
            <?php
                    endfor;
                endif;
            ?>
            </div>
        </article>
    </section>
