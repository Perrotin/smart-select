# Smart select

## Install

Install the package

`composer require perrotin/smart-select`

followed by

`php artisan vendor:publish --provider="SmartSelect\Providers\SmartSelectServiceProvider"`

### for developement

If you wish to update the package, a good way is to update the repository and replace it with

```json
"repositories": [
    {
        "type": "path",
        "url": "./packages-folder/smartselect",
        "options": {
            "symlink": true
        }
    }
],
```

## How to use

### Set up the package

In every model you want, you must :

- use the `HasDefaultSelect` trait
- use the `HasDefaultSelectColumns` interface
- set the `getGrantColumns()`method.

For example

```php

namespace App\Models;

use SmartSelect\Contracts\HasDefaultSelectColumns;
use SmartSelect\Traits\HasDefaultSelect;

class User extends Model implements HasDefaultSelectColumns
{

	use HasDefaultSelect;

	protected $table = 'users';

	public function getGrantColumns(): array
    {
        return [
			'select' => ['id','name','created_at','updated_at'],
            'insert' => ['email', 'name'] // $this->fillable
		];
    }
}
```

### Configure it

### use commands

## TODO

- [ ] Testing
- [ ] Config option to execute grant access depending of environment
- [ ] ...
