<?php

    include_once('connect.php');

    if(!isset($_GET['id']) || empty($_GET['id'])){
        header(("Location: admin.php"));
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $sql = $connect->prepare("UPDATE posts set video = null WHERE id = :id");
    $sql->bindParam(":id", $id);
    if($sql->execute()){
        echo "<script>
            alert('Vídeo excluído com sucesso');
            window.location.href = 'admin.php';
        </script>";
    }