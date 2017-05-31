<?php
namespace Kizi\Admin\Commands\Installers\Scripts;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Kizi\Admin\Commands\Installers\SetupScript;

class ProtectInstaller implements SetupScript
{
    /**
     * @var Filesystem
     */
    protected $finder;

    /**
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Fire the install script
     * @param  Command   $command
     * @return mixed
     * @throws Exception
     */
    public function fire(Command $command)
    {
        if ($this->finder->isFile('.env') && !$command->option('force')) {
            throw new Exception('Admin has already been installed. You can already log into your administration.');
        }
    }
}
