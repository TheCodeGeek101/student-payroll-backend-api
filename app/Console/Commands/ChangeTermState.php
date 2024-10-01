<?php

namespace App\Console\Commands;
use App\Containers\SchoolsSection\Term\Actions\ChangeTermStateAction;
use Illuminate\Console\Command;

class ChangeTermState extends Command
{
    protected $signature = 'term:change-state';
    protected $description = 'Change the state of the current term based on the start date';

    protected $changeTermStateAction;

    public function __construct(ChangeTermStateAction $changeTermStateAction)
    {
        parent::__construct();
        $this->changeTermStateAction = $changeTermStateAction;
    }

    public function handle()
    {
        try {
            $result = $this->changeTermStateAction->run();
            $this->info('Term state changed successfully: ' . $result);
        } catch (\Exception $exception) {
            $this->error('Error changing term state: ' . $exception->getMessage());
        }
    }
}
