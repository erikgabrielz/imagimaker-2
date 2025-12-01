<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog - Metafixa</title>

        <!-- CSS FILES -->                
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,400;0,600;0,700;1,200;1,700&display=swap" rel="stylesheet">
            
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/vegas.min.css" rel="stylesheet">

        <link href="css/tooplate-barista.css" rel="stylesheet">

        <link href="css/template-blog.css" rel="stylesheet" />

        <link href="css/ver-post.css" rel="stylesheet" />

    </head>
    
    <body class="reservation-page">
            <main>
                <div class="bg-container">
                    <nav class="navbar navbar-expand-lg">                
                        <div class="container">
                            <a class="navbar-brand d-flex align-items-center" href="index.php">
                                <img src="images/coffee-beans.png" class="navbar-brand-image img-fluid" alt="">
                        
                            </a>
            
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
            
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-lg-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="blog.php">Home</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="index.html#section_5">Site Metafixa</a>
                                    </li>
                                </ul>

                                <div class="ms-lg-3">
                                    <a class="btn custom-btn custom-border-btn" href="admin.php">
                                        Admin
                                        <i class="bi-arrow-up-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    
                    <?php 
                        require_once('connect.php');

                        if(!isset($_GET['id']) || empty($_GET['id'])){
                            header("Location: blog.php");
                        }

                        $post = array();

                        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                        $sql = $connect->prepare("SELECT posts.titulo, posts.descricao, posts.imagem, posts.video, posts.autor, posts.data_postagem, usuarios.nome FROM posts inner join usuarios ON posts.autor = usuarios.id WHERE posts.id = :id");
                        $sql->bindParam(":id", $id);
                        $sql->execute();

                        if($sql->RowCount() > 0){
                            $post = $sql->fetch();
                        }else{
                            $post = ['erro' => 404, "mensagem" => "Erro 404, post não encontrado."];
                        }
                    ?>

                    <section class="booking-section section-padding">
                        <div class="container">
                            <div class="row">
                                <div class="post-area">
                                    <div style="width: 100vw"></div>
                                    
                                    <?php 
                                        if(isset($post['erro']) && $post['erro'] == 404){
                                            echo $post['mensagem'];
                                            exit();
                                        }
                                    ?>

                                    <div class="header-post">
                                        <h1><?php echo $post['titulo']; ?></h1>
                                        <span>Data da postagem: <?php echo DateTime::createFromFormat('Y-m-d H:i:s', $post['data_postagem'])->format('d/m/Y H:i'); ?> | Autor: <?php echo $post['nome']; ?></span>
                                    </div>
                                    <img src="images/posts-blog/<?php echo $post['imagem']; ?>" alt="">
                                    <div class="descricao">
                                        <?php echo $post['descricao']; ?>
                                    </div>

                                    <?php if($post['video'] != null): ?>
                                        <video style="width: 100%; max-height: 1080px;" controls>
                                            <source src="videos/videos-blog/<?php echo $post['video']; ?>" type="video/mp4">
                                        </video>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>


                   

                    <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-12 me-auto">
                                    <em class="text-white d-block mb-4">Onde nos encontrar?</em>

                                    <div class="d-flex text-white">
                                        <div>
                                            <div>Curitiba-PR</div>
                                        </div>
                                    </div>

                                    <ul class="social-icon mt-4">
                                    <li><a href="https://www.facebook.com/ImagiMakerEdutech" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://api.whatsapp.com/send?phone=41998287213" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                    <li><a href="https://www.instagram.com/imagimaker/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/@imagimaker" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                    </ul>
                                </div>

                                <div class="col-lg-3 col-12 mt-4 mb-3 mt-lg-0 mb-lg-0">
                                    <em class="text-white d-block mb-4">Contato</em>

                                    <p class="d-flex">
                                        <strong class="me-2">Email:</strong>

                                        <a href="mailto:educacao@imagimaker.com.br" class="site-footer-link">
                                            educacao@imagimaker.com.br
                                        </a>
                                    </p>
                                </div>

                                <div class="col-lg-8 col-12 mt-4">
                                    <p class="copyright-text mb-0">Copyright © 2025</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </main>


        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/vegas.min.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
