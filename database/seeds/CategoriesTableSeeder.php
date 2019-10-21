<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'title' => "cocina",
            'url' => "images/category/categorias_cocina.png",
            'slug' =>'cook',
            'node_id'=>0,
            "status_id"=>1,
            'level'=>1
        ]);

        DB::table('categories')->insert([
            'title' => "mascotas",
            'url' => "images/category/categorias_mascotas.png",
            'slug' =>'pet',
            "status_id"=>1,
            'node_id'=>0,
            'level'=>1
        ]);

        DB::table('categories')->insert([
            'title' => " belleza",
            'url' => "images/category/categorias_belleza.png",
            'slug' =>'belleza',
            "status_id"=>1,
            'node_id'=>0,
            'level'=>1
        ]);
        DB::table('categories')->insert([
            'title' => " hogar",
            'url' => "images/category/categorias_hogar.png",
            'slug' =>'hogar',
            "status_id"=>1,
            'node_id'=>0,
            'level'=>1
        ]);


        $cocina = DB::table("categories")->where("slug","cook")->first();

        DB::table('categories')->insert([
            'title' => "bar tender",
            'url' => "images/category/bar_tender.png",
            'slug' =>'bar-tender',
            'level'=>2,
            "status_id"=>1,
            'node_id'=>$cocina->id
        ]);

        $pet = DB::table("categories")->where("slug","pet")->first();

        DB::table('categories')->insert([
            'title' => "Domador",
            'url' => "images/category/mascotas1.png",
            'slug' =>'domador',
            'level'=>2,
            "status_id"=>1,
            'node_id'=>$pet->id
        ]);
        
        $belleza = DB::table("categories")->where("slug","belleza")->first();

        DB::table('categories')->insert([
            'title' => "Peluqueria",
            'url' => "images/category/belleza.png",
            'slug' =>'peluqueria',
            'level'=>2,
            "status_id"=>1,
            'node_id'=>$belleza->id
        ]);


    }
}
