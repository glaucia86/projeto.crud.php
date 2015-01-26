<?php 
	
	require 'banco.php';

	$id = null;
	if ( !empty($_GET['id'])) 
            {
		$id = $_REQUEST['id'];
            }
	
	if ( null==$id ) 
            {
		header("Location: index.php");
            }
	
	if ( !empty($_POST)) 
            {
		
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
		
		//Validação
		$validacao = true;
		if (empty($nome)) 
                {
                    $nomeErro = 'Por favor digite o nome!';
                    $validacao = false;
                }
		
		if (empty($email)) 
                {
                    $emailErro = 'Por favor digite o email!';
                    $validacao = false;
		} 
                else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
                {
                    $emailErro = 'Por favor digite um email válido!';
                    $validacao = false;
		}
		
		if (empty($endereco)) 
                {
                    $endereco = 'Por favor digite o endereço!';
                    $validacao = false;
		}
                
                if (empty($telefone)) 
                {
                    $telefone = 'Por favor digite o telefone!';
                    $validacao = false;
		}
                
                if (empty($endereco)) 
                {
                    $endereco = 'Por favor preenche o campo!';
                    $validacao = false;
		}
		
		// update data
		if ($validacao) 
                {
                    $pdo = Banco::conectar();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE pessoa  set nome = ?, endereco = ?, telefone = ?, email = ?, sexo = ? WHERE id = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($nome,$endereco,$telefone,$email,$sexo,$id));
                    Banco::desconectar();
                    header("Location: index.php");
		}
	} 
        else 
            {
                $pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pessoa where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$nome = $data['nome'];
                $endereco = $data['endereco'];
                $telefone = $data['telefone'];
		$email = $data['email'];
		$sexo = $data['sexo'];
		Banco::desconectar();
	}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3 class="well"> Atualizar Contato </h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                        
                      <div class="control-group <?php echo !empty($nomeErro)?'error':'';?>">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <input name="nome" size="50" type="text"  placeholder="Nome" value="<?php echo !empty($nome)?$nome:'';?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="help-inline"><?php echo $nomeErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                       <div class="control-group <?php echo !empty($enderecoErro)?'error':'';?>">
                        <label class="control-label">Endereço</label>
                        <div class="controls">
                            <input name="endereco" size="80" type="text"  placeholder="Endereço" value="<?php echo !empty($endereco)?$endereco:'';?>">
                            <?php if (!empty($enderecoErro)): ?>
                                <span class="help-inline"><?php echo $enderecoErro;?></span>
                            <?php endif; ?>
                        </div>
                       </div>
                        
                       <div class="control-group <?php echo !empty($telefoneErro)?'error':'';?>">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input name="telefone" size="30" type="text"  placeholder="Telefone" value="<?php echo !empty($telefone)?$telefone:'';?>">
                            <?php if (!empty($telefoneErro)): ?>
                                <span class="help-inline"><?php echo $telefoneErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                        <div class="control-group <?php echo !empty($email)?'error':'';?>">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input name="email" size="40" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="help-inline"><?php echo $emailErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                        <div class="control-group <?php echo !empty($sexoErro)?'error':'';?>">
                        <label class="control-label">Sexo</label>
                        <div class="controls">
                            <input name="sexo" size="1" type="text"  placeholder="Sexo" value="<?php echo !empty($sexo)?$sexo:'';?>">
                            <?php if (!empty($sexoErro)): ?>
                                <span class="help-inline"><?php echo $sexoErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                        <br/>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Atualizar</button>
                          <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>                 
    </div> 
  </body>
</html>

