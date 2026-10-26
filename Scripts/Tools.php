<?php declare(strict_types=1);

/**
 * Cleans the directory located at the specified path.
 * @param string $path The path of the directory to clean.
 */
function cleanDirectory(string $path): void {
	if (!is_dir($path)) return;

	/** @var SplFileInfo $fileInfo */
	foreach (new FilesystemIterator($path) as $fileInfo)
		if ($fileInfo->getFilename() != ".gitkeep") deleteFileSystemEntry($fileInfo->getPathname());
}

/**
 * Deletes the file system entry located at the specified path.
 * @param string $path The path of the file system entry to delete.
 * @return bool `true` if the file system entry has been deleted, otherwise `false`.
 */
function deleteFileSystemEntry(string $path): bool {
	if (!file_exists($path)) return false;
	if (!is_dir($path)) return unlink($path);

	/** @var SplFileInfo $fileInfo */
	foreach (new FilesystemIterator($path) as $fileInfo) {
		if ($fileInfo->isDir()) deleteFileSystemEntry($fileInfo->getPathname());
		else unlink($fileInfo->getPathname());
	}

	return rmdir($path);
}

/**
 * Gets the project version number.
 * @return string The project version number.
 */
function getVersion(): string {
	return (string) file_get_contents("composer.json") |> json_decode(...) |> (fn($pkg) => $pkg->version);
}
