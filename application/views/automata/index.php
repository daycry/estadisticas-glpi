<html>
<head>
<title>Automata</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src='<?php echo base_url_static_f();?>js/jquery-ui-timepicker-addon.js'></script>
<script src='<?php echo base_url_static_f();?>bootstrap/js/bootstrap.js'></script>
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap.css' rel="stylesheet">
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap-responsive.css' rel="stylesheet">
<script src='<?php echo base_url_static_f();?>js/jquery.tablesorter.min.js'></script>
<link href='<?php echo base_url_static_f();?>css/personal.css' rel="stylesheet">
<script src='<?php echo base_url_static_f();?>js/funciones.js'></script>

</head>
<body>
	
<div class="container">	
	
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<center><h1 face="verdana"><?php echo $titulo; ?></h1></center>
			</div>
		</div>
		<div class="span12">
			<div class="row-fluid">
				&nbsp;
			</div>
		</div>
		
		<div class="span12">
			<?php if ( validation_errors() ){ ?>
						<div class="alert">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Errors!</strong><?php echo validation_errors(); ?>
						</div>
			<?php } ?>
		</div>
		
		
		<?php echo form_open('automata/buscar'); ?>
		<div class="span12">
			<div class="row-fluid">
				<div class="span4">
					Fecha inicio: <input type="text" class="datepicker" id="datepicker1" name="datepicker1" maxlength="10" value="<?php echo set_value('datepicker1'); ?>"/>
				</div>
				<div class="span4">
					<button type="submit" class="btn btn-primary btn-sm">Buscar</button>
				</div>
			</div>
		 </div>
		 </form>
	</div>

</div>	



<?php

if ( set_value('datepicker1') ){
	echo"<br>";
	echo "Se han actualizado los grupos de : " .$contador." tickets";
}

?>

</body>
</html>
