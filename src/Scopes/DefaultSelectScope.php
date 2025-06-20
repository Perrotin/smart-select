<?php

namespace SmartSelect\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use SmartSelect\Contracts\HasDefaultSelectColumns;

class DefaultSelectScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		if ($model instanceof HasDefaultSelectColumns) {
			$columns = $model->getGrantColumns();
			if (!empty($columns['select'])) {
				$builder->select($columns['select']);
			}
		}
	}
}
