<?php declare(strict_types=1);
require_once __DIR__."/Tools.php";

writeOutput("Publishing the package...");
$version = getVersion();
startProcess("git", "tag v$version");
startProcess("git", "push origin v$version");
