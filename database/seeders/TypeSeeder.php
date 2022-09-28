<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_type = new Type();
        $new_type->name = "Titulo";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Texto";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Editable";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Editable Multilinea";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Seleccion";
        $new_type->features = true;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Fecha";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Hora";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Imagen";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Firma";
        $new_type->features = false;
        $new_type->save();

        $new_type = new Type();
        $new_type->name = "Seleccion especial";
        $new_type->features = true;
        $new_type->save();
    }
}
