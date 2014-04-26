<?php if(LOGGEDIN): ?>
	<?php if(isset($this->games)): ?>
		<header class="page-header"><h1><span class="glyphicon glyphicon-th-large"></span> Gruppen</h1></header>
		<?php if(isset($this->error)): ?><div class="alert alert-danger"><?php $this->eprint($this->error) ?></div><?php endif; ?>

		<?php if(count($this->games) <= 0): ?>
			<div class="alert alert-info">
				<strong>Du bist leider noch in gar keiner Gruppe.</strong><br>
				Einladungen in eine Gruppe werden hier angezeigt und du kannst natürlich auch eigene erstellen.
			</div>
		<?php else: ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Gruppenname</th>
						<th>Spielleiter</th>
						<th>Mitspieler</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($this->games as $game): ?>
					<tr>
						<td><a href="index.php?c=6&amp;gid=<?php $this->eprint($game->getID()) ?>"><?php $this->eprint($game->getName()) ?></a></td>
						<td><?php $this->eprint($game->getMaster()->getName()) ?></td>
						<td><?php foreach($game->getUser() as $i => $usr): if($usr != $game->getMaster()): if($i>0): ?>, <?php endif; $this->eprint($usr->getName()); endif; endforeach; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<form action="index.php?c=6" method="post" class="form-inline" role="form">
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
						<input type="text" name="gname" class="form-control" placeholder="Gruppenname">
						<span class="input-group-btn">
							<button type="submit" name="newgame" class="btn btn-default" type="button">Neue Gruppe anlegen</button>
						</span>
					</div>
				</div>
			</div>
		</form>
	<?php elseif(isset($this->game)): ?>
		<header class="page-header"><h1><span class="glyphicon glyphicon-th-large"></span> <?php $this->eprint($this->game->getName()) ?> <small>Gruppe</small></h1></header>
		<?php if(isset($this->error)): ?><div class="alert alert-danger"><?php $this->eprint($this->error) ?></div><?php endif; ?>

		<div class="panel panel-default">
			<div class="panel-heading">Spielleiter</div>
			<div class="panel-body"><?php $this->eprint(($this->game->getMaster()->getUID() == LOGGEDIN) ? 'Du' : $this->game->getMaster()->getName()) ?></div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">Spieler</div>
			<table class="table">
				<thead>
					<tr>
						<th>Spielername</th>
						<th>Charakter</th>
						<?php if($this->game->getMaster()->getUID() == LOGGEDIN): ?><th>Optionen</th><?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($this->game->getUser() as $player): ?>
					<tr>
						<td><?php $this->eprint($player->getName()) ?></td>
						<td>
						<?php
							$chars = $player->getCharacter($this->game->getID());
							$char = null;
							if(count($chars) > 0) $char = $chars[0];
							if($char != null):
						?>
							<a href="index.php?c=8&amp;cid=<?php $this->eprint($char->getInfo(character::$infoid["ID"])) ?>">Charakter <?php $this->eprint(($player->getID() == LOGGEDIN) ? 'anzeigen' : 'bearbeiten') ?></a>
						<?php elseif($player->getID() == LOGGEDIN): ?>
							<a href="index.php?c=8&amp;gid=<?php $this->eprint($this->game->getID()) ?>">Charakter erstellen</a>
						<?php else: ?>
							Noch ohne Charakter
						<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">Notizen</div>
			<div class="panel-body">
			<?php if($this->game->getMaster()->getUID() == LOGGEDIN): ?>
				<form action="index.php?c=6&amp;gid=<?php $this->eprint($this->game->getID()) ?>" method="post" role="form">
					<textarea name="newnotes" style="height:200px;resize:vertical;" class="form-control"><?php $this->eprint($this->game->getNotes()) ?></textarea><br />
					<button type="submit" name="savenotes" class="btn btn-default">Speichern</button>
				</form>
			<?php else: ?>
				<?php $this->eprint($this->game->getNotes()) ?>
			<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>