<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área privada - blog Metafixa</title>

    <link rel="stylesheet" href="assets/css/area-privada.css" />
</head>
<body>
    <?php 
        include('header.php'); 

        $posts = [];
    
        $sql = $connect->prepare("SELECT * FROM posts ORDER BY data_postagem DESC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $posts = $sql->fetchAll();
        }
    ?>

    
    <div class="container">
        <div class="top-buttons">
            <a href="nova-postagem.php">Adicionar nova postagem</a>
        </div>
        <?php if(isset($_SESSION['mensagem']) && !empty($_SESSION['mensagem'])){ echo '<div>'.$_SESSION['mensagem'].'</div>'; } ?>
        <section class="todos-posts">
            <p class="info">Postagens do blog</p>

             <?php if(!empty($posts)): ?>
                <table border="1">
                    <theader>
                        <tr>
                            <th>Título</th>
                            <th>Imagem</th>
                            <th>Vídeo</th>
                            <th>Data postagem</th>
                            <th>Ação</th>
                        </tr>
                    </theader>

                    <tbody>
                        <?php foreach($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['titulo']?></td>
                                <td><?php echo $post['imagem']?></td>
                                <td><?php echo $post['video'] == null ? "Não enviado." : $post['video']; ?></td>
                                <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $post['data_postagem'])->format('d/m/Y H:i'); ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $post['id']?>">Editar</a><br>
                                    <a onclick="confirmDelete(<?php echo $post['id']; ?>, '<?php echo addslashes($post['titulo']); ?>')" href="#">Excluir</a>
                                    <a href="<?php echo !empty($post['link'] && $post['link'] != null) ? $post['link'] : 'ver-materia.php?id='.$post['id']; ?>" target="_blank">Ver post</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php 
                else: 
                    echo "Nenhum post para ser exibido."; 
                endif; 
            ?>
        </section>
    </div>

    <footer>
        <script src="assets/js/admin.js"></script>
    </footer>
</body>
</html>