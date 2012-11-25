<?php

if( !isset( $_GET["c"] ) ) {
	$_GET["c"] = 0;
}


switch( $_GET["c"] ) {
	
	default:
		echo '
			<header><h1><span aria-hidden="true" class="icon-home"></span> Startseite</h1></header>
			<article>
				<!-- TODO: Text! -->
			</article>';
		break;
	case 1:
		echo '
			<header><h1><span aria-hidden="true" class="icon-user"></span> User</h1></header>
			<article>
				<!-- TODO: Text! -->
			</article>';
		break;

}