<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Updating the dependencies...");
startProcess("composer update");
