<?php

namespace Database\Seeders;

use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PcAccessLogSeeder extends Seeder
{
    public function run()
    {
        // --- 1. Paste at least 60 student entries here
        // Format: ID, surname, first name, middle name
        $students = [
            // 60 students from your provided set!
            ['2510219-1','Abasolo','Justine','Pantino'],
            ['2510491-2','Abenoja','Mary Joyce','Ganzo'],
            ['2510949-1','Aguilar','Polaris','De Guzman'],
            ['2510001-1','Aguillon','Marco Shyldon','Abrea'],
            ['2510281-1','Albarico','Ricardo','Bahinting'],
            ['2510516-1','Asares','Lennuel Angelo','Escupete'],
            ['2510568-1','Bibera','Albert','Dante'],
            ['2510665-2','Bolasco','Tamara','Garcia'],
            ['2510607-2','Calubag','Kristine Irish','Gayda'],
            ['2510614-2','Catacutan','Rhea May','Vilbar'],
            ['2510508-1','Cuadra','Brent Mathew','Bernales'],
            ['2510624-2','Dela Peña','Ceff','Valiente'],
            ['2510526-1','Duterte','Kent Zeus','Cagande'],
            ['2510628-1','Ebner','Dwyane','Lawag'],
            ['2590204-2','Eliseo','Jessica','Songalia'],
            ['2510586-2','Hernandez','Mariah Eloisa','Villamor'],
            ['2510302-1','Jamito','Fredrick Shene','Pacha'],
            ['2510662-1','Joyno','Kim Gerald','Balahay'],
            ['2510604-2','Laurel','Aiya Pauline','Deguiñon'],
            ['2510655-1','Lazarte','Michael','Velmonte'],
            ['2510307-1','Malabad','Christian Jay',''],
            ['2510455-2','Mier','Ruby Grace','Odarbe'],
            ['2510587-2','Nopal','Senelyn','Dautil'],
            ['2510523-1','Palanca','Loren Thomas','Maunes'],
            ['2510552-2','Palen','Elaisha Kish','Gozon'],
            ['2510479-1','Palero','Marchell','Manual'],
            ['2510934-1','Parug','Marc Anthony','Sajol'],
            ['2510652-1','Quiseo','Romar','Enalgan'],
            ['2511004-1','Rosal','Georex Jad','Labastida'],
            ['2510410-1','Sendrijas','Shaimon','Catubigan'],
            ['2510457-1','Tortor','John Royz','Trajano'],
            ['2510650-1','Villamor','Joshua','Flores'],
            ['2511012-2','Albero','Vicelle Daphne','Rabanos'],
            ['2510969-2','Bagay','Christel Ella Marie','Ballada'],
            ['2510865-2','Bardilas','Angel','Batestil'],
            ['2510636-1','Barte','Mark Benedict','Garin'],
            ['2210125-2','Basiga','Laika Jane','Tenio'],
            ['2511024-1','Bonotan','Enrique','Culajara'],
            ['2510950-2','Borlasa','Mary Joy','Bendulo'],
            ['2510831-1','Cabato','Federico','Bagares'],
            ['2510774-1','Calambo','Ivan Jade','Galia'],
            ['2510316-2','Celeste','Elaiza Nicole','Macalam'],
            ['2510862-1','Cervantes','Jade Bhambo','Rosello'],
            ['2511129-1','Dejito','Zeniff','Maceda'],
            ['2511589-1','Dumalag','Russell Josef','Ruiz'],
            ['2510837-1','Escoro','Jerome','Concillado'],
            ['2510784-2','Huerte','Krishna Marcon','Sumodlayon'],
            ['2510315-2','Lampusan','Janina Nicole','Galolo'],
            ['2510139-1','Lelis','Niel Justin','Gerona'],
            ['2410905-2','Ligue','Lady Dianne','Ramirez'],
            ['2510280-2','Limbo','Shirly','Dedal'],
            ['2510923-2','Macion','Angelene','Torotoro'],
            ['2510815-1','Maraon','Dhoniel','Canabe'],
            ['2510178-2','Maxino','Samantha Ariane','Vertudazo'],
            ['2510891-1','Mori','Joselito Miguel','Cadimas'],
            ['2510760-2','Niñez','Mary Ann','Masendo'],
            ['2510671-1','Oberes','Charles','Amer'],
            ['2510693-1','Ortiz','Achilles Simone','Abiñon'],
            // <-- you can add further from your large list as needed
        ];

        $courses = [
            'BS in Civil Engineering',
            'BS in Mechanical Engineering',
            'BS in Computer Engineering',
            'BS in Electrical Engineering',
            'Bachelor of Industrial Technology (Majors: Automotive, Drafting, Electrical, Electronics, Food Preparation & Services, HVAC)',
            'BS in Information Technology (Majors: Networking, Programming)',
            'Bachelor of Elementary Education (BEEd)',
            'Bachelor of Technology and Livelihood Education (Majors: Home Economics, Industrial Arts, ICT)',
            'BS in Hospitality Management',
            'BS in Tourism Management',
            'BS in Food Technology',
            'BS in Criminology',
            'Doctor of Philosophy in Technology Management',
            'Master in Teaching and Learning Innovation (Majors: English, Math, Science, Filipino)',
            'Master of Arts in Teaching (Majors: English, Filipino, Mathematics, Natural Science)',
            'Master in Management',
            'Master in Technology Education',
            'Master of Science in Information Technology'
        ];

    
        $workstationIds = Workstations::pluck('id')->toArray();

        // ---- SEEDING START DATE ----
        $startDate = Carbon::create(2026, 8, 21)->startOfDay();
        $endDate = Carbon::create(2026, 8, 28)->endOfDay();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Random logs (24–36) with unique students per day
            $logsToday = rand(24, 36);
            $studentsToday = collect($students)->shuffle()->take($logsToday)->values();
            foreach ($studentsToday as $student) {
                [$studentId, $last, $first, $middle] = $student;
                $studentName = trim("$first $middle $last");

                $workstation_id = $workstationIds[array_rand($workstationIds)];
                $course = $courses[array_rand($courses)];

                $occurredAt = Carbon::instance(
                    $date->copy()
                        ->addHours(rand(7, 18))
                        ->addMinutes(rand(0, 59))
                        ->addSeconds(rand(0, 59))
                );
                $receivedAt = (clone $occurredAt)->addSeconds(rand(10, 90));

                PcAccessLogs::create([
                    'occurred_at'          => $occurredAt,
                    'received_at'          => $receivedAt,
                    'rfid_uid'             => 'RFID' . rand(1000,9999),
                    'workstation_id'       => $workstation_id,
                    'event_type'           => 'LOGIN',
                    'result'               => rand(0, 9) > 0 ? 'SUCCESS' : 'FAIL',
                    'reason'               => rand(0, 9) > 0 ? 'Authorized' : 'Not Authorized',
                    'student_external_id'  => $studentId,
                    'student_name'         => $studentName,
                    'course'               => $course,
                ]);
            }
        }
    }
}