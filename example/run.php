<?php

require_once __DIR__ . '/../vendor/autoload.php';

$result = [];

for ($z = 0; $z < 5000; $z++) {
    $result[] = 'Test';
}

$progress = new ProgressCli\Progress($result);

for ($i = 0; $i < count($result); $i++) {

    $progress->update($i);

}
