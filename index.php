<?php

$config = include 'config/main.php';

require 'core/AutoLoad.php';

(new core\Application($config))->run();