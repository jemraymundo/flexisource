<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImporterService;

class ImportCustomers extends Command
{
    protected $signature = 'import:customers';
    protected $description = 'Import customers from data provider';

    protected $importerService;

    public function __construct(ImporterService $importerService)
    {
        parent::__construct();
        $this->importerService = $importerService;
    }

    public function handle()
    {
        $this->info('Starting customer import...');
        $this->importerService->fetchUsers(100, 'AU');
        $this->info('Customer import completed.');
    }
}
