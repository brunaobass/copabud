<section class="players">
    <h2>Players</h2>

    <?php
        if(isset($players) && !empty($players)){
            foreach ($players as $item) : ?>
                <a href="<?=BASE_URL?>players/abrir/<?=$item['id']?>#player">
                    <figure class="img_player float-left">
                        <img src="<?=BASE_URL?>assets/images/<?=$item['imagem']?>" alt="<?=$item['nome']?>">
                        <figcaption><?=$item['nome']?></figcaption>
                    </figure>
                </a> 
    <?php
            endforeach;
        }
    ?>
    <div class="clear"></div>
</section>
<?php 
    if(isset($player) && !empty($player)): ?>
        
        
    <section class="player" id="player">
        <h2><?=$player['nome']?></h2>
       
            <figure class="img_player">
                <img src="<?=BASE_URL?>assets/images/<?=$player['imagem']?>" alt="<?=$player['nome']?>">
            </figure>
           
        <ul class="dados-jogador">
            <li>Nome:<?=$player['nome']?></li>
            <li>Principais equipes:<?=$player['equipes']?></li>
            <li>Melhor colocação no torneio:<?=$player['melhor_colocacao']?></li>
            <li>Título:<?=$player['num_titulos']?></li>
            <li>Total de pontos: <?=$player['total_pontos']?></li>
            <li>Edições:<?=$player['edicoes']?></li>
            <li>Maior pontuação em uma edição: <?=$player['maior_pontuacao']?></li>            
        </ul>
        <br>
        <?php
            if(isset($estatisticas_player) && !empty($estatisticas_player)):
                $ultima_edicao = end($estatisticas_player);
                ?>
        <article class="ultima-edicao">
            <h2>Jogos na última edição</h2>
            <div class="quadrado float-left">
                <h4 class="titulo">Total</h4>
                <span class="dados"><?=$ultima_edicao['jogos']?></span>
            </div>
            <div class="quadrado float-left">
                <h4 class="titulo">Vitórias</h4>
                <span class="dados"><?=$ultima_edicao['vitorias']?></span>
            </div>
            <div class="quadrado float-left">
                <h4 class="titulo">Derrotas</h4>
                <span class="dados"><?=$ultima_edicao['derrotas']?></span>
            </div>
            <div class="quadrado float-left">
                <h4 class="titulo">Empates</h4>
                <span class="dados"><?=$ultima_edicao['empates']?></span>
            </div>
            <div class="quadrado float-left">
                <h4 class="titulo">Gols</h4>
                <span class="dados"><?=$ultima_edicao['gols_pro']?></span>
            </div>
            <div class="clear"></div>
        </article>
        
        <h2>Estatísticas do jogador</h2>
        <table class="estatísticas-player">
            <thead>
                <tr>
                    <th>Edição</th>
                    <th>Equipe</th>
                    <th>Jogos</th>
                    <th>Vitórias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Gols</th>
                </tr>   
            </thead>
            <tbody>
                <?php 
                    foreach ($estatisticas_player as $estatistica) :?>
                <tr>
                    <td><?=$estatistica['id_edicao']?></td>
                    <td><?=$estatistica['equipe']?></td>
                    <td><?=$estatistica['jogos']?></td>
                    <td><?=$estatistica['vitorias']?></td>
                    <td><?=$estatistica['empates']?></td>
                    <td><?=$estatistica['derrotas']?></td>
                    <td><?=$estatistica['gols_pro']?></td>
                    
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
        <?php
            endif;
        ?>
            
    </section>
<?php
    endif;
?>
    

