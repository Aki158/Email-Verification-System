<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Database\MySQLWrapper;
use Exception;

class DbWipe extends AbstractCommand
{
    // 使用するコマンド名を設定
    // コマンドの説明
    // バックアップを作成しない
    // php console db-wipe
    // バックアップを作成する
    // php console db-wipe (num) --create-backup (num)

    protected static ?string $alias = 'db-wipe';

    // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('create-backup'))->description('Create a backup. The file name is backup.sql')->required(false)->allowAsShort(true),
        ];
    }

    public function execute(): int
    {
        $createBackup = $this->getArgumentValue('create-backup');
        $mysqli = new MySQLWrapper();

        // バックアップを作成する場合
        if(is_string($createBackup)) {
            $backupCommand = 'mysqldump -u '.$mysqli->getUsername().' -p '.$mysqli->getDatabaseName().' > backup.sql';
            exec($backupCommand);
            $this->log("Create a backup.");
        }

        $result = $mysqli->query('DROP DATABASE '.$mysqli->getDatabaseName());
        if($result === false) throw new Exception('Could not execute query.');
        else print("Successfully ran all SQL setup queries.".PHP_EOL);
        $this->log("Database delete.");
        
        return 0;
    }
}