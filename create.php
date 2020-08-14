<?php
require 'banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validacao = true;

    $requiredField = (object)[
        "nome" => "Por favor digite o seu nome!",
        "endereco" => "Por favor digite o seu endereço!",
        "telefone" => "Por favor digite o número do telefone!",
        "email" => "Por favor digite um endereço de email válido!",
        "sexo" => "Por favor selecione um campo!",
    ];

    if (!empty($_POST) && $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED)) {
        foreach ($requiredField as $field => $msgErro) {
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $$field = $_POST[$field];
                $erro[$field] = null;
                if ($field == 'email' && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $erro[$field] = 'Por favor digite um endereço de email válido!';
                    $validacao = false;
                }
            } else {
                $erro[$field] = $msgErro;
                $$field = null;
                $validacao = false;
            }
        }
        $erro = (object) $erro;
    }

    //Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO pessoa (nome, endereco, telefone, email, sexo) VALUES(?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $endereco, $telefone, $email, $sexo));
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Adicionar Contato</title>
</head>

<body>
<div class="container">
    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Contato </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group  <?= !empty($erro->nome) ? 'error' : ''; ?>">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="nome" type="text" placeholder="Nome"
                                   value="<?= !empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($erro->nome)): ?>
                                <span class="text-danger"><?= $erro->nome; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?= !empty($erro->endereco) ? 'error' : ''; ?>">
                        <label class="control-label">Endereço</label>
                        <div class="controls">
                            <input size="80" class="form-control" name="endereco" type="text" placeholder="Endereço"
                                   value="<?= !empty($endereco) ? $endereco : '' ?>">
                            <?php if (!empty($erro->endereco)): ?>
                                <span class="text-danger"><?= $erro->endereco; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?= !empty($erro->telefone) ? 'error' : ''; ?>">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input size="35" class="form-control" name="telefone" type="text" placeholder="Telefone"
                                   value="<?= !empty($telefone) ? $telefone : ''; ?>">
                            <?php if (!empty($erro->telefone)): ?>
                                <span class="text-danger"><?= $erro->telefone; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?= !empty($erro->email) ? 'erro' : ''; ?>">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="email" type="text" placeholder="Email"
                                   value="<?= !empty($email) ? $email : ''; ?>">
                            <?php if (!empty($erro->email)): ?>
                                <span class="text-danger"><?= $erro->email; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?= !empty($erro->sexo) ? 'erro' : ''; ?>">
                        <div class="controls">
                            <label class="control-label">Sexo</label>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo"
                                           value="M" <?= !empty($sexo) && $sexo == "M" ? "checked" : null; ?>/>
                                    Masculino</p>
                            </div>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" id="sexo" name="sexo" type="radio"
                                           value="F" <?= !empty($sexo) && $sexo == "F" ? "checked" : null; ?>/>
                                    Feminino</p>
                            </div>
                            <?php if (!empty($erro->sexo)): ?>
                                <span class="help-inline text-danger"><?= $erro->sexo; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>