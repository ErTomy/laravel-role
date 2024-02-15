<?php

namespace Ertomy\Roles\Console\Commands;

use Illuminate\Console\Command;
use Ertomy\Roles\Models\Role;

class AddRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add {rolename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Añadir nuevo Rol en caso de no existir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(Role::where('name', $this->argument('rolename'))->exists()){
            $this->error("El rol ya existe");
            return;
        }

        Role::create(['name' => $this->argument('rolename')]);
        $this->info("Rol creado con exito");
    }
}
