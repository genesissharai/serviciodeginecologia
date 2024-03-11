<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorHierarchiesSeeder extends Seeder
{


    protected $hierarchies = [
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "Interno", "resident" => 0],
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "Artículo 8", "resident" => 0],
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "R1", "resident" => 1],
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "R2", "resident" => 1],
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "R3 ", "resident" => 1],
        [ "specialty" => "Ginecobstetra"  ,"hierarchy" => "Especialista", "resident" => 1],
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
