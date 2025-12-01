<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar postagem - Metafixa</title>

    <link rel="stylesheet" href="assets/css/area-privada.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <div class="top-buttons">
            <a href="admin.php">Voltar</a>
        </div>
        <div><?php if(isset($_SESSION['mensagem']) && !empty($_SESSION['mensagem'])) { echo $_SESSION['mensagem']; } ?></div>
        <p class="info">Adicionar postagem</p>
        <section class="adicionar-postagem">
            <form method="POST" enctype="multipart/form-data">
                <label for="titulo">Título do post</label>
                <input type="text" name="titulo" id="titulo" required />
                <label for="desc">Descrição do post</label>
                <textarea name="desc" id="desc" required></textarea>
                <label for="link">Link externo (quando houver)</label>
                <input type="text" name="link" id="link" />
                <label for="img-post">Imagem do post</label>
                <input type="file" name="img-post" id="img-post" accept=".png, .jpg, .jpeg" required />
                <label for="img-post">Vídeo</label>
                <input type="file" name="video-post" id="video-post" accept=".mp4, .mov, .flv"/>
                <button>Adicionar</button>
            </form>
        </section>
    </div>
</body>
</html>

<?php

    if(!empty($_POST['titulo'])){
        if(!empty($_POST['desc'])){
            if(!empty($_FILES['img-post'])){

                $_SESSION['mensagem'] = "";

                $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_ADD_SLASHES);
                $desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_ADD_SLASHES);

                $link = null;

                if(isset($_POST['link']) && !empty($_POST['link'])){
                    $link = filter_input(INPUT_POST, "link", FILTER_SANITIZE_ADD_SLASHES);
                }

                //imagem
                $target_dir_img = "images/posts-blog/";
                $target_file_img = $target_dir_img . basename($_FILES["img-post"]["name"]);
                $uploadOkImg = 1;
                $imageFileType = strtolower(pathinfo($target_file_img,PATHINFO_EXTENSION));                
                $check = getimagesize($_FILES["img-post"]["tmp_name"]);

                if($check !== false) {
                    $uploadOkImg = 1;
                } else {
                    echo "Arquivo não é uma imagem.";
                    $uploadOkImg = 0;
                }

                // Check if file already exists
                if (file_exists($target_file_img)) {
                    echo "Arquivo já existe.";
                    $uploadOkImg = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo "Selecione apenas arquivos .jpg, .jpeg, .png";
                    $uploadOkImg = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOkImg == 0) {
                echo "Imagem não carregada.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["img-post"]["tmp_name"], $target_file_img)) {
                        echo "O arquivo ". htmlspecialchars( basename( $_FILES["img-post"]["name"])). " Foi carregado com sucesso.";
                    }
                }

                if(!empty($_FILES['video-post'])){
                    // vídeo
                    $target_dir_video = "videos/videos-blog/";
                    $target_file_video = $target_dir_video . basename($_FILES["video-post"]["name"]);
                    $uploadOkVideo = 1;
                    $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));

                    // Allow certain file formats
                    if($imageFileType != "mp4" && $imageFileType != "flv" && $imageFileType != "mov") {
                        echo "Selecione apenas arquivos .mp4, .flv, .mov";
                        $uploadOkImg = 0;
                    }

                    // Verifica se o arquivo já existe
                    if (file_exists($target_file_video)) {
                        echo "Arquivo já existe.";
                        $uploadOkVideo = 0;
                    }

                    // Permite apenas certos formatos
                    if ($videoFileType != "mp4" && $videoFileType != "flv" && $videoFileType != "mov") {
                        echo "Selecione apenas arquivos .mp4, .flv, .mov";
                        $uploadOkVideo = 0;
                    }

                    // Verifica se houve erro
                    if ($uploadOkVideo == 0) {
                        echo "Vídeo não carregado.";
                    } else {
                        if (move_uploaded_file($_FILES["video-post"]["tmp_name"], $target_file_video)) {
                            echo "O arquivo " . htmlspecialchars(basename($_FILES["video-post"]["name"])) . " foi carregado com sucesso.";
                        } else {
                            echo "Erro ao carregar o vídeo.";
                        }
                    }
                }else{
                    $_FILES["video-post"]["name"] = null;
                }

                $sql = $connect->prepare("INSERT INTO posts VALUES(default, :titulo, :descricao, :imagem, :video, :autor, :link, default)");
                $sql->bindParam(":titulo", $titulo);
                $sql->bindParam(":descricao", $desc);
                $sql->bindValue(":imagem",  $_FILES["img-post"]["name"]);
                $sql->bindValue(":video",  $_FILES["video-post"]["name"]);
                $sql->bindValue(":autor", $_SESSION['usuario_logado']);
                $sql->bindValue(":link", $link);
                
                if($sql->execute()){
                    echo "<script>
                        alert('Post inserido com sucesso!');
                        window.location.href = 'admin.php';
                    </script>";
                }
            }else{
                $_SESSION['mensagem'] = "Selecione uma imagem para o post.";
            }
        }else{
            $_SESSION['mensagem'] = "Preencha a descrição do post.";
        }
    }

?>