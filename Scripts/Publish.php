<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

$version = getVersion();
writeOutput("Publishing the package...");
startProcess("git", "tag v$version");
startProcess("git", "push origin v$version");
