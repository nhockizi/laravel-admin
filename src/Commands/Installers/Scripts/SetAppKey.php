<?php
namespace Kizi\Admin\Commands\Installers\Scripts;

use Illuminate\Console\Command;
use Kizi\Admin\Commands\Installers\SetupScript;

class SetAppKey implements SetupScript
{
    /**
     * Fire the install script
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->call('key:generate');

            return;
        }
        $command->callSilent('key:generate');
    }
}
