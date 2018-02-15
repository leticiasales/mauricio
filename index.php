<?php

$alert = '';

$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
    die('Erro de conexão: ' . mysql_error());
}

// Attempt create database query execution
$sql = "CREATE DATABASE IF NOT EXISTS demo";
if(!mysql_query($sql)){
    echo "ERROR: Could not able to execute $sql. " . mysql_error($link);
    return;
}

$db_selected = mysql_select_db('demo', $link);
if (!$db_selected) {
    die ('Can\'t use demo : ' . mysql_error());
}

$sql = "CREATE TABLE IF NOT EXISTS `pacientes` (
  `entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `identidade` varchar(10) NOT NULL,
  `orgao_emissor` varchar(5),
  `cidade` varchar(30) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  PRIMARY KEY (`entity_id`)
);";

if(!mysql_query($sql)){
    echo "ERROR: Could not able to execute $sql. " . mysql_error($link);
    return;
}

$sql = "CREATE TABLE IF NOT EXISTS `receituarios` (
  `entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente` int(11) NOT NULL,
  `prescricao` varchar(255) NOT NULL,
  PRIMARY KEY (`entity_id`)
);";

if(!mysql_query($sql)){
    echo "ERROR: Could not able to execute $sql. " . mysql_error($link);
    return;
}

$active = 'class="active"';

// Close connection
// mysqli_close($link);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['save_paciente']))
	{
		if(isset($_POST["nome"]) && isset($_POST["identidade"]) && isset($_POST["orgao_emissor"]) && isset($_POST["cidade"]) && isset($_POST["uf"]) && isset($_POST["telefone"]))
		{
		    $sql = "INSERT INTO pacientes (nome, identidade, orgao_emissor, cidade, uf, telefone)
		    VALUES ('".$_POST["nome"]."','".$_POST["identidade"]."','".$_POST["orgao_emissor"]."','".$_POST["cidade"]."','".$_POST["uf"]."','".$_POST["telefone"]."')";
		    if (mysql_query($sql)) {
		    	$alert = "<div class=\"alert alert-success\" role=\"alert\">Paciente salvo com sucesso.</div>";
		    } else {
		    	$alert = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao cadastrar paciente.</div>";
		    }
	    } else {
	    	$alert = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao cadastrar paciente.</div>";
	    }
	}
	else if(isset($_POST['save_receituario']))
	{
		if(isset($_POST['paciente']) && isset($_POST['prescricao'])) {
		    $sql = "INSERT INTO receituarios (paciente, prescricao)
		    VALUES ('".$_POST['paciente']."','".$_POST['prescricao']."')";
		    if (mysql_query($sql)) {
		    	$alert = "<div class=\"alert alert-success\" role=\"alert\">Receituário salvo com sucesso.</div>";
		    } else {
		    	$alert = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao cadastrar receituário.</div>";
	    	}
    	} else {
	    	$alert = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao cadastrar receituário.</div>";
    	}
	}
}

?>

<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	<title>Programa</title>
</head>
<body>
	<nav class="navbar-default navbar-fixed-top">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <a class="navbar-brand" href="/">Departamento Municipal de Saúde</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li id="home" class="active"><a href="/">Home</a></li>
	        <li id="pacientes"><a href="#">Pacientes</a></li>
	        <li id="receituarios"><a href="#">Receituarios</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mais opções <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li id="novopaciente"><a>Novo Paciente</a></li>
	            <li id="novoreceituario"><a>Novo Receituário</a></li>
	            <!-- <li role="separator" class="divider"></li> -->
	          </ul>
	        </li>
	      </ul>
<!-- 	      <form class="navbar-form navbar-right" method="POST">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Insira aqui sua busca">
	        </div>
	        <button type="submit" class="btn btn-default">Buscar</button>
	      </form> -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="tab home">
		<?php echo $alert; ?>
		<div class="jumbotron">
		  <h1>Bem vindo!</h1>
		  <p>Nesta página você pode adicionar e buscar pacientes e receituários.
		  Utilize o menu acima para estas ações.</p>
		  <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->
		</div>
	</div>
	<div class="tab novopaciente" style="display: none;">
	    <div class="container">
		    <div class="col-md-12">
		        <div class="form-area">  
		            <form role="form" method="POST">
		            <br style="clear:both">
		                        <h3 style="margin-bottom: 25px; text-align: center;">Novo Paciente</h3>
		        				<div class="form-group col-md-12">
		        					<label for="nome">Nome</label>
		    						<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Completo" required>
		    					</div>
		    					<div class="form-group col-md-10">
		        					<label for="nome">Identidade</label>
		    						<input type="text" class="form-control" id="identidade" name="identidade" placeholder="0.000.000-0" required>
		    					</div>
		    					<div class="form-group col-md-2">
		        					<label for="nome">Orgão Emissor</label>
		    						<input type="text" class="form-control" id="orgao_emissor" name="orgao_emissor" placeholder="AAA" required>
		    					</div>
		    					<div class="form-group col-md-12">
		        					<label for="nome">Endereço</label>
		    						<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua XXX, 00" required>
		    					</div>
		    					<div class="form-group col-md-10">
		        					<label for="nome">Cidade</label>
		    						<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
		    					</div>
		    					<div class="form-group col-md-2">
		        					<label for="nome">UF</label>
		    						<select type="text" class="form-control" id="uf" name="uf" required>
			    						<option value="AC">AC</option>
										<option value="AL">AL</option>
										<option value="AM">AM</option>
										<option value="AP">AP</option>
										<option value="BA">BA</option>
										<option value="CE">CE</option>
										<option value="DF">DF</option>
										<option value="ES">ES</option>
										<option value="GO">GO</option>
										<option value="MA">MA</option>
										<option value="MG">MG</option>
										<option value="MS">MS</option>
										<option value="MT">MT</option>
										<option value="PA">PA</option>
										<option value="PB">PB</option>
										<option value="PE">PE</option>
										<option value="PI">PI</option>
										<option value="PR">PR</option>
										<option value="RJ">RJ</option>
										<option value="RN">RN</option>
										<option value="RO">RO</option>
										<option value="RR">RR</option>
										<option value="RS">RS</option>
										<option value="SC">SC</option>
										<option value="SE">SE</option>
										<option value="SP">SP</option>
										<option value="TO">TO</option>
									</select>
		    					</div>
		    					<div class="form-group col-md-12">
		        					<label for="nome">Telefone</label>
		    						<input type="phone" class="form-control" id="telefone" name="telefone" placeholder="(00) 0000-0000" required>
		    					</div>
		                
		            			<button type="submit" id="save_paciente" name="save_paciente" class="btn btn-primary pull-right">Adicionar</button>
		            </form>
		        </div>
		    </div>
	    </div>
	</div>
	<div class="tab novoreceituario" style="display: none;">
	    <div class="container">
		    <div class="col-md-12">
		        <div class="form-area">  
		            <form role="form" method="POST">
		            <br style="clear:both">
		                        <h3 style="margin-bottom: 25px; text-align: center;">Novo Receituário</h3>
		        				<div class="form-group col-md-12">
		        					<label for="nome">Paciente</label>
		    						<select type="text" class="form-control" id="paciente" name="paciente" placeholder="Paciente" required>
		    							<option>Selecione um Paciente</option>
		    							<?php
			    							$sql = "SELECT entity_id, nome FROM pacientes"; 
											$pacientes = mysql_query($sql);
											if (mysql_num_rows($pacientes) > 0) {
											    while ($row = mysql_fetch_assoc($pacientes)) {
											    echo '<option value="' . $row['entity_id'] . '">' . $row['nome'] . '</option>';
												}
											}
										?>
		    						</select>
		    					</div>
		    					<div class="form-group col-md-12">
		        					<label for="prescricao">Prescrição</label>
								    <textarea type="text" class="form-control" id="prescricao" name="prescricao" rows="6"></textarea>
		    					</div>
		            			<button type="submit" id="save_receituario" name="save_receituario" class="btn btn-primary pull-right">Adicionar</button>
		            </form>
		        </div>
		    </div>
	    </div>
	</div>
	<div class="tab pacientes" style="display: none;">
	    <div class="container">
		    <div class="col-md-12">
		        <div class="form-area">  
		        	<?php
		        		$sql = "SELECT * FROM pacientes";
						$result = mysql_query($sql);
						if (mysql_num_rows($result) > 0) {
						    while ($row = mysql_fetch_assoc($result)) {
							    echo "<li>Nome: " . $row['nome'] . " Telefone: " . $row['telefone'] . "</li>";
							}
						} else {
						    echo "<p>Nenhum paciente cadastrado.</p>";
						}
					?>
		        </div>
		    </div>
	    </div>
	</div>
	<div class="tab receituarios" style="display: none;">
	    <div class="container">
		    <div class="col-md-12">
		        <ul class="list">  
		        	<?php
		        		$sql = "SELECT * FROM receituarios rec JOIN pacientes pac WHERE rec.paciente = pac.entity_id";
						$result = mysql_query($sql);
						if (mysql_num_rows($result) > 0) {
						    while ($row = mysql_fetch_assoc($result)) {
							    echo "<li>Paciente:" . $row['nome'] . " Prescrição:" . $row['prescricao'] . "</li>";
							}
						} else {
						    echo "<p>Nenhum receituario cadastrado.</p>";
						}
					?>
		        </ul>
		    </div>
	    </div>
	</div>
</body>
</html>

<script type="text/javascript">
	$('nav li').on('click', function f(e) {
		if ($(this).hasClass('dropdown')) return;
		e.preventDefault();
		$('nav li').removeClass('active');
		$('.tab').hide();
		$(this).addClass('active');
		var id = '.' + this.id;
		$(id).show();
	})
</script>

<style type="text/css">
	.tab {
		margin: 100px 50px;
	}
</style>