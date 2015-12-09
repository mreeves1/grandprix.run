<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->command->info('Genders table seeded!');

        $this->call(DistanceTableSeeder::class);
        $this->command->info('Distances table seeded!');

        $this->call(StateTableSeeder::class);
        $this->command->info('States table seeded!');

        Model::reguard();
    }
}

class GenderTableSeeder extends Seeder {
    public function run()
    {
        DB::table('genders')->delete();
        DB::table('genders')->insert(['name' =>'Female', 'abbreviation' => 'F']);
        DB::table('genders')->insert(['name' =>'Male', 'abbreviation' => 'M']);
    }
}

class DistanceTableSeeder extends Seeder {
    public function run()
    {
        DB::table('distances')->delete();
        DB::table('distances')->insert(['name' =>'1 mile', 'value' => '1', 'unit' => 'miles']);
        DB::table('distances')->insert(['name' =>'2 miles', 'value' => '2', 'unit' => 'miles']);
        DB::table('distances')->insert(['name' =>'5K', 'value' => '5', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'8K', 'value' => '8', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'5 miles', 'value' => '5', 'unit' => 'miles']);
        DB::table('distances')->insert(['name' =>'10K', 'value' => '10', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'15K', 'value' => '15', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'20K', 'value' => '20', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'Half-Marathon (13.1 miles)', 'value' => '13.1', 'unit' => 'miles']);
        DB::table('distances')->insert(['name' =>'25K', 'value' => '25', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'30K', 'value' => '30', 'unit' => 'kilometers']);
        DB::table('distances')->insert(['name' =>'Marathon (26.2 miles)', 'value' => '26.2', 'unit' => 'miles']);
    }
}

class StateTableSeeder extends Seeder {
    public function run()
    {
        DB::table('states')->delete();
        DB::table('states')->insert(['abbreviation' =>'AK', 'name' => 'Alaska']);
        DB::table('states')->insert(['abbreviation' =>'AL', 'name' => 'Alabama']);
        DB::table('states')->insert(['abbreviation' =>'AR', 'name' => 'Arkansas']);
        DB::table('states')->insert(['abbreviation' =>'AZ', 'name' => 'Arizona']);
        DB::table('states')->insert(['abbreviation' =>'CA', 'name' => 'California']);
        DB::table('states')->insert(['abbreviation' =>'CO', 'name' => 'Colorado']);
        DB::table('states')->insert(['abbreviation' =>'CT', 'name' => 'Connecticut']);
        DB::table('states')->insert(['abbreviation' =>'DC', 'name' => 'District of Columbia']);
        DB::table('states')->insert(['abbreviation' =>'DE', 'name' => 'Delaware']);
        DB::table('states')->insert(['abbreviation' =>'FL', 'name' => 'Florida']);
        DB::table('states')->insert(['abbreviation' =>'GA', 'name' => 'Georgia']);
        DB::table('states')->insert(['abbreviation' =>'HI', 'name' => 'Hawaii']);
        DB::table('states')->insert(['abbreviation' =>'IA', 'name' => 'Iowa']);
        DB::table('states')->insert(['abbreviation' =>'ID', 'name' => 'Idaho']);
        DB::table('states')->insert(['abbreviation' =>'IL', 'name' => 'Illinois']);
        DB::table('states')->insert(['abbreviation' =>'IN', 'name' => 'Indiana']);
        DB::table('states')->insert(['abbreviation' =>'KS', 'name' => 'Kansas']);
        DB::table('states')->insert(['abbreviation' =>'KY', 'name' => 'Kentucky']);
        DB::table('states')->insert(['abbreviation' =>'LA', 'name' => 'Louisiana']);
        DB::table('states')->insert(['abbreviation' =>'MA', 'name' => 'Massachusetts']);
        DB::table('states')->insert(['abbreviation' =>'MD', 'name' => 'Maryland']);
        DB::table('states')->insert(['abbreviation' =>'ME', 'name' => 'Maine']);
        DB::table('states')->insert(['abbreviation' =>'MI', 'name' => 'Michigan']);
        DB::table('states')->insert(['abbreviation' =>'MN', 'name' => 'Minnesota']);
        DB::table('states')->insert(['abbreviation' =>'MO', 'name' => 'Missouri']);
        DB::table('states')->insert(['abbreviation' =>'MS', 'name' => 'Mississippi']);
        DB::table('states')->insert(['abbreviation' =>'MT', 'name' => 'Montana']);
        DB::table('states')->insert(['abbreviation' =>'NC', 'name' => 'North Carolina']);
        DB::table('states')->insert(['abbreviation' =>'ND', 'name' => 'North Dakota']);
        DB::table('states')->insert(['abbreviation' =>'NE', 'name' => 'Nebraska']);
        DB::table('states')->insert(['abbreviation' =>'NH', 'name' => 'New Hampshire']);
        DB::table('states')->insert(['abbreviation' =>'NJ', 'name' => 'New Jersey']);
        DB::table('states')->insert(['abbreviation' =>'NM', 'name' => 'New Mexico']);
        DB::table('states')->insert(['abbreviation' =>'NV', 'name' => 'Nevada']);
        DB::table('states')->insert(['abbreviation' =>'NY', 'name' => 'New York']);
        DB::table('states')->insert(['abbreviation' =>'OH', 'name' => 'Ohio']);
        DB::table('states')->insert(['abbreviation' =>'OK', 'name' => 'Oklahoma']);
        DB::table('states')->insert(['abbreviation' =>'OR', 'name' => 'Oregon']);
        DB::table('states')->insert(['abbreviation' =>'PA', 'name' => 'Pennsylvania']);
        DB::table('states')->insert(['abbreviation' =>'RI', 'name' => 'Rhode Island']);
        DB::table('states')->insert(['abbreviation' =>'SC', 'name' => 'South Carolina']);
        DB::table('states')->insert(['abbreviation' =>'SD', 'name' => 'South Dakota']);
        DB::table('states')->insert(['abbreviation' =>'TN', 'name' => 'Tennessee']);
        DB::table('states')->insert(['abbreviation' =>'TX', 'name' => 'Texas']);
        DB::table('states')->insert(['abbreviation' =>'UT', 'name' => 'Utah']);
        DB::table('states')->insert(['abbreviation' =>'VA', 'name' => 'Virginia']);
        DB::table('states')->insert(['abbreviation' =>'VT', 'name' => 'Vermont']);
        DB::table('states')->insert(['abbreviation' =>'WA', 'name' => 'Washington']);
        DB::table('states')->insert(['abbreviation' =>'WI', 'name' => 'Wisconsin']);
        DB::table('states')->insert(['abbreviation' =>'WV', 'name' => 'West Virginia']);
        DB::table('states')->insert(['abbreviation' =>'WY', 'name' => 'Wyoming']);
    }
}


