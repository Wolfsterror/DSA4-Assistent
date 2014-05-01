<header class="page-header"><h1><span class="icon-wand"></span> Neuen Benutzer registrieren</h1></header>

<?php if(isset($this->error)): ?><div class="alert alert-danger"><?php $this->eprint($this->error) ?></div><?php endif; ?>
<form action="index.php?c=4&amp;register" method="post" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="registerusr" class="col-sm-3 control-label">Benutzername:</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="register_usr" id="registerusr" placeholder="Benutzername">
			<span class="help-block">Darf nicht leer sein. Leerzeichen und Tabs am Anfang und am Ende werden herausgeschnitten.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="registerpwd" class="col-sm-3 control-label">Passwort:</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" name="register_pwd" id="registerpwd" placeholder="Passwort">
			<span class="help-block">Muss aus mind. 6 Zeichen bestehen.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="registerrepwd" class="col-sm-3 control-label">Passwort bestätigen:</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" name="register_repwd" id="registerrepwd" placeholder="Passwort bestätigen">
			<span class="help-block">Bestätige das Passwort damit wir prüfen können ob du es tatsächlich richtig eingegeben hast.</span>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-default"><span class="icon-wand"></span> Registrieren</button>
		</div>
	</div>
</form>