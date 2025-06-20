<?php

namespace SmartSelect\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SmartSelect\Helpers\DatabaseStructureHelper;
use Symfony\Component\Yaml\Yaml;

class ExportDefaultSelectColumns extends Command
{
	private const FOLDER = 'smart-select';

	protected $signature = "smart-select:export";

	public function handle(): void
	{
		$this->info('Scanning for models that implement HasDefaultSelectColumns interface...');

		$data = DatabaseStructureHelper::all();

		if (empty($data)) {
			$this->warn('No models found that implement the HasDefaultSelectColumns interface.');

			return;
		}

		$this->info("Found ".count($data)." model(s) implementing HasDefaultSelectColumns:");
		$this->newLine();

		$this->generateYamlFile($data);
	}

	/**
	 * @param array<string, array<string>> $data
	 */
	private function generateYamlFile(array $data): void
	{
		$content = Yaml::dump($data, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

		if (!Storage::disk('local')->exists(self::FOLDER)) {
			Storage::disk('local')->makeDirectory(self::FOLDER);
		}

		$filename = 'models-'.now()->format('Y-m-d_H-i-s').'.yaml';

		Storage::disk('local')->put(self::FOLDER.'/'.$filename, $content);
	}
}
