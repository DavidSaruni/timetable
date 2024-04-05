<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'title' => 'Eng',
                'name' => 'Samuel Uzima',
                'email' => 'uzimasamuel1@gmail.com',
                'password' => '23+67Timetable',
                'role' => 'USER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Titus Suge',
                'email' => 'sugetitus@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Edwin Akumu',
                'email' => 'oakumu@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Richard Kagia',
                'email' => 'rkagia@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Mary Murithii',
                'email' => 'mmurithii@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Jim Amisi',
                'email' => 'jamisi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'James Meroka',
                'email' => 'jonsinyo@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Sarah Vugigi',
                'email' => 'svugigi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Vincent Nyandoro',
                'email' => 'vnyandoro@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Kelvin Manyega',
                'email' => 'kelvinmanyega@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Wairimu Karaihira',
                'email' => 'wkaraihira@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Nahashon Gichana Akunga',
                'email' => 'nakunga@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Elizabeth Odongo',
                'email' => 'elizabethodongo@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Sellah Kebenei ',
                'email' => 'SKebenei @kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Caroline Chepkirui ',
                'email' => 'chepkiruicaroline@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Margaret Wahome',
                'email' => 'margaretwahome@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Micah Lagat',
                'email' => 'lagatmicah@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Ferdinand Ndubi',
                'email' => 'flwafula@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Rose Obat',
                'email' => 'roseobat@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Zacchaeus Rotich',
                'email' => 'zrotich@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Julia Janet Ouma',
                'email' => 'janetouma@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Pamela Kimeto',
                'email' => 'p_kimeto@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Rahab Wakuraya',
                'email' => 'rmureithi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Michael Walekhwa',
                'email' => 'mwalekhwa@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Charles Wambugu',
                'email' => 'cwmwangi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Jeremiah Bundotich',
                'email' => 'jbundotich@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Teresa Kerubo',
                'email' => 'tkerubo@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Jeremiah Ongori',
                'email' => 'jongori@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mrs.',
                'name' => 'Ann Somba',
                'email' => 'SAnne@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Emily Tumwet',
                'email' => 'ETumwet@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Wilson Balongo',
                'email' => 'balongo@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Walter Rono',
                'email' => 'wkrono@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Amos Kandagor',
                'email' => 'akandagor@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Rose Keter',
                'email' => 'rjketer@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Lydia Momanyi',
                'email' => 'null@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Jediel Muriu',
                'email' => 'jnull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Elizabeth Ogaja',
                'email' => 'eogaja@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Alex Mwangi',
                'email' => 'mnull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Grace Otieno',
                'email' => 'gnull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Emmanuel Owino',
                'email' => 'eowino@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Alice Murugi',
                'email' => 'lmurugi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Elsie Salano',
                'email' => 'snull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Titus Masai Shapaya',
                'email' => 'tnull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Rugiri Peter Githara',
                'email' => 'PRugiri@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Petronilla Mumbua',
                'email' => 'PMumbua@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Faith Kosgei',
                'email' => 'kosgeifaith@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Markson Kipyego Rugut',
                'email' => 'marksonrugut@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Geoffrey Emenyi',
                'email' => 'gemenyi@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Kenneth Kibet Karoney',
                'email' => 'kkaroney@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mrs.',
                'name' => 'Winny Bor',
                'email' => 'wbnull@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Joel Koima',
                'email' => 'joelkoima@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Ms.',
                'name' => 'Siita Gertrude',
                'email' => 'gsiita@kabark.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Hillary Kosgei',
                'email' => 'hillarykosgei@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ],
            [
                'title' => 'Mr.',
                'name' => 'Calvince Omondi',
                'email' => 'calvince@kabarak.ac.ke',
                'password' => '23+67Timetable',
                'role' => 'LECTURER',
            ]
        ];

        foreach ($usersData as $userData) {
            if (User::where('email', $userData['email'])->first()) {
                continue;
            }
            User::create($userData);
        }

        $this->command->info('Users seeded successfully');
    }
}
