<header class="page-header"><h1><span class="glyphicon glyphicon-log-in"></span> Einloggen</h1></header>

<?php if(isset($this->success)): ?><div class="alert alert-success"><?php $this->eprint($this->success) ?></div><?php endif; ?>
<?php if(isset($this->error)): ?><div class="alert alert-danger"><?php $this->eprint($this->error) ?></div><?php endif; ?>

<form action="index.php?c=3&amp;login" method="post" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="loginuser" class="col-sm-2 control-label">Benutzername:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="login_usr" id="loginuser" placeholder="Benutzername">
		</div>
	</div>
	<div class="form-group">
		<label for="loginpwd" class="col-sm-2 control-label">Passwort:</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" name="login_pwd" id="loginpwd" placeholder="Passwort">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span> Einloggen</button>
		</div>
	</div>
</form>