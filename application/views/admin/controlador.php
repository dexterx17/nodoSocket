<!DOCTYPE html>
<html>
<head>
	<title>Consola de Eventos</title>
	
	<script type="text/javascript" src="<?php echo site_url('bower_components/jquery/dist/jquery.js'); ?>"></script>
	<script src="<?php echo site_url('js'); ?>/fancywebsocket.js"></script>
	<script src="<?php echo site_url('js'); ?>/controlador.js"></script>
	<link href="<?php echo site_url('bower_components/bootstrap/dist/css/bootstrap.css');?>" rel="stylesheet"></link>
</head>
<body>
	<div class="container">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title text-center">Controlador <small><?php echo microtime(true);?></small></h3>
			</div>
			<div class="panel-body" id="controlador_div">
				
			</div>
			<div class="panel-footer">
				<?php print_r($control); ?>
				<form class="sender">
					<textarea rows="2" name="valor" id="valor"  class="form-control">{"com":"4","valorx":"244","valory":"315","valorz":"22","errorx":"34","errory":"35","errorz":"23","control":"23"}</textarea>
					<button type="submit" value="Enviar" class="form-control">Enviar</button>
				</form>
				<form class="sender2">
					<textarea rows="2" name="valor" id="valor2"  class="form-control">{"com":"2","valorx":"24","valory":"35","valorz":"22","errorx":"34","errory":"35","errorz":"23","control":"23"}</textarea>
					<button type="submit" value="Enviar" class="form-control">Enviar</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>