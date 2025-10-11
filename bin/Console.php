<?php
namespace Ansofra\Bin;

class Console
{
    protected string $version = 'v2.0.7';

    public function run(array $argv)
    {
        $command = $argv[1] ?? null;

        switch ($command) {
            case '--version':
            case '-v':
                $this->showVersion();
                break;

            case 'new':
                $this->createNewProject($argv[2] ?? null);
                break;

            default:
                $this->showHelp();
                break;
        }
    }

    protected function showVersion(): void
    {
        $logo = <<<'LOGO'
  ___   _   _  _____  _________________  ___                                                                  
 / _ \ | \ | |/  ___||  _  |  ___| ___ \/ _ \                                                                 
/ /_\ \|  \| |\ `--. | | | | |_  | |_/ / /_\ \                                                                
|  _  || . ` | `--. \| | | |  _| |    /|  _  |                                                                
| | | || |\  |/\__/ /\ \_/ / |   | |\ \| | | |                                                                
\_| |_/\_| \_/\____/  \___/\_|   \_| \_\_| |_/                                                                
                                                                                                              
                                                                                                              
________   __                                                                                                 
| ___ \ \ / /                                                                                                 
| |_/ /\ V /                                                                                                  
| ___ \ \ /                                                                                                   
| |_/ / | |                                                                                                   
\____/  \_/                                                                                                   
                                                                                                              
                                                                                                              
 _   _  _____ _    _______ _____ _____  _   _   _____ _____ _____  _   _  _   _ _____ _     _____ _______   __
| \ | ||  ___| |  | |  _  \_   _/  __ \| | | | |_   _|  ___/  __ \| | | || \ | |  _  | |   |  _  |  __ \ \ / /
|  \| || |__ | |  | | | | | | | | /  \/| |_| |   | | | |__ | /  \/| |_| ||  \| | | | | |   | | | | |  \/\ V / 
| . ` ||  __|| |/\| | | | | | | | |    |  _  |   | | |  __|| |    |  _  || . ` | | | | |   | | | | | __  \ /  
| |\  || |___\  /\  / |/ / _| |_| \__/\| | | |   | | | |___| \__/\| | | || |\  \ \_/ / |___\ \_/ / |_\ \ | |  
\_| \_/\____/ \/  \/|___/  \___/ \____/\_| |_/   \_/ \____/ \____/\_| |_/\_| \_/\___/\_____/\___/ \____/ \_/  
                                                                                                              
                                                                                                              
LOGO;

        echo PHP_EOL . $logo . PHP_EOL;
        echo "Ansofra CQRS Framework " . $this->version . PHP_EOL;
        echo "Author: Newdich Technology" . PHP_EOL . PHP_EOL;
    }

    protected function createNewProject(?string $projectName): void
    {
        if (!$projectName) {
            echo "Usage: ansofra new <project-name>\n";
            return;
        }

        $target = getcwd() . DIRECTORY_SEPARATOR . $projectName;
        if (file_exists($target)) {
            echo "❌ Directory '$projectName' already exists.\n";
            return;
        }

        // 👇 This points to your newdichApp folder
        $skeleton = __DIR__ . '/../newdichApp';

        if (!is_dir($skeleton)) {
            echo "❌ Template folder not found: $skeleton\n";
            return;
        }

        $this->copyDirectory($skeleton, $target);
        echo "✅ Project '$projectName' created successfully!\n";
        echo "👉 cd $projectName\n";
        echo "👉 php -S localhost:8000 -t public\n";
    }

    protected function copyDirectory(string $src, string $dst): void
    {
        $dir = opendir($src);
        @mkdir($dst, 0755, true);

        while (false !== ($file = readdir($dir))) {
            if ($file === '.' || $file === '..') continue;
            $srcPath = "$src/$file";
            $dstPath = "$dst/$file";

            if (is_dir($srcPath)) {
                $this->copyDirectory($srcPath, $dstPath);
            } else {
                copy($srcPath, $dstPath);
            }
        }
        closedir($dir);
    }

    protected function showHelp(): void
    {
        echo "Ansofra CLI\n";
        echo "Usage:\n";
        echo "  ansofra new <project-name>   Create a new Ansofra app\n";
        echo "  ansofra --version            Show framework version\n";
        echo "  ansofra help                 Show this help message\n";
    }
}
?>