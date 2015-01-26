<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <div class="container">
            <div clas="span10 offset1">
                <div class="row">
                    <h3 class="well"> Adicionar Contato </h3>
                    <form class="form-horizontal" action="create.php" method="post">
                        
                        <div class="control-group <?php echo !empty($nomeErro)?'error ' : '';?>">
                            <label class="control-label">Nome</label>
                            <div class="controls">
                                <input size= "50" name="nome" type="text" placeholder="Nome" required="" value="<?php echo !empty($nome)?$nome: '';?>">
                                <?php if(!empty($nomeErro)): ?>
                                    <span class="help-inline"><?php echo $nomeErro;?></span>
                                <?php endif;?>
                            </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($enderecoErro)?'error ': '';?>">
                            <label class="control-label">Endereço</label>
                            <div class="controls">
                                <input size="80" name="endereco" type="text" placeholder="Endereço" required="" value="<?php echo !empty($endereco)?$endereco: '';?>">
                                <?php if(!empty($emailErro)): ?>
                                <span class="help-inline"><?php echo $enderecoErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($telefoneErro)?'error ': '';?>">
                            <label class="control-label">Telefone</label>
                            <div class="controls">
                                <input size="35" name="telefone" type="text" placeholder="Telefone" required="" value="<?php echo !empty($telefone)?$telefone: '';?>">
                                <?php if(!empty($emailErro)): ?>
                                <span class="help-inline"><?php echo $telefoneErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($emailErro)?'error ': '';?>">
                            <label class="control-label">Email</label>
                            <div class="controls">
                                <input size="40" name="email" type="text" placeholder="Email" required="" value="<?php echo !empty($email)?$email: '';?>">
                                <?php if(!empty($emailErro)): ?>
                                <span class="help-inline"><?php echo $emailErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($sexoErro)?'error ': '';?>">
                            <label class="control-label" >Sexo</label>
                            <div class="controls">
                                <input size="1" name="sexo" type="text" placeholder="Sexo" required="" value="<?php echo !empty($sexo)?$sexo: '';?>">
                                <?php if(!empty($sexoErro)): ?>
                                <span class="help-inline"><?php echo $sexoErro;?></span>
                                <?php endif;?>
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
    </body>
</html>


<?php
    require 'banco.php';
    
    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $nomeErro = null;
        $enderecoErro = null;
        $telefoneErro = null;
        $emailErro = null;
        $sexoErro = null;
        
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $sexo = $_POST['sexo'];
        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($nome))
        {
            $nomeErro = 'Por favor digite o seu nome!';
            $validacao = false;
        }
        
        if(empty($endereco))
        {
            $enderecoErro = 'Por favor digite o seu endereço!';
            $validacao = false;
        }
        
        if(empty($telefone))
        {
            $telefoneErro = 'Por favor digite o número do telefone!';
            $validacao = false;
        }
        
        if(empty($email))
        {
            $telefoneErro = 'Por favor digite o endereço de email';
            $validacao = false;
        }
        elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) 
        {
            $emailError = 'Por favor digite um endereço de email válido!';
            $validacao = false;
        }
        
        if(empty($sexo))
        {
            $sexoErro = 'Por favor digite o campo!';
            $validacao = false;
        }
        
        //Inserindo no Banco:
        if($validacao)
        {
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO pessoa (nome, endereco, telefone, email, sexo) VALUES(?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome,$endereco,$telefone,$email,$sexo));
            Banco::desconectar();
            header("Location: index.php");
        }
    }
?>
