<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp1 = new Category([
            'name' => 'Informácie okolo nás',
            'parent_id' => null
        ]);
        $tmp2 = new Category([
            'name' => 'Komunikácia prostredníctvom digitálnych technológií',
            'parent_id' => null
        ]);
        $tmp3 = new Category([
            'name' => 'Postupy, riešenie problémov, algoritmické myslenie',
            'parent_id' => null
        ]);
        $tmp4 = new Category([
            'name' => 'Princípy fungovania digitálnych technológií',
            'parent_id' => null
        ]);
        $tmp5 = new Category([
            'name' => 'Informačná spoločnosť',
            'parent_id' => null
        ]);
        $tmp1->save();
        $tmp2->save();
        $tmp3->save();
        $tmp4->save();
        $tmp5->save();
        
        $subCatNames = [
            'kódovanie, šifrovanie, komprimácia informácie',
            'číselné sústavy, prevody',
            'reprezentácia údajov v počítači - diagramy, čísla, znaky a vzťahy medzi nimi',
            'vyhľadávanie opakujúcich sa vzorov',
            'informácie zobrazené pomocou údajových štruktúr - strom, graf, zásobník',
            'výroková logika a jej využívanie pri práci s informáciami, kombinatorika',
            'textová informácia - kompetencie potrebné na prácu v textovom editore',
            'grafická informácia - kompetencie potrebné na prácu v grafickom editore',
            'číselná informácia - kompetencie potrebné na prácu v tabuľkovom editore',
            'zvuková informácia - kompetencie potrebné na prácu v zvukovom editore',
            'prezentácia informácií - kompetencie potrebné na tvorbu prezentácií',
            'prezentácia informácií na webe - kompetencie potrebné na tvorbu webových stránok',
        ];
        
        foreach ($subCatNames as $item) {
            $cat = new Category([
                'name' => $item,
                'parent_id' => $tmp1->id
            ]);

            $cat->save();
        }
    }
}
