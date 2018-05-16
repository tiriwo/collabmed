<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create administrator account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Enter username');
        $email = $this->ask('Enter the super admin Email address');
        $password = $this->secret('Enter the super admin\'s password?');

        $admin = User::find(['email' => $email])->first();

        if ($admin) {
            return $this->info('The email given is already registered. The Administrator account could not be created');
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->is_admin=1;
        $user->password = bcrypt($password);
        $user->save();

        return $this->info('Successfully created the Administrator account');
    }
}
