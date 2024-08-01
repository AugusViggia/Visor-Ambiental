<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Recuperar buffer de user
        $usersBackup = \App\User::with(['roles'])
            ->get();

        // Recuperar buffer de roles
        $rolesBackup = Role::with('permissions')->get();

        // Recuperar buffer de permisos
        $permissionsBackup = Permission::with('roles')->get();

        Schema::disableForeignKeyConstraints();
        \Eloquent::unguard();

        // Vaciar tablas de librería
        foreach (config('permission.table_names') as $table) {
            DB::table($table)->truncate();
            $this->command->info("Tabla \"{$table}\" truncada.");
        }

        // Vaciar permisos de usuarios
        foreach (\App\User::all() as $user) {
            $user->roles()->detach();
        }

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
        ]);

        \Eloquent::reguard();
        Schema::enableForeignKeyConstraints();

        // Distinguir nuevos permisos del seeder
        $newPermissions = Permission::with('roles')->get()->diff($permissionsBackup);

        // Restaurar buffer de roles
        foreach ($rolesBackup as $roleBackup) {
            // Comprobar existencia de rol sino crearlo
            $role = Role::where('name', $roleBackup->name)->first();
            if (!$role) {
                $role = Role::create(Arr::except($roleBackup->toArray(), ['id']));
            }

            // Por si el permiso viene activo de seeder pero en backup está desactivado
            foreach ($role->permissions as $permission) {
                $isActive = false;

                foreach ($roleBackup->permissions as $permissionBackup) {
                    if($permission->name == $permissionBackup->name) {
                        $isActive = true;
                        break;
                    }
                }

                if (!$isActive) {
                    $role->revokePermissionTo($permission);
                }
            }

            // Comprobar existencia de permisos (por si se elimina de seeder) y asignar al rol
            foreach ($roleBackup->permissions as $permissionRoleBackup) {

                $permission = Permission::where('name', $permissionRoleBackup->name)->first();

                if ($permission) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        // Asignar permisos nuevos de seeder a rolesBackup
        foreach ($newPermissions as $newPermission) {

            $this->command->info("Procesando nuevo permiso: " . $newPermission->name);

            foreach ($newPermission->roles as $newPermissionRol) {

                $this->command->info("Al permiso: " . $newPermission->name . " asignando rol: " . $newPermissionRol->name);

                $role = Role::where('name', $newPermissionRol->name)->first();

                if (!$role) {
                    $role = Role::create(Arr::except($newPermissionRol->toArray(), ['id']));
                }

                $permission = Permission::where('name', $newPermission->name)->first();

                if ($permission) {
                    $role->givePermissionTo($permission);
                }

            }

        }

        // Asignar roles nuevamente
        foreach (\App\User::all() as $user) {

            // Coincidir usuario actual con usuario de backup
            $userInBackup = $usersBackup->first(function ($backupUser) use ($user){
                return $backupUser->id == $user->id;
            });

            // Asignar roles de backup
            foreach ($userInBackup->roles as $rolBackupUser) {
                $role = Role::where('name', $rolBackupUser->name)->first();
                if (!$role) {
                    $role = Role::create(Arr::except($roleBackup->toArray(), ['id']));
                }
                $user->assignRole($role);
            }
        }
    }
}
