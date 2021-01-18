<?php

namespace App\Console\Commands;

use App\Constants\Roles;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an user with super administrator permissions';

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
     * @return void
     */
    public function handle(): void
    {
        $this->makeUser();
    }

    public function makeUser(): void
    {
        $name = $this->ask(trans('users.create_admin.name'));
        $email = $this->ask(trans('users.create_admin.email'));

        if ($this->checkEmail($email)) {
            $password = $this->secret(trans('users.create_admin.password'));
            $passwordVerify = $this->secret(trans('users.create_admin.repeat_pass'));
            if ($password === $passwordVerify) {
                $admin = User::create([
                    'name'      => $name,
                    'email'     => $email,
                    'password'  => Hash::make($password),
                    'is_active' => true,
                ]);
                $admin->assignRole(Roles::SUPER_ADMIN);
                $this->info(trans('users.create_admin.ok'));
            } else {
                $this->error(trans('users.create_admin.pass_failed'));
            }
        } else {
            $this->error(trans('users.create_admin.email_invalid'));
        }
    }

    public function checkEmail(string $email): bool
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');

        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }
}
