#!/usr/bin/php
<?php
if (!extension_loaded('mysqli')) {
	echo("NO MYSQLI!");
}
else {
	echo("mysqli ok");
}
?>