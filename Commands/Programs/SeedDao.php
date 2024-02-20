<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Database\SeederDao;

class SeedDao extends AbstractCommand
{
    // コマンド名を設定します
    protected static ?string $alias = 'seed-dao';

    public static function getArguments(): array
    {
        return [
            (new Argument('num'))->description('Number of data to be generated.')->required(false)->allowAsShort(true)
        ];
    }

    public function execute(): int
    {
        $this->runAllSeeds();
        return 0;
    }

    function runAllSeeds(): void {
        $directoryPath = __DIR__ . '/../../Database/SeedsDao';

        $num = $this->getArgumentValue('num') ? $this->getArgumentValue('num') : 50;
        // ディレクトリをスキャンしてすべてのファイルを取得します。
        $files = scandir($directoryPath);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // ファイル名からクラス名を抽出します。
                $className = 'Database\SeedsDao\\' . pathinfo($file, PATHINFO_FILENAME);

                // シードファイルをインクルードします。
                include_once $directoryPath . '/' . $file;

                if (class_exists($className) && is_subclass_of($className, SeederDao::class)) {
                    $seederDao = new $className();
                    if($seederDao->seed($num)){
                        $this->log("Seed DAO data generation to memcached was successful.");
                    }
                    else{
                        $this->log("Generation of seed DAO data to memcached failed.");
                    }
                }
                else throw new \Exception('Seeder must be a class that subclasses the seeder interface');
            }
        }
    }
}