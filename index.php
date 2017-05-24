<?php

$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
	sprint_f($_GET);
file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
