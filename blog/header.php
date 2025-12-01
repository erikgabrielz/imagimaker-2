<?php
    require_once("connect.php");

    if(!isset($_SESSION['usuario_logado']) || empty($_SESSION['usuario_logado'])){
        header("Location: login.php");
    }
?>

<header>
    <div class="container flex">
        <a href="admin.php"><img src="../assets/images/logo-image-maker.png"></a>
        <div class="flex">
            <p>Você está logado com o usuário: <?php echo $_SESSION['usuario']." (".$_SESSION['usuario_nome'].")"; ?></p>|
            <a href="logout.php">Sair</a>
        </div>
    </div>
</header>