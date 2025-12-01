<?php 

require_once('connect.php');

if(isset($_SESSION['usuario_logado']) && !empty($_SESSION['usuario_logado'])){
    header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Metafixa</title>

    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <header>Login - Metafixa</header>
        <form method="POST">
            <div class="form">
                <div class="labels">
                    <label for="login">Login</label>
                    <label for="pass">Senha</label>
                </div>
                <div class="inputs">
                    <input type="text" name="login" id="login" required />
                    <input type="password" name="pass" id="pass" required />
                </div>
            </div>
            <div class="submit">
                <button><img src="assets/images/key.png">Entrar</button>
            </div>
        </form>
        <div><?php if(isset($_SESSION['mensagem'])) { echo $_SESSION['mensagem']; } ?></div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['login']) && !empty($_POST['login'])){
        if(isset($_POST['pass']) && !empty($_POST['pass'])){

            unset($_SESSION['message']);

            $user = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_ADD_SLASHES);
            $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_ADD_SLASHES);

            $sql = $connect->prepare("SELECT * FROM usuarios WHERE usuario = :user");
            $sql->bindValue(":user", $user);
            $sql->execute();

            if($sql->rowCount() > 0){
                $usuario = $sql->fetch();

                if(password_verify($pass, $usuario['senha'])){
                    $_SESSION['usuario_logado'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    $_SESSION['usuario'] = $usuario['usuario'];
                    header("Location: admin.php");
                }else{
                   $_SESSION['mensagem'] = "Senha incorreta."; 
                }

            }else{
                $_SESSION['mensagem'] = "Usuário não encontrado.";
            }
        }else{
            $_SESSION['mensagem'] = "Digite a senha.";
        }
    }
    
?>