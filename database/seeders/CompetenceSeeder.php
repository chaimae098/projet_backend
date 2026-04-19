<?php

namespace Database\Seeders;

use App\Models\Competence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competences = [
            ['nom' => 'PHP', 'categorie' => 'Langage de programmation'],
            ['nom' => 'JavaScript', 'categorie' => 'Langage de programmation'],
            ['nom' => 'Laravel', 'categorie' => 'Framework'],
            ['nom' => 'React', 'categorie' => 'Framework'],
            ['nom' => 'MySQL', 'categorie' => 'Base de données'],
            ['nom' => 'Git', 'categorie' => 'Outil de versioning'],
            ['nom' => 'Docker', 'categorie' => 'Outil de conteneurisation'],
            ['nom' => 'AWS', 'categorie' => 'Cloud computing'],
            ['nom' => 'Agile', 'categorie' => 'Méthodologie de développement'],
            ['nom' => 'Communication', 'categorie' => 'Compétence soft']
        ];

        foreach ($competences as $competence) {
            Competence::updateOrCreate(
                ['nom' => $competence['nom']],
                ['categorie' => $competence['categorie']]
            );
        }
    }
}
