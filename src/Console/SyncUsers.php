<?php

namespace Amyisme13\UltraHelper\Console;

use Amyisme13\UltraHelper\Models\UltraUser;
use Amyisme13\UltraHelper\UltraHelper;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ultra-helper:sync-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users from Ultra to ultra_users table';

    /**
     * @var \Amyisme13\UltraHelper\UltraHelper
     */
    private $helper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UltraHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Syncing users...');

        $maxPage = $this->service->getUsersMeta()->num_pages;

        $bar = $this->output->createProgressBar($maxPage);
        $bar->start();

        $page = 1;
        while ($page <= $maxPage) {
            try {
                $users = $this->helper->getUsersPaginated($page);
                $users->each(function ($user) {
                    UltraUser::updateOrCreate(
                        ['username' => $user['user_id']],
                        [
                            'moodle_id' => $user['moodle_user_id'],
                            'email' => $user['moodle_data']['email'],
                            'name' => $user['full_name'],
                            'function' => $user['function'],
                            'division' => $user['division'],
                            'position' => $user['position'],
                            'area' => $user['area'],
                            'sub_area' => $user['sub_area'],
                            'costcenter' => $user['costcenter'],
                            'top_username' => $user['top_id'] ? $user['top_id'] : null,
                            'activated_at' => Carbon::parse($user['activated_on']),
                            'suspended' => $user['suspended'],
                        ]
                    );
                });
            } catch (\Exception $err) {
                $this->error('Sync users failed on page ' . $page);
            }

            $page += 1;
            $bar->advance();
        };

        $bar->finish();
        $this->info("\nFinished sync users.");
    }
}
