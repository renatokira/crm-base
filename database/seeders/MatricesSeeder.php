<?php

namespace Database\Seeders;

use App\Models\{Matrice};
use Illuminate\Database\Seeder;

class MatricesSeeder extends Seeder
{
    public function run(): void
    {

        $matrices = [
            ["MATRIZ-ACV-POS", 300],
            ["MATRIZ-(ACU-SAAI)", 100],
            ["MATRIZ-AFI-SJG", 100],
            ["MATRIZ-ALH", 100],
            ["MATRIZ-ATS-PIP", 100],
            ["MATRIZ-CBO", 100],
            ["MATRIZ-CSS-SNZ", 20],
            ["MATRIZ-CUD-SHD", 100],
            ["MATRIZ-ETC", 100],
            ["MATRIZ-GOI", 100],
            ["MATRIZ-GUS-LAT-INT-CFY", 100],
            ["MATRIZ-IAU", 100],
            ["MATRIZ-IOP-IGE", 400],
            ["MATRIZ-MBC JZN-IAU", 100],
            ["MATRIZ-MRO", 200],
            ["MATRIZ-MVA-LNT", 100],
            ["MATRIZ-PJS", 100],
            ["MATRIZ-PQEBJM", 100],
            ["MATRIZ-SGI", 100],
            ["MATRIZ-SLZ", 300],
            ["MATRIZ-SZA", 300],
            ["MATRIZ-SOBRAL", 300],
            ["MATRIZ-SYM", 300],
            ["MATRIZ-TSA", 300],
            ["MATRIZ-TTA-VSA", 300],
            ["MATRIZ-VLNK", 10],
        ];

        Matrice::factory()->create([
            'name'           => 'MATRIZ-FLA-JZN',
            'threshold'      => 1780,
            'bandwidth'      => 2,
            'bandwidth_unit' => 'TB',
        ]);

        foreach ($matrices as $matrix) {
            Matrice::factory()->create([
                'name'      => $matrix[0],
                'threshold' => $matrix[1],
            ]);
        }
    }
}
