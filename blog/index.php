<?php require_once('connect.php'); ?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog - Imagimaker</title>

        <!-- CSS FILES -->                
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,400;0,600;0,700;1,200;1,700&display=swap" rel="stylesheet">
            
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <link href="assets/css/bootstrap-icons.css" rel="stylesheet">

        <link href="assets/css/vegas.min.css" rel="stylesheet">

        <link href="assets/css/tooplate-barista.css" rel="stylesheet">

        <link href="assets/css/template-blog.css" rel="stylesheet" />
        
        <link rel="stylesheet" href="assets/css/fontawesome.css">
        <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
        <link rel="stylesheet" href="assets/css/owl.css">
        <link rel="stylesheet" href="assets/css/lightbox.css">
        <link rel="stylesheet" href="assets/css/landing-page.css">
        <link href="../assets/css/fontawesome.css" rel="stylesheet" />

    </head>
    
    <body class="reservation-page">

            <!-- Sub Header -->
            <div class="sub-header">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-sm-8">
                    <div class="left-content">
                    </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                    <div class="right-icons">
                        <ul>
                        <li><a href="https://www.facebook.com/ImagiMakerEdutech" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://api.whatsapp.com/send?phone=41998287213" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                        <li><a href="https://www.instagram.com/imagimaker/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/@imagimaker" target="_blank"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <main>
                <!-- ***** Header Area Start ***** -->
                <header class="header-area header-sticky">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <nav class="main-nav">
                                    <!-- ***** Logo Start ***** -->
                                    <a href="index.html" class="logo">
                                        <img class="logo-imagi" src="../assets/images/logo-image-maker.png" alt="Logo imagimaker" />
                                        <span class="header-title"></span>
                                    </a>
                                    <!-- ***** Logo End ***** -->
                                    <!-- ***** Menu Start ***** -->
                                    <ul class="nav">
                                        <li class="scroll-to-section"><a href="../index.html" class="active">Home</a></li>
                                        <!--<li><a href="4-ano.html">Materiais de apoio</a></li>-->
                                        <li><a href="../editoriais.html">Editorial</a></li>
                                        <li><a href="../cursos.html">Cursos</a></li> 
                                        <li><a href="../index.html#contact">Contato</a></li> 
                                    </ul>        
                                    <a class='menu-trigger'>
                                        <span>Menu</span>
                                    </a>
                                    <!-- ***** Menu End ***** -->
                                </nav>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- ***** Header Area End ***** -->
                    

                    <section class="booking-section section-padding">
                    <div class="container">
                        <div class="row">
<!--
                            <div class="col-lg-10 col-12 mx-auto">
                                <div class="booking-form-wrap">
                                    <div class="row">
                                        <div class="col-lg-7 col-12 p-0">
                                            <form class="custom-form booking-form" action="#" method="post" role="form">
                                                <div class="text-center mb-4 pb-lg-2">
                                                    <em class="text-white"></em>

                                                    <h2 class="text-white">Blog</h2>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-lg-5 col-12 p-0">
                                            <div class="booking-form-image-wrap">
                                                
                                                <img src="images/Londrina sorri para o Choro - 2.JPG" class="booking-form-image img-fluid" alt="">
                                            </div>

                                        </div>
                                    </div>
                                </div>
-->
                            </div>
                        </div>
                    </section>

                    <div class="title-blog" >
                        <div class="container">
                            <div class="row">
                                <h1>Bem vindo ao blog<br> da Imagimaker</h1>
                                <p><!-- espaço livre para descrição --></p>
                            </div>
                        </div>
                    </div>

                    <div class="ultimas-postagens">
                        <div class="container">
                            <div class="row">
                                <h2>Últimas postagens</h2>

                                <div class="posts">

                                    <?php
                                        $itens_por_pagina = 10;
                                        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                                        $inicio = ($pagina - 1) * $itens_por_pagina;

                                        $sql = $connect->prepare("SELECT * FROM posts ORDER BY data_postagem DESC LIMIT :inicio, 8");
                                        $sql->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                                        $sql->execute();

                                        if($sql->rowCount() > 0):
                                            $posts = $sql->fetchAll();

                                            foreach($posts as $post):
                                            
                                    ?>
                                                <div class="card">
                                                    <img src="images/posts-blog/<?php echo $post['imagem']; ?>" />
                                                    <div class="card-text">
                                                        <p class="title"><?php echo $post['titulo']; ?></p>
                                                        <p class="description"><?php echo $post['descricao']; ?></p>
                                                        <div class="rodape">
                                                            <!--<span>publicado em:<br> <?php // echo $post['data_postagem']; ?></span>-->
                                                            <a href="<?php echo $post['link'] != null ? $post['link']: "ver-materia.php?id=".$post['id']; ?>" target="<?php echo $post['link'] != null ? "_blank" : "" ?>">Leia mais...</a>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            endforeach;
                                        else:
                                            echo "Nenhum post.";
                                        endif;
                                    ?>
                                </div>

                                

                                <div class="paginacao">
                                    <?php
                                        $total = $connect->query("SELECT COUNT(*) FROM posts")->fetchColumn();
                                        $total_paginas = ceil($total / $itens_por_pagina);

                                        for ($i = 1; $i <= $total_paginas; $i++) {
                                            echo "<a href='?pagina=$i'>$i</a> ";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

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
