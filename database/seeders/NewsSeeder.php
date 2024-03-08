<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        // Create news
        $news = [
            [
                'title' => 'Nuevo proyecto de inteligencia artificial en SUIS',
                'description' => 'El seedbed SUIS de ingeniería de sistemas ha iniciado un nuevo proyecto de inteligencia artificial para mejorar la eficiencia en los procesos de enseñanza y aprendizaje.',
                'autor' => 'Juan Pérez',
                'url' => 'https://www.google.com',
                'event_id' => $events->random()->id,
            ],
            [
                'title' => 'Conferencia sobre desarrollo web moderno',
                'description' => 'Se llevará a cabo una conferencia sobre las últimas tendencias en desarrollo web moderno, organizada por el seedbed SUIS de ingeniería de sistemas.',
                'autor' => 'María Gómez',
                'url' => 'https://www.google.com',
                'event_id' => $events->random()->id,
            ],
            [
                'title' => 'Concurso de programación',
                'description' => 'El seedbed SUIS de ingeniería de sistemas ha lanzado un concurso de programación abierto a todos los estudiantes de la universidad.',
                'autor' => 'Carlos López',
                'url' => 'https://www.google.com',
                'event_id' => $events->random()->id,
            ],
            [
                'title' => 'Taller de introducción a la inteligencia artificial',
                'description' => 'Se llevará a cabo un taller introductorio sobre inteligencia artificial, dirigido por expertos en el campo y organizado por el seedbed SUIS de ingeniería de sistemas.',
                'autor' => 'Laura Martínez',
                'url' => 'https://www.google.com',
                'event_id' => $events->random()->id,
            ],
        ];

        foreach ($news as $new) {
            News::create($new);
        }
    }
}
