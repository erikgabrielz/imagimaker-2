<?php
    require_once('connect.php');

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_ADD_SLASHES);

    $sql = $connect->prepare("SELECT id FROM posts WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();

    if($sql->rowCount() > 0){
        $sql = $connect->prepare("DELETE FROM posts WHERE id = :id");
        $sql->bindParam(":id", $id);
        
        if($sql->execute()){
            echo "<script>
                alert('Post excluído com sucesso.');
                window.location.href = 'admin.php'
            </script>";
        }
    }else{
        header("Location: admin.php");
    }
?>