<?php
namespace Ansofra\Bin;

class Console
{
    protected static string $version = 'v1.0.0';

    public static function run(array $argv): void
    {
        $command = $argv[1] ?? '--version';

        switch ($command) {
            case '--version':
            case '-v':
                self::showVersion();
                break;

            case 'new':
                $project = $argv[2] ?? null;
                if (!$project) {
                    echo "Usage: ansofra new <project_name>\n";
                    exit(1);
                }
                self::createNewProject($project);
                break;

            case '--help':
            case '-h':
            default:
                self::showHelp();
        }
    }

    protected static function showVersion(): void
    {
        $logo = <<<LOGO

   ___            __               __             
  / _ | ___  ____/ /__ ___ ____   / /  ___  __ __ 
 / __ |/ _ \/ __/  '_/(_-</ __/  / /__/ _ \/ // / 
/_/ |_/_//_/\__/_/\_\/___/\__/  /____/\___/\_,_/  

LOGO;

        echo PHP_EOL . $logo . PHP_EOL;
        echo "Ansofra Framework " . self::$version . PHP_EOL;
        echo "Author: Newdich" . PHP_EOL . PHP_EOL;
    }

    protected static function createNewProject(string $name): void
    {
        if (is_dir($name)) {
            echo "❌ Directory '{$name}' already exists.\n";
            return;
        }

        mkdir($name, 0777, true);
        echo "✅ Created new Ansofra project: {$name}\n";
    }

    protected static function showHelp(): void
    {
        echo "Ansofra Framework CLI\n";
        echo "Usage:\n";
        echo "  ansofra --version       Show the current version\n";
        echo "  ansofra new <name>      Create a new project folder\n";
        echo "  ansofra --help          Show this help message\n";
    }
}
?>