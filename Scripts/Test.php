<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Running the test suite...");
startProcess("composer", "exec -- phpunit --configuration=Configuration/PHPUnit.xml");
