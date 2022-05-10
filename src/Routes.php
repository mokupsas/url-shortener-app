<?php
declare(strict_types = 1);

return [
	['GET', '/', ['UrlShortener\Controllers\Homepage', 'show']],
	[['GET', 'POST'], '/signup', ['UrlShortener\Controllers\Signup', 'show']],
	[['GET', 'POST'], '/login', ['UrlShortener\Controllers\Login', 'show']],
];