<?php

declare(strict_types = 1);

namespace vzr;

class Metadata {
	public function __construct(): void { }
}

class File {
	public function __construct(
		public string $id,
		public string $path,
		public int $last_modified,
		public Metadata $metadata,
	): void { }
}

class Data {
	public function __construct(
		public string $path,
		public array $files,
	): void {
		$this->files = $this->read_dir($path);
	}
	// todo: implement a File class that has:
	//   a path
	//   a last modified date
	//   a metadata array constructed from YAML header
	// it should all be cached inside a cache file,
	// and be compared upon based of last modified date
	// when doing a new read_dir


	// todo: implement recursivity (sub folders and their files and folders)
	private function read_dir(string $path): array {
		$array = array();

		if ($dir = @opendir($this->dir)) {
			while ($dir && (false !== ($file = readdir($dir)))) {
				if ($file === "." or $file === "..") continue;
				$path = "{$dir}/{$file}";
				$last_modified = filemtime($file);
				$array[] = new File($file, $path, $last_modified);
			}
			closedir($dir);
		}

		arsort($array);
		return $array;
	}
}