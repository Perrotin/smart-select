<?php

namespace SmartSelect\Helpers;

use Illuminate\Support\Facades\File;

class DatabaseStructureHelper
{
	public static function all(): array
	{
		$modelsWithInterface = self::getModelsWithInterface();

		$data = [];

		foreach ($modelsWithInterface as $modelClass) {
			$model = new $modelClass();
			$defaultColumns = $model->getGrantColumns();
			$table = $model->getTable();

			foreach ($defaultColumns as $type => $cols) {
				foreach ($cols as $col) {
					$data[$table][$type][] = $col;
				}
			}
		}

		return $data;
	}

	private static function getModelsWithInterface(): array
	{
		$modelsWithInterface = [];
		$modelPaths = [
			app_path('Models'),
		];

		foreach ($modelPaths as $path) {
			if (!File::exists($path)) {
				continue;
			}

			$files = File::allFiles($path);

			foreach ($files as $file) {
				if ('php' !== $file->getExtension()) {
					continue;
				}

				$className = self::getClassNameFromFile($file->getPathname());

				if ($className && self::implementsInterface($className, 'HasDefaultSelectColumns')) {
					$modelsWithInterface[] = $className;
				}
			}
		}

		return $modelsWithInterface;
	}

	private static function getClassNameFromFile(string $filePath): ?string
	{
		$content = File::get($filePath);

		// Extract namespace
		$namespace = null;
		if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
			$namespace = $matches[1];
		}

		// Extract class name
		if (preg_match('/class\s+(\w+)/', $content, $matches)) {
			$className = $matches[1];

			return $namespace ? $namespace.'\\'.$className : $className;
		}

		return null;
	}

	private static function implementsInterface(string $className, string $interfaceName): bool
	{
		try {
			if (!class_exists($className)) {
				return false;
			}

			$reflection = new \ReflectionClass($className);
			$interfaces = $reflection->getInterfaceNames();

			// Check for both short name and fully qualified name
			foreach ($interfaces as $interface) {
				if (class_basename($interface) === $interfaceName || $interface === $interfaceName) {
					return true;
				}
			}

			return false;
		} catch (\Exception $e) {
			return false;
		}
	}
}
