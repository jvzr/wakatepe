<?php

declare(strict_types = 1);

namespace vzr;

function print_arr(iterable $array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}