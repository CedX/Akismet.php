<?php declare(strict_types=1);

/**
 * Cleans the directory located at the specified path.
 * @param string $path The path of the directory to clean.
 */
function clearItem(string $path): void {
	/** @var SplFileInfo $entry */
	foreach (new FilesystemIterator($path) as $entry)
		if ($entry->getFilename() != ".gitkeep") removeItem($entry->getPathname());
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
	if (!is_dir($path)) return unlink($path);

	/** @var SplFileInfo $entry */
	foreach (new FilesystemIterator($path) as $entry) {
		if ($entry->isDir()) removeItem($entry->getPathname());
		else unlink($entry->getPathname());
	}

	return rmdir($path);
}

/**
 * Invokes the specified command.
 * @param string $command The command to invoke.
 * @param string $arguments The command arguments.
 */
function startProcess(string $command, string $arguments = ""): void {
	$commandLine = mb_rtrim("$command $arguments");
	passthru($commandLine, $exitCode);
	if ($exitCode) writeError("Command failed: $commandLine");
}

/**
 * Prints the specified message to the standard error and terminates the process.
 * @param string $message The message to print.
 */
function writeError(string $message): never {
	fwrite(STDERR, $message . PHP_EOL);
	exit(1);
}

/**
 * Prints the specified message to the standard output.
 * @param string $message The message to print.
 */
function writeOutput(string $message): void {
	fwrite(STDOUT, $message . PHP_EOL);
}
