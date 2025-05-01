<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Team;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'team' => "FURIA",
            'logo_path' => "furia.webp",
        ]);

        Team::create([
            'team' => "Fluxo",
            'logo_path' => "fluxo.webp",
        ]);

        Team::create([
            'team' => "Imperial",
            'logo_path' => "imperial.webp",
        ]);

        Team::create([
            'team' => "MIBR",
            'logo_path' => "mibr.webp",
        ]);

        Team::create([
            'team' => "paiN Gaming",
            'logo_path' => "pain.webp",
        ]);

        Team::create([
            'team' => "Sharks Esports",
            'logo_path' => "sharks.webp",
        ]);
    }
}
