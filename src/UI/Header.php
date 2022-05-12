<?php
declare(strict_types = 1);

namespace UrlShortener\UI;

use UrlShortener\Account\User;

class Header
{
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	//-------------------------------------
	/** Returns header HTML
	@return string */
	//-------------------------------------		
	public function get()
	{
		return '
			<header class="shadow-sm p-3 bg-white rounded">

				<nav class="navbar navbar-expand-lg navbar-light">
					<div class="container">
						<a class="navbar-brand" href="#">UrlShortener</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" toggle="collapse" data-target="#navbarSupportedContent">
							<span class="navbar-toggler-icon"></span>
						</button>
						
						
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							'. $this->leftNavigationBar() .'
							'. $this->rightNavigationBar() .'
						</div>
					</div>
				</nav>
				
			</header>
		';
	}
	
	private function leftNavigationBar()
	{
		return '
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://github.com/mokupsas/url-shortener-website">Support</a>
				</li>
			</ul>	
		';
	}
	
	private function rightNavigationBar()
	{
		if($this->user->isLoggedIn())
		{
			return '
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						  <a class="dropdown-item" href="/settings">Settings</a>
						  <a class="dropdown-item" href="/logout">Logout</a>
						</div>
					</li>
				</ul>
			';
		}
		
		return '
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link btn btn-outline-warning text-warning" href="/signup">Sign up</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/login">Login</a>
				</li>
			</ul>		
		';
	}
	
}