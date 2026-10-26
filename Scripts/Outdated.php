<?php declare(strict_types=1);

echo "Checking for outdated dependencies...", PHP_EOL;
passthru("composer outdated");
