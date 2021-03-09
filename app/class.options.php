<?php

declare(strict_types = 1);

namespace vzr;

interface Opts {
	public function method(array $array): iterable;
}

class Options implements Opts {
	public function __construct(
		public string $data_path = "{__DIR__}/data",
	) {	}

	public function method(iterable $iterable): array { }
}