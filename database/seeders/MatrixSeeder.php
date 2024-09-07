<?php

namespace Database\Seeders;

use App\Models\{Matrix};
use Illuminate\Database\Seeder;

class MatrixSeeder extends Seeder
{
    public function run(): void
    {

        $matrices = [
            ["ACV-POS", 300],
            ["ACU-SAAI", 100],
            ["AFI-SJG", 100],
            ["ALH", 100],
            ["ATS-PIP", 100],
            ["CBO", 100],
            ["CSS-SNZ", 20],
            ["CUD-SHD", 100],
            ["ETC", 100],
            ["GOI", 100],
            ["GUS-LAT-INT-CFY", 100],
            ["IAU", 100],
            ["IOP-IGE", 400],
            ["MBC-JZN-IAU", 100],
            ["MRO", 200],
            ["MVA-LNT", 100],
            ["PJS", 100],
            ["PQEBJM", 100],
            ["SGI", 100],
            ["SLZ", 300],
            ["SZA", 300],
            ["SOBRAL", 300],
            ["SYM", 300],
            ["TSA", 300],
            ["TTA-VSA", 300],
            ["VLNK", 10],
        ];

        Matrix::factory()->create([
            'name'           => 'FLA-JZN',
            'threshold'      => 1780,
            'bandwidth'      => 2,
            'bandwidth_unit' => 'TB',
        ]);

        foreach ($matrices as $matrix) {
            Matrix::factory()->create([
                'name'      => $matrix[0],
                'threshold' => $matrix[1],
            ]);
        }
    }
}
