<?php

namespace WebArtisans\DockerLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Class DockerServeCommand
 *
 * @package WebArtisans\DockerLaravel\Commands
 */
class DockerServeCommand extends Command
{

    /**
     * @var string|null
     */
    protected $repository = null;
    /**
     * @var string|null
     */
    protected $tag = null;

    /**
     * @var string|null
     */
    protected $path = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docker:serve
                            {name? : The NAME of the container}
                            {--foreground : When enabled this is gonna run in foreground}
                            {--port=8080 : The port for the nginx server}
                            {--mysql-port=33060 : The port for the mysql server}
                            {--env-file=.env : The .env file to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serves the laravel application in a single docker container';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->repository = config("laravel-docker.repository", "wartisans/docker-laravel-lemp");
        $this->tag = config("laravel-docker.tag", "latest");
        $this->path = config("laravel-docker.fileName", ".dockerID");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $foreground = $this->option('foreground');
        $name = $this->argument('name');
        $envFile = $this->option('env-file');
        $webServerPort = $this->option('port');
        $mysqlServerPort = $this->option('mysql-port');

        $command = "docker run -p {$webServerPort}:80 -p {$mysqlServerPort}:3306 -v `pwd`:/var/www/html --env-file {$envFile} ";

        if (!$name) {
            $name = $this->getDefaultContainerName();
        }

        if ($name) {
            $command .= "--name {$name} ";
        }

        if (!$foreground) {
            $command .= "-d ";
        }


        $command .= "{$this->repository}:{$this->tag}";

        $executed =  exec($command);

        if (!Storage::disk('local')->exists($this->path))
        {
            Storage::disk('local')->put($this->path, $executed);
        }

        $this->info("Docker container is running {$executed}. Enjoy it!");
    }


    protected function getDefaultContainerName()
    {
        $namespace = strtolower(config('docker-laravel.namespace'));
        $name = strtolower(config('docker-laravel.app'));

        if ($namespace) {
            $namespace .= '-';
        }

        return "{$namespace}{$name}";
    }
}
