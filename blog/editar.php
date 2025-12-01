<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar postagem - Metafixa</title>

    <link rel="stylesheet" href="assets/css/area-privada.css">
</head>
<body>
    <?php 
        include('header.php'); 
    
        if(!isset($_GET['id']) || empty($_GET['id'])){
            header("Location: admin.php");
        }

        $post = [];

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        $sql = $connect->prepare("SELECT * FROM posts WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $post = $sql->fetch();
        }else{
            $post = ["erro" => 404, "mensagem" => "Post não econtrado."];
        }
    ?>

    <div class="container">
        <div class="top-buttons">
            <a href="admin.php">Voltar</a>
        </div>

        <?php 
            if(isset($post['erro']) && $post['erro'] == 404){
                echo $post['mensagem'];
                exit();
            }
        ?>
        
        <p class="info">Editar postagem</p>
        <section class="adicionar-postagem">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?php echo $post['id']; ?>" />
                <label for="titulo">Título do post</label>
                <input type="text" name="titulo" id="titulo" value="<?php echo $post['titulo']; ?>" required />
                <label for="desc">Descrição do post</label>
                <textarea name="desc" id="desc" required><?php echo $post['descricao']; ?></textarea>
                <label for="link">Link externo (quando houver)</label>
                <input type="text" name="link" id="link" />
                <label for="img-post">Imagem do post</label>
                <div>atual: <code><?php echo $post['imagem']; ?></code><br> Selecione outro arquivo abaixo para alterar.</div>
                <input type="file" name="img-post" id="img-post" accept=".png, .jpg, .jpeg" />
                <label for="img-post">Vídeo</label>
                <div>atual: <code><?php echo $post['video']; ?></code> 
                <?php echo !empty($post['video']) ? '<a style="display: inline-block;" href="excluir-video.php?id='.$post["id"].'">Excluir vídeo</a>' : ""; ?>
                <br> Selecione outro arquivo abaixo para alterar.</div>
                <input type="file" name="video-post" id="video-post" accept=".mp4, .mov, .flv"/>
                <button>Atualizar</button>
            </form>
        </section>
    </div>
</body>
</html>

<?php
    if (!empty($_POST['id'])) {
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        $campos = [];
        $params = [];

        if (!empty($_POST['titulo'])) {
            $campos[] = "titulo = :titulo";
            $params[':titulo'] = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_ADD_SLASHES);
        }

        if (!empty($_POST['desc'])) {
            $campos[] = "descricao = :descricao";
            $params[':descricao'] = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_ADD_SLASHES);
        }

        if (!empty($_POST['link'])) {
            $campos[] = "link = :link";
            $params[':link'] = filter_input(INPUT_POST, "link", FILTER_SANITIZE_ADD_SLASHES);
        }

        // Imagem
        if (!empty($_FILES['img-post']['name'])) {
            $target_dir_img = "images/posts-blog/";
            $target_file_img = $target_dir_img . basename($_FILES["img-post"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file_img, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["img-post"]["tmp_name"]);

            if ($check !== false && in_array($imageFileType, ["jpg", "jpeg", "png"]) && !file_exists($target_file_img)) {
                move_uploaded_file($_FILES["img-post"]["tmp_name"], $target_file_img);
            }

            $campos[] = "imagem = :imagem";
            $params[':imagem'] = $_FILES["img-post"]["name"];
        }

        // Vídeo
        if (!empty($_FILES['video-post']['name'])) {
            $target_dir_video = "videos/videos-blog/";
            $target_file_video = $target_dir_video . basename($_FILES["video-post"]["name"]);
            $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));

            if (in_array($videoFileType, ["mp4", "flv", "mov"]) && !file_exists($target_file_video)) {
                move_uploaded_file($_FILES["video-post"]["tmp_name"], $target_file_video);
            }
            $campos[] = "video = :video";
            $params[':video'] = $_FILES["video-post"]["name"];
        }

        if (!empty($campos)) {
            $sql = $connect->prepare("UPDATE posts SET " . implode(", ", $campos) . " WHERE id = :id");
            $params[':id'] = $id;

            foreach ($params as $key => $value) {
                $sql->bindValue($key, $value);
            }

            if ($sql->execute()) {
                echo "<script>
                    alert('Post atualizado com sucesso!');
                    window.location.href = 'admin.php';
                </script>";
            } else {
                echo "Erro ao atualizar o post.";
            }
        } else {
            echo "Nenhuma alteração detectada.";
        }
    } else {
        echo "ID do post não informado.";
    }


?>