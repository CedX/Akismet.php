<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Checking for outdated dependencies...");
startProcess("composer outdated");
