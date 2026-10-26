<?php declare(strict_types=1);
require_once "Tools.php";

echo "Publishing the package...", PHP_EOL;
$version = getVersion();
passthru("git tag v$version");
passthru("git push origin v$version");
