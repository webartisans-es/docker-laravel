<?php

namespace WebArtisans\DockerLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DockerRemoveCommand extends Command
{
    protected $path = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docker:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes the current laravel docker container';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = config("laravel-docker.fileName", ".dockerID");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (Storage::disk('local')->exists($this->path))
        {
            $dockerId = Storage::disk('local')->get($this->path);

            $command = "docker rm -f {$dockerId}";

            exec($command);

            Storage::disk('local')->delete($this->path);

            $this->info("Docker container {$dockerId} is removed!");
        } else {
            $this->warn('Sorry, we could not get the current container');
            $this->info('You can try `docker ps -a` and after that just `docker rm -f <name>`');
        }
    }
}
