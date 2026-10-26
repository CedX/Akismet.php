<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Installing the dependencies...");
startProcess("composer", "install");
