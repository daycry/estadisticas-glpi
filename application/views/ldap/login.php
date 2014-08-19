<html>
<head>
<title>Registro</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src='<?php echo base_url_static_f();?>js/jquery-ui-timepicker-addon.js'></script>
<script src='<?php echo base_url_static_f();?>bootstrap/js/bootstrap.js'></script>
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap.css' rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url_static_f();?>bootstrap/css/bootstrap-theme.min.css">
<script src='<?php echo base_url_static_f();?>js/funciones.js'></script>

</head>
<body>

    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					<img src="<?php echo base_url_static_f();?>images/logo.png" />
				</div>
				<div class="col-md-offset-1 col-md-6">
					<h1 face="verdana">ESTADÍSTIQUES</h1>
				</div>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="row">	
			<fieldset>
				<legend>Inicia sessió</legend>
				<?php
				$attributes = array('class' => 'form-horizontal','role' => 'form');
				echo form_open('ldap/doLogin', $attributes);
				?>
				  <div class="row">
					<label for="username" class="col-md-2 control-label">Usuari:</label>
					<div class="col-md-6">
					  <input type="text" class="form-control" id="username" name="username" placeholder="Usuari" value="<?php echo set_value('username'); ?>">
					</div>
				  </div>
				  <div class="row">&nbsp;</div>
				  <div class="row">
					<label for="password" class="col-md-2 control-label">Password</label>
					<div class="col-md-6">
					  <input type="password" class="form-control" id="password" name="password" placeholder="Contrasenya">
					</div>
				  </div>
				  <div class="row">&nbsp;</div>
				  <div class="row">
					<div class="col-md-offset-2 col-md-8">
					  <button type="submit" class="btn btn-primary">Accedir</button>
					</div>
				  </div>
				</form>
			</fieldset>
		</div>
		<div class="row">
			<div class="col-md-offset-3 col-md-6">

				<?php if ( validation_errors() ){ ?>
					<div class="alert alert-warning" role="alert">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Errors!</strong><?php echo validation_errors(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
				
    </div> <!-- /container -->

</body>
</html>
