<?php
declare(strict_types = 1);

namespace UrlShortener\Account;

class StatusCodes
{
	// Sign Up
    public const SIGNUP_SUCCESS = 100;
    public const SIGNUP_ERROR = 101;
    public const SIGNUP_NOT_SUBMITTED = 102;
	public const SIGNUP_INPUT_EMPTY = 103;
	public const SIGNUP_BAD_EMAIL = 104;
	public const SIGNUP_EMAIL_IN_USE = 105;
	public const SIGNUP_PASS_LENGTH = 106;
	public const SIGNUP_IP_LIMIT = 107;
}