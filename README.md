## Laravel Role package

Paquete de Laravel para poder añadir a los usuarios un rol de usuario. 

### Instalación

En el fichero `composer.json` añadir el repositorio de la siguiente forma:

```sh
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ertomy/laravel-role"
        }
    ],
```

Después instalar mediante el comando:

```sh  
composer require ertomy/roles  
```

Con esto el paquete ya está instalado, ahora lo que debemos es hacer referencia al service provider en el fichero `config\app.php` añadiendolo al array de providers:

```php
Ertomy\Roles\RolesPackageServiceProvider::class, 
```

También debemos incluir el middleware en el fichero `app\Http\Kernel.php` dentro del array **middlewareAliases**:

```php
'role' => \Ertomy\Roles\Middleware\RoleMiddleware::class, 
```

Y finalmente en el modelo **User** añadir el trait para que cargue la relación de la tabla user con role y poder usar el método hasRole() dentro del user:

```php
    use Ertomy\Roles\Traits\HasRole;
	.......
	class User extends Authenticatable
	{
		use HasRole;
```

### Funcionamiento

Lo primero sería crear distintos roles en la tabla **role** y usuarios, por ejemplo mediante un seeder:

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Ertomy\Roles\Models\Role;
use App\Models\User;

class RolesUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear roles
         $adminRole = Role::create(['name' => 'Admin']);
         $userRole = Role::create(['name' => 'User']);
 
         // Crear usuarios
         $admin = User::create([
             'name' => 'Admin User',
             'email' => 'admin@example.com',
             'password' => bcrypt('password'),
             'role_id' => $adminRole->id
         ]);
 
         $user = User::create([
             'name' => 'Regular User',
             'email' => 'user@example.com',
             'password' => bcrypt('password'),
             'role_id' => $userRole->id
         ]);
    }
}
```

A partir de aquí ya podríamos usar el middleware para las rutas (se le puede pasar como parámetro un literal con el nombre del rol o un listado de roles separados por coma):
```php
Route::get('/admin', function () {
    dd('es administrador');
})->middleware('rol:Admin');
```

También tendríamos una directiva de blade para poder controlar lo que mostramos a cada perfil de usuario (se le puede pasar como parámetro un literal con el nombre del rol o un listado de roles separados por coma):
```php
@role('Admin')
    <div>
        Este HTML solo se mostrará si el usuario tiene el rol "admin".
    </div>
@endrole
```

Y a parte el modelo **User** tendría también la relación con el modelo **Role** por lo que podríamos interactuar como cualquier relación:

```php
    $user = auth()->user();
    echo $user->role->name;
```
 o preguntar directamente por el rol del usuario
 
 ```php
    $user = auth()->user();
    if($user->hasRole('Admin')){
        dd('es administrador');
    }
```
