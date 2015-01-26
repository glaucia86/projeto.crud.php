<?php
    require 'banco.php';
    $id = null;
    if(!empty($_GET['id']))
    {
        $id = $_REQUEST['id'];
    }
    
    if(null==$id)
    {
        header("Location: index.php");
    }
    else 
    {
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM pessoa where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetch(PDO::FETCH_ASSOC);
       Banco::desconectar();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">           
            <div class="span10 offset1">
                <div class="row">
                    <h3 class="well"> Listar Contatos </h3>
                </div>
                
                <div class="form-horizontal">                   
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['nome'];?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Endereço</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['endereco'];?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['telefone'];?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['email'];?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Sexo</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['sexo'];?>
                            </label>
                        </div>
                    </div>
                    <br/>
                    <div class="form-actions">
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>

