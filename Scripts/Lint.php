<?php declare(strict_types=1);

echo "Performing the static analysis of source code...", PHP_EOL;
passthru("composer exec -- phpstan analyse --configuration=Configuration/PHPStan.php --memory-limit=256M");
