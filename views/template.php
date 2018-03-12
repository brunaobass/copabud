<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$titulo_pagina?></title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/estilo.css"/>
        <?php
            if(isset($css) && !empty($css)){
                echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'assets/css/'.$css.'.css"/>';
            }
        ?>
    </head>
    <body>
        <header>
            <div class="topo">
                <div class="conteudo">
                    <figure class="logo">
                        <img src="<?=BASE_URL?>assets/images/logo.png" alt="Logo da Copa Budweiser">
                        <figcaption>Copa Budweiser</figcaption>
                    </figure>
                    <div class="icones">
                        <button id="btn-fechar"><i class="fa fa-times"></i></button>
                        <button id="btn-menu"><img src="<?=BASE_URL?>assets/images/list.png" alt="botão de menu"></button>
                    </div>
                    <nav class="menu-navegacao">
                        <ul class="menu">
                            <li><a href="<?=BASE_URL?>home">Home</a></li>
                            <li><a href="<?=BASE_URL?>sobre">Sobre</a></li>
                            <li><a href="<?=BASE_URL?>players">Players</a></li>
                            <li><a href="<?=BASE_URL?>classificacao">Classificaçao e Tabela</a></li>
                            <li><a href="<?=BASE_URL?>estatisticas">Estatísticas</a></li>
                            <li><a href="<?=BASE_URL?>vencedores">Vencedores</a></li>                           
                        </ul>
                    </nav>
                    <form method="POST" class="form-login">
                        <label>Email</label>
                        <input type="email" name="email" required placeholder="Email">
                        
                         <label>Senha</label>
                         <input type="password" name="senha" required placeholder="Senha">
                        <button type="submit" class="btn btn-enviar">Logar</button>
                    </form>
                </div>
            </div>
        </header>
        <main>
            <?php
                if(isset($titulo_h1) && !empty($titulo_h1)){
                    echo '<h1>'.$titulo_h1.'</h1>';
                }
            ?>
            <div class="conteudo">
                <?php
                    $this->loadViewInTemplate($viewName,$viewData);
                ?>
            </div>
        </main>
        
        <footer>
            <div class="conteudo">
                <p class="copyright">2018 Todos os direitos reservados</p>
               
                <aside class="socials">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-youtube"></i></a>
                    <a href="#"><i class="fa fa-whatsapp"></i></a>

                </aside>
            </div>
            
        </footer>
        <script src="<?=BASE_URL?>assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
        <script src="<?=BASE_URL?>assets/js/script.js"></script>
    </body>
</html>
