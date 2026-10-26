<?php declare(strict_types=1);
require_once "Tools.php";

echo "Deleting all generated files...", PHP_EOL;
cleanDirectory("Temp");
