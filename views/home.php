

<div class="slide-imagens"></div>
    <figure class="slide-container">
        <img class="img-slide" src="<?=BASE_URL?>assets/images/fifa18.jpg" alt="Slide de Imagens">
    </figure>
    <section class="players">
        <h2>Players</h2>
        <?php
            if(isset($players) && !empty($players)){
                foreach ($players as $player) : ?>
                    <a href="<?=BASE_URL?>players/abrir/<?=$player['id']?>#player">
                    <figure class="img_player float-left">
                        <img src="<?=BASE_URL?>assets/images/<?=$player['imagem']?>" alt="<?=$player['nome']?>">
                        <figcaption><?=$player['nome']?></figcaption>
                    </figure>
                </a> 
        <?php
                endforeach;
            }
        ?>
         <div class="clear"></div>    
    </section>
   
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
       
            <li class="item-classificacao">
                <div class="posicao smallbox float-left">1</div>
                <div class="escudo smallbox float-left"><img src="<?=BASE_URL?>assets/images/clube"></div>
                <div class="nome-time float-left">Manchester City</div>
                <div class="pontos smallbox float-left">0</div>
                <div class="jogos-classificacao smallbox float-left">0</div>
                <div class="vitorias smallbox float-left">0</div>
                <div class="empates smallbox float-left">0</div>
                <div class="derrotas smallbox float-left">0</div>
                <div class="saldo-gols smallbox float-left">0</div>
                <div class="gols-pro smallbox float-left">0</div>
                <div class="gols-contra smallbox float-left">0</div>
                <div class="clear"></div>
            </li>
            <li class="item-classificacao">
                <div class="posicao smallbox float-left">1</div>
                <div class="escudo smallbox float-left"><img src="<?=BASE_URL?>assets/images/clube"></div>
                <div class="nome-time float-left">Manchester City</div>
                <div class="pontos smallbox float-left">0</div>
                <div class="jogos-classificacao smallbox float-left">0</div>
                <div class="vitorias smallbox float-left">0</div>
                <div class="empates smallbox float-left">0</div>
                <div class="derrotas smallbox float-left">0</div>
                <div class="saldo-gols smallbox float-left">0</div>
                <div class="gols-pro smallbox float-left">0</div>
                <div class="gols-contra smallbox float-left">0</div>
                <div class="clear"></div>
            </li>
            <li class="item-classificacao">
                <div class="posicao smallbox float-left">1</div>
                <div class="escudo smallbox float-left"><img src="<?=BASE_URL?>assets/images/clube"></div>
                <div class="nome-time float-left">Manchester City</div>
                <div class="pontos smallbox float-left">0</div>
                <div class="jogos-classificacao smallbox float-left">0</div>
                <div class="vitorias smallbox float-left">0</div>
                <div class="empates smallbox float-left">0</div>
                <div class="derrotas smallbox float-left">0</div>
                <div class="saldo-gols smallbox float-left">0</div>
                <div class="gols-pro smallbox float-left">0</div>
                <div class="gols-contra smallbox float-left">0</div>
                <div class="clear"></div>
            </li>
            <li class="item-classificacao">
                <div class="posicao smallbox float-left">1</div>
                <div class="escudo smallbox float-left"><img src="<?=BASE_URL?>assets/images/clube"></div>
                <div class="nome-time float-left">Manchester City</div>
                <div class="pontos smallbox float-left">0</div>
                <div class="jogos-classificacao smallbox float-left">0</div>
                <div class="vitorias smallbox float-left">0</div>
                <div class="empates smallbox float-left">0</div>
                <div class="derrotas smallbox float-left">0</div>
                <div class="saldo-gols smallbox float-left">0</div>
                <div class="gols-pro smallbox float-left">0</div>
                <div class="gols-contra smallbox float-left">0</div>
                <div class="clear"></div>
            </li>
            
       
        </ul>
        <article class="jogos">
            <h3 class="cabecalho cabecalho-jogos">Resultados</h3>
            <div class="rodada">
                
            </div>
            <h3 class="cabecalho cabecalho-jogos">1ª Rodada
                <button class="prev"><i class="fa fa-chevron-left"></i></button>
                <button class="next"><i class="fa fa-chevron-right"></i></button>
            </h3>
            
            
            <div class="partida">
                <p class="data-jogo">10/10/2020 | 15:00</p>
                <figure class="mandante float-left">
                    <figcaption class="float-right">MCI</figcaption>
                    <img class="float-right" src="<?=BASE_URL?>assets/images/clube.png">                   
                </figure>
                <span class="float-left">X</span>
                <figure class="visitante float-right">
                    <figcaption class="float-left">MCI</figcaption>
                    <img class="float-left" src="<?=BASE_URL?>assets/images/clube.png">      
                </figure>
                <div class="clear"></div>
                <div class="partida-rodape"></div>
            </div>
            
            <div class="partida">
                <p class="data-jogo">10/10/2020 | 15:00</p>
                <figure class="mandante float-left">
                    <figcaption class="float-right">MCI</figcaption>
                    <img class="float-right" src="<?=BASE_URL?>assets/images/clube.png">                   
                </figure>
                <span class="float-left">X</span>
                <figure class="visitante float-right">
                    <figcaption class="float-left">MCI</figcaption>
                    <img class="float-left" src="<?=BASE_URL?>assets/images/clube.png">      
                </figure>
                <div class="clear"></div>
                <div class="partida-rodape"></div>
            </div>
            
            <div class="partida">
                <p class="data-jogo">10/10/2020 | 15:00</p>
                <figure class="mandante float-left">
                    <figcaption class="float-right">MCI</figcaption>
                    <img class="float-right" src="<?=BASE_URL?>assets/images/clube.png">                   
                </figure>
                <span class="float-left">X</span>
                <figure class="visitante float-right">
                    <figcaption class="float-left">MCI</figcaption>
                    <img class="float-left" src="<?=BASE_URL?>assets/images/clube.png">      
                </figure>
                <div class="clear"></div>
                <div class="partida-rodape"></div>
            </div>
            
            <div class="partida">
                <p class="data-jogo">10/10/2020 | 15:00</p>
                <figure class="mandante float-left">
                    <figcaption class="float-right">MCI</figcaption>
                    <img class="float-right" src="<?=BASE_URL?>assets/images/clube.png">                   
                </figure>
                <span class="float-left">X</span>
                <figure class="visitante float-right">
                    <figcaption class="float-left">MCI</figcaption>
                    <img class="float-left" src="<?=BASE_URL?>assets/images/clube.png">      
                </figure>
                <div class="clear"></div>
                <div class="partida-rodape"></div>
            </div>
            
            
        </article>
    </section>

