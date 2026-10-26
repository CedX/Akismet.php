<?php declare(strict_types=1);

/**
 * Cleans the directory located at the specified path.
 * @param string $path The path of the directory to clean.
 */
function clearItem(string $path): void {
	if (!is_dir($path)) return;

	/** @var SplFileInfo $fileInfo */
	foreach (new FilesystemIterator($path) as $fileInfo)
		if ($fileInfo->getFilename() != ".gitkeep") removeItem($fileInfo->getPathname());
}

/**
 * Gets the project version number.
 * @return string The project version number.
 */
function getVersion(): string {
	static $version = (string) file_get_contents("composer.json") |> json_decode(...) |> (fn($pkg) => $pkg->version);
	return $version;
}

/**
 * Deletes the file system entry located at the specified path.
 * @param string $path The path of the file system entry to delete.
 * @return bool `true` if the file system entry has been deleted, otherwise `false`.
 */
function removeItem(string $path): bool {
	if (!file_exists($path)) return false;
	if (!is_dir($path)) return unlink($path);

	/** @var SplFileInfo $fileInfo */
	foreach (new FilesystemIterator($path) as $fileInfo) {
		if ($fileInfo->isDir()) removeItem($fileInfo->getPathname());
		else unlink($fileInfo->getPathname());
	}

	return rmdir($path);
}

/**
 * Invokes the specified command.
 * @param string $command The command to invoke.
 */
function startProcess(string $command): void {
	passthru($command, $exitCode);
	if ($exitCode) exit($exitCode);
}

/**
 * Prints the specified message to the standard output.
 * @param string $message The message to print.
 */
function writeOutput(string $message): void {
	echo $message, PHP_EOL;
}
