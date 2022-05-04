<?php
declare(strict_types = 1);

interface iDatabase
{
	public function __construct($host, $username, $password, $dbname);
	public function get();
}