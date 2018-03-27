<?php /*<table class="tabela_times">
    
    <tr>
        <?php
            foreach($mandantes as $mandante):
        ?>
            <td><?=$mandante?></td>
        <?php
            endforeach;
        ?>
    </tr>
    <tr>   
        <?php
            foreach($visitantes as $visitante):
        ?>
            <td><?=$visitante?></td>
        <?php
            endforeach;
        ?>
    </tr>
</table>

<section class="jogos">
    <h3>1ª Rodada</h3>
    <br>
    <?php
        for($i=0;$i<count($mandantes);$i++):
    ?>
    <p><?=$mandantes[$i].' X '.$visitantes[$i]?></p>
    <?php
        endfor;
    ?>
</section>*/
    foreach ($rodadas as $rodada) :
        echo '<br><h3>'.$rodada['rodada'].'ª rodada</h3><br>';
        for($i=0;$i<$num_partidas;$i++) :
?>
        <p><?=$rodada['mandantes'][$i].' X '.$rodada['visitantes'][$i]?></p> 

<?php
        endfor;
    endforeach;
?>
