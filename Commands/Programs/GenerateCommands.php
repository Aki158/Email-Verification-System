<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class CommandName extends AbstractCommand
{
    // TODO: エイリアスを設定してください。
    protected static ?string $alias = '{INSERT-COMMAND}';

    // TODO: 引数を設定してください。
    public static function getArguments(): array
    {
        return ['{INSERT-ARGUMENTS}'];
    }

    // TODO: 実行コードを記述してください。
    public function execute(): int
    {
        '{INSERT-CODE}';
        return 0;
    }
}