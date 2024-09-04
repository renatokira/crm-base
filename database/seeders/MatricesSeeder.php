<?php

namespace Database\Seeders;

use App\Models\Matrices;
use Illuminate\Database\Seeder;

class MatricesSeeder extends Seeder
{
    public function run(): void
    {

        $matrices = [
            ["MATRIZ-ACV-POS", 300, 'GB'],
            ["MATRIZ-(ACU-SAAI)", 100, 'GB'],
            ["MATRIZ-AFI-SJG", 100, 'GB'],
            ["MATRIZ-ALH", 100, 'GB'],
            ["MATRIZ-ATS-PIP", 100, 'GB'],
            ["MATRIZ-BA-SE-AL", 600, 'GB'],
            ["MATRIZ-CBO", 100, 'GB'],
            ["MATRIZ-CSS-SNZ", 20, 'GB'],
            ["MATRIZ-CUD-SHD", 100, 'GB'],
            ["MATRIZ-ETC", 100, 'GB'],
            ["MATRIZ-FLA-JZN", 2, 'TB'],
            ["MATRIZ-GOI", 100, 'GB'],
            ["MATRIZ-GUS-LAT-INT-CFY", 100, 'GB'],
            ["MATRIZ-IAU", 100, 'GB'],
            ["MATRIZ-IOP-IGE", 400, 'GB'],
            ["MATRIZ-MBC JZN-IAU", 100, 'GB'],
            ["MATRIZ-MRO", 200, 'GB'],
            ["MATRIZ-MVA-LNT", 100, 'GB'],
            ["MATRIZ-PJS", 100, 'GB'],
            ["MATRIZ-PQEBJM", 100, 'GB'],
            ["MATRIZ-SGI", 100, 'GB'],
            ["MATRIZ-SLZ", 300, 'GB'],
            ["MATRIZ-SZA", 300, 'GB'],
            ["MATRIZ-SOBRAL", 300, 'GB'],
            ["MATRIZ-SYM", 300, 'GB'],
            ["MATRIZ-TSA", 300, 'GB'],
            ["MATRIZ-TTA-VSA", 300, 'GB'],
            ["MATRIZ-VLNK", 10, 'GB'],
        ];

        foreach ($matrices as $matrix) {
            Matrices::factory()->create([
                'name'      => $matrix[0],
                'threshold' => $matrix[1],
                'unit'      => $matrix[2],
            ]);
        }
    }
}
