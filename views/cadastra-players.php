<?php
    if(isset($msg) && !empty($msg)){
        echo "<p class='erro'>".$msg."</p>";
    }
?>

<form method="POST" action="<?=BASE_URL?>players/cadastrar" enctype="multipart/form-data" class="form-cadastro">
    <figure id="preview">
        <img src="<?=BASE_URL?>assets/images/photo.png" id="img_preview" alt="Prévia da imagem do usuário">
        <figcaption><a href="javascript:;" id="btn_trocar_imagem">Trocar imagem</a></figcaption>
        <input type="file" name="arquivo" id="imagem_usuario" onchange="trocarImagem()">
    </figure>
    <label>Nome Completo:</label>
    <input type="text" name="nome" required >
    
    <label>Nome de usuário:</label>
    <input type="text" name="username" required >
    
    <label>Email:</label>
    <input type="email" name="email" required >
    
    <label>Senha:</label>
    <input type="password" name="senha1" required >
    
    <label>Confirmar senha:</label>
    <input type="password" name="senha2" required >
    
    <button type="submit" class="btn">Cadastrar</button>
</form>
