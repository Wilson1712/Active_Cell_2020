<?php

$product = OperationData::getAllByProductId($_GET["id"]);

foreach ($product as $op) {
	$op->del();
}

$product = ProductData::getById($_GET["id"]);
$product->del();

Core::redir("./index.php?view=products");
?>