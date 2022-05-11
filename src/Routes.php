<?php
declare(strict_types = 1);

return [
	['GET', '/', ['UrlShortener\Controllers\Homepage', 'show']],
	
	// Auth routes
	[['GET', 'POST'], '/signup', ['UrlShortener\Controllers\Signup', 'show']],
	[['GET', 'POST'], '/login', ['UrlShortener\Controllers\Login', 'show']],
	['GET', '/logout', ['UrlShortener\Controllers\Logout', 'show']],
	
	// Other
	['GET', '/404', ['UrlShortener\Controllers\PageNotFound', 'show']],
];