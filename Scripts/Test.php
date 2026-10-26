<?php declare(strict_types=1);

echo "Running the test suite...", PHP_EOL;
passthru("composer exec -- phpunit --configuration=Configuration/PHPUnit.xml");
