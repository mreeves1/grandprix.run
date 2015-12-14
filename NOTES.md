# Laravel Learning

## Homestead

1. Homestead is a vagrant box with nginx, et al installed.
1. Edit the Homestead.yaml file so the domain name is what you want to be via:
   `hostname: grandprix-run`
   Then you would hosthack your workstations /etc/hosts file to include:
   `192.168.10.10   grandprix-run`
   After you bring up the box you will be able to access it from:
   `http://grandprix-run`

## Database, Models and Migrations

Example of making a db table, corresponding model and db seed:
1. You need to run these migration and db seed commands from within the vagrant box where the db lives
1. `php artisan make:migration create_races_table --create=races`
1. edit the `2015_12_09_043201_create_races_table.php` file to have the proper fields,
   constraints, etc. Note you may need to make any tables that will be the source of
   a foreign key constraint first as IIUC the migrations are run in order by timestamp.
1. `php artisan make:model Race`
1. run `php artisan migrate:install` once or after you drop all tables if you wish to start over
1. edit `database/seeds/DatabaseSeeder.php` and add a new class to match your new model
   ```
   class GenderTableSeeder extends Seeder {
       public function run()
       {
           DB::table('genders')->delete();
           DB::table('genders')->insert(['name' =>'Female', 'abbreviation' => 'F']);
           DB::table('genders')->insert(['name' =>'Male', 'abbreviation' => 'M']);
       }
   }
   ```
   and run it from within the DatabaseSeeder.run() method:
   ```
   $this->call(GenderTableSeeder::class);
   $this->command->info('Genders table seeded!');
   ```
1. run `php artisan db:seed`
1. run `mysql -u homestead -p homestead` to see the new tables and data

## Misc

**php artisan vendor:publish** This command I don't understand that well yet but can generate
files and what not once you set it up properly and for external dependencies such as the Markdown one.
[More info](http://laravel.com/docs/5.1/packages)


