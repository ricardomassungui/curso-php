<?php
session_start();
ob_start();
echo password_hash("boatona", PASSWORD_BCRYPT);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth-System</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: rgb(3, 19, 15, 0.144);

        }

        /*div{
            position:relative;

        }*/
        section {
            /*position: absolute;
            left:  620px;
            top: 100px;
            transform: translate(-620px, 620px);*/
            max-width: 320px;
            min-width: 160px;
            background-color: #ffffff99;
            font-weight: bold;
            padding: 15px;
            margin: 10px auto 0px auto;
            box-shadow: 1px 1px 3px black;
            border-radius: 10px;

        }

        div#bt {
            text-align: center;
        }

        #alert {
            /* position: absolute;
            left:  50%;
            top: 20%;
            transform: translate(-50%, 50%);*/
            max-width: 345px;
            min-width: 170px;
            margin: auto;
            background-color: rgb(255, 5, 70, 0.255);
            color: white;
            padding: 5px;
            border-radius: 10px;

        }

        h4 {
            text-align: center;
        }

        h1,
        h2 {
            text-align: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif
        }

        .alert {
            color: white;
            background-color: rgba(255, 0, 0, 0.254);

            width: 400px;
            padding: 10px;
        }

        #conteiner {
            max-width: 360px;
            min-width: 130px;
            padding: 5px;
            margin: 175px auto 0px auto;
        }

        p {
            text-align: center;
        }

        p>a {
            text-align: center;
            text-decoration: none;
            color: rgb(45, 170, 255);
            cursor: pointer;

        }

        p>a:hover {

            color: rgb(45, 160, 255);
            cursor: pointer;
        }

        p>a:active {
            color: white;
        }

        input {
            height: 30px;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 5px;
            font-size: 13pt;
            width: 100%;
        }

        input:hover {
            border-color: rgb(29, 89, 191);

        }

        input[type="submit"],
        input[type="reset"] {
            font-weight: bold;


        }

        label {
            color: black;
            margin-bottom: 7px;
        }

        header {
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="conteiner">

        <?php
        include "conexao-pdo.php";
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dados['sendlogin'])) { //se o botão "enviar" for clicado!

            if (!(empty($dados['Password']) and empty($_POST['Username']))) { //se tiver dados digitados
                $sql = "SELECT * FROM tb_cadastro WHERE username=:u AND senha=:s";
                $res = $pdo->prepare($sql);
                $res->bindParam(':u', $dados['Username'], PDO::PARAM_STR);
                $res->bindParam(':s', $dados['Password'], PDO::PARAM_STR);
                $res->execute();

                if ($reg = $res->fetch(PDO::FETCH_ASSOC)){ //se o usuário e senha for encontrado!   

                    if ($dados['Password'] == $reg['senha']) {
                        
                        $num = rand(1000000, 9000000);
                        $_SESSION["name"] = $reg['nome'];
                        $_SESSION["nc"] = $num;
                        $_SESSION["nome_usuario"] = $dados['Username'];
                        $_SESSION["senha_usuario"] = $dados['Password'];
                        
                        header("location:home2.php?nl=$num");

                    } else {

                        $_SESSION['msg'] = "<div id='alert'>
                        <h4>Senha incorreta! verifica os dados e tente novamente.</h4></div>";
                        
                    }
                } else { //se o usuário e senha não forem encontrados
                    $_SESSION['msg'] = "<div id='alert'>
                        <h4>Usuário ou Senha incorretos! verifica os dados e tente novamente.</h4>
                    </div>";
                }
            } else { // não for clicado!
                $_SESSION['msg'] = "<div id='alert'>
            <h4>Necessário Preencher todos os Campos do Formulário!</h4>
        </div>";
            }
        }

        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <section>

            <header><img src="img/easysoft.png" alt=""></header>
            <form action="" method="post" name="f_login" id="f_login">
                <h2>&#x1f913;DevFolio&#x1f4bb;</h2>
                <hr>
                <br>
                <label for="">Username: </label>
                <input type="text" name="Username" id="user" size="30" maxlength="15" placeholder="Nome de Usuário"><br><br>
                <label for="">Password: </label>
                <input type="password" name="Password" size="30" maxlength="30" placeholder="Palavra Passe"><br><br>
                <hr>
                <div id="bt">
                    <input type="submit" value=" Entrar " name="sendlogin">
                    <input type="reset" value=" Limpar ">
                </div>
                <p><a href="#">Criar &#x1F310; Conta!</a></p>

            </form>
        </section>
    </div>
</body>

</html>