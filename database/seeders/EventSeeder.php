<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $events = [
            [
                'user_id' => $users->random()->id,
                'title' => 'Conferencia de Introducción a la Inteligencia Artificial',
                'description' => 'Conferencia introductoria sobre los conceptos básicos de la inteligencia artificial y su aplicación en la vida cotidiana.',
                'activity_type' => 'online',
                'link' => 'https://example.com/conferencia-ia',
                'location' => null,
                'start_date' => '2024-01-15 10:00:00',
                'end_date' => '2024-01-15 12:00:00',
                'duration' => 2,
                'color' => '#FF5733',
            ],
            [
                'user_id' => $users->random()->id,
                'title' => 'Taller de Desarrollo Web Avanzado',
                'description' => 'Taller práctico sobre las últimas tecnologías y tendencias en el desarrollo web moderno.',
                'activity_type' => 'in-person',
                'link' => null,
                'location' => 'Auditorio principal',
                'start_date' => '2024-02-10 14:00:00',
                'end_date' => '2024-02-10 18:00:00',
                'duration' => 4,
                'color' => '#33FF57',
            ],
            [
                'user_id' => $users->random()->id,
                'title' => 'Concurso de Programación',
                'description' => 'Competencia de programación abierta a todos los estudiantes de la universidad.',
                'activity_type' => 'in-person',
                'link' => null,
                'location' => 'Salón de eventos',
                'start_date' => '2024-03-05 09:00:00',
                'end_date' => '2024-03-05 17:00:00',
                'duration' => 8,
                'color' => '#3357FF',
            ],
            [
                'user_id' => $users->random()->id,
                'title' => 'Seminario de Ciberseguridad',
                'description' => 'Seminario especializado en ciberseguridad, dirigido a estudiantes y profesionales del área de sistemas.',
                'activity_type' => 'online',
                'link' => 'https://example.com/seminario-ciberseguridad',
                'location' => null,
                'start_date' => '2024-04-20 11:00:00',
                'end_date' => '2024-04-20 13:00:00',
                'duration' => 2,
                'color' => '#FF33C4',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
