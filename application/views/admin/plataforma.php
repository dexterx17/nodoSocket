<!DOCTYPE html>
<html>
<head>
	<title>Consola de Eventos</title>
	
	<script type="text/javascript" src="<?php echo site_url('bower_components/jquery/dist/jquery.js'); ?>"></script>
	<script src="<?php echo site_url('js'); ?>/fancywebsocket.js"></script>
	<script src="<?php echo site_url('js'); ?>/plataforma.js"></script>
	<link href="<?php echo site_url('bower_components/bootstrap/dist/css/bootstrap.css');?>" rel="stylesheet"></link>
</head>
<body>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center">Plataforma</h3>
			</div>
			<div class="panel-body" id="plataforma_div">
				
			</div>
			<div class="panel-footer">
				<?php print_r($plataforma); ?>
				<form class="sender4">
					<textarea rows="2" name="valor" id="valor4"  class="form-control">{"ok":"2","valorx":"24","valory":"35","teta":"22","q1":"34","q2":"35","q3":"23","q4":"23","ftang":"4","fnormal":"34"}</textarea>
					<button type="submit" value="Enviar" class="form-control">Enviar</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>