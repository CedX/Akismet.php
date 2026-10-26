<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Performing the static analysis of source code...");
startProcess("composer", "exec -- phpstan analyse --configuration=Configuration/PHPStan.php --memory-limit=256M");
