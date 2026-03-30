# Smart select

## Install

- `composer require perrotin/smart-select`
- `php artisan vendor:publish --provider="SmartSelect\Providers\SmartSelectServiceProvider"`
- Add the following vars in your `.env` : 
```env
# This is the root user that will perform the permission granting queries
DB_CONNECTION_SMART_SELECT=mysql
DB_HOST_SMART_SELECT=mysql
DB_PORT_SMART_SELECT=3306
DB_DATABASE_SMART_SELECT=dbname
DB_USERNAME_SMART_SELECT=root
DB_PASSWORD_SMART_SELECT=
DB_PREFIX_SMART_SELECT=""
```
- Update the `config/smart-select.php` with the db user that will be granted your configured permissions OR add the following to your `.env` :
```env
SMART_SELECT_DIRECTORY= # Optional
SMART_SELECT_FILENAME= # Optional
SMART_SELECT_DB_USER= # Mandatory
SMART_SELECT_DB_BASE= # Mandatory
SMART_SELECT_DB_IP= # Optional
```

Manually create your permission-restricted user on your mysql database then run :
`php artisan smart-select:grant`

## How to use

### Set up the package

In every model you want, you must :

- Use the `HasDefaultSelect` trait
- Implement the `HasDefaultSelectColumns` interface
- Define `getGrantColumns()` method.

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

### Commands
- `php artisan smart-select:export` -> Will generate a `yaml` file representing your configured permissions for other purposes
- `php artisan smart-select:grant` -> Will run queries to grant the specified permissions to your configured user

## Contributing

If you wish to contribute, a good way is to update the repository and replace it with :
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

## TODO

- [ ] Testing
- [ ] Config option to execute grant access depending of environment
- [ ] Create user if it does not exist with the `smart-select:grant` command
