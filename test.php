<?php
require_once './php/userLogic.php';
require_once './php/postLogic.php';

$result = PostLogic::deletePost(16);

var_dump($result);


?>