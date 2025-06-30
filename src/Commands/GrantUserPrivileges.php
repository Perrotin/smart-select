<?php

namespace SmartSelect\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SmartSelect\Helpers\DatabaseStructureHelper;

class GrantUserPrivileges extends Command
{
	protected $signature = "smart-select:grant";

	public function handle(): void
	{
		// get data of all tables and grants.

		$data = DatabaseStructureHelper::all();

		if (empty($data)) {
			$this->warn('No models found that implement the HasDefaultSelectColumns interface.');

			return;
		}

		$config_user = config('smart-select.db.user');
		$config_base = config('smart-select.db.base');
		$config_ip = config('smart-select.db.ip');

		$output = [];

		// create the sql query
		foreach ($data as $table => $types) {
			$output_row = [
				'table' => $table,
				'revoke' => false,
				'select' => false,
				'insert' => false,
				'update' => false,
				'delete' => false,
			];

			try {
				$sql = "REVOKE ALL PRIVILEGES ON `{$config_base}`.`{$table}` FROM '{$config_user}'@'{$config_ip}';";
				DB::connection('smart-select')->unprepared($sql);
				$output_row['revoke'] = true;
			} catch (\Throwable $th) {
				// throw $th;
			}

			foreach ($types as $type => $columns) {
				if (in_array(strtoupper($type), config('smart-select.db.allowed_actions'))) {
					$grant_type = strtoupper($type);
					$this->info("type {$grant_type}");
					if ('DELETE' === $grant_type) {
						$sql = "GRANT DELETE ON {$config_base}.{$table} TO '{$config_user}'@'{$config_ip}';";
					} else {
						$cols = implode(',', $columns);
						$sql = "GRANT {$grant_type} ({$cols}) ON {$config_base}.{$table} TO '{$config_user}'@'{$config_ip}';";
					}

					DB::connection('smart-select')->unprepared($sql);

					$output_row[$type] = true;
				} else {
					$this->warn("This grant action {$type} is not allowed");
				}
			}

			$output[] = $output_row;
		}

		$this->table(['table', 'revoke', 'select', 'insert', 'update', 'delete'], $output);
	}
}
