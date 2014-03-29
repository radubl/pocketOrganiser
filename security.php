<?php

function prevent_XSS($string){

	return strip_tags(htmlspecialchars($string));

}

?>