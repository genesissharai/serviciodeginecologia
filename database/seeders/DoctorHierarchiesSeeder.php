<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorHierarchiesSeeder extends Seeder
{


    protected $hierarchies = [
        [ "id" => 1, "specialty" => "Ginecobstetra"  ,"hierarchy" => "Interno", "resident" => 0],
        [ "id" => 2, "specialty" => "Ginecobstetra"  ,"hierarchy" => "Artículo 8", "resident" => 0],
        [ "id" => 3, "specialty" => "Ginecobstetra"  ,"hierarchy" => "R1", "resident" => 1],
        [ "id" => 4, "specialty" => "Ginecobstetra"  ,"hierarchy" => "R2", "resident" => 1],
        [ "id" => 5, "specialty" => "Ginecobstetra"  ,"hierarchy" => "R3 ", "resident" => 1],
        [ "id" => 6, "specialty" => "Ginecobstetra"  ,"hierarchy" => "Especialista", "resident" => 1],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        foreach($this->hierarchies as $hierarchy){
            \DB::table('doctor_hierarchies')->insert([
                "specialty" => $hierarchy["specialty"],
                "hierarchy" => $hierarchy["hierarchy"],
                "resident" => $hierarchy["resident"],
            ]);
        }

    }
}
