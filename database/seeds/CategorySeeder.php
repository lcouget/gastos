<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\CategoryType;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gastoCategoryType = CategoryType::where('category_type' , '=', 'gasto')->first();
        $ingresoCategoryType = CategoryType::where('category_type' , '=', 'ingreso')->first();

        //categorias para ingresos
        DB::table('categories')->insert([
           'category' => 'Sueldo mes anterior',
           'category_type_id' => $ingresoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Sueldo no declarado',
           'category_type_id' => $ingresoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Aguinaldo',
           'category_type_id' => $ingresoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Ingreso Extra',
           'category_type_id' => $ingresoCategoryType->id,
           'active' => 1,
        ]);

        //categorias para gastos
        DB::table('categories')->insert([
           'category' => 'Casa',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Pago Servicios',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Vacaciones',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Regalos',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Salidas',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Pago Expensas',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Alimentos',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Farmacia',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gasto Varios',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Otros gastos',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);

        DB::table('categories')->insert([
           'category' => 'Gastos Recitales',
           'category_type_id' => $gastoCategoryType->id,
           'active' => 1,
        ]);
    }
}
