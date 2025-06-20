<?php

namespace SmartSelect\Traits;

use SmartSelect\Scopes\DefaultSelectScope;

trait HasDefaultSelect
{
	public static function bootHasDefaultSelect()
	{
		static::addGlobalScope(new DefaultSelectScope());
	}
}
