<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NextOfKinSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('next_of_kins')->count() > 0) {
            $this->command->info('Next of kin already seeded, skipping.');
            return;
        }

        $noks = [
            [1,  'Roberto Santos',    'Son',      'Purok 4, Bulua, CDO',       '09172000001'],
            [2,  'Carlos Reyes',      'Son',      'Purok 7, Lapasan, CDO',     '09182000002'],
            [3,  'Cristina Garcia',   'Daughter', 'Barangay 4, CDO',           '09192000003'],
            [4,  'Mario Dela Cruz',   'Husband',  'Gusa, CDO',                 '09202000004'],
            [5,  'Luisa Flores',      'Wife',     'Nazareth, CDO',             '09212000005'],
            [6,  'Ramon Bautista',    'Son',      'Camaman-an, CDO',           '09222000006'],
            [7,  'Celia Villanueva',  'Wife',     'Carmen, CDO',               '09232000007'],
            [8,  'Tomas Cruz',        'Son',      'Macabalan, CDO',            '09242000008'],
            [9,  'Elena Torres',      'Wife',     'Cugman, CDO',               '09252000009'],
            [10, 'Raul Gonzales',     'Son',      'Balulang, CDO',             '09262000010'],
            [11, 'Josefina Mendoza',  'Wife',     'Iponan, CDO',               '09272000011'],
            [12, 'Ernesto Ramos',     'Son',      'Agusan, CDO',               '09282000012'],
            [13, 'Perla Diaz',        'Daughter', 'Consolacion, CDO',          '09292000013'],
            [14, 'Alejandro Morales', 'Husband',  'Puerto, CDO',               '09302000014'],
            [15, 'Patricia Aquino',   'Wife',     'Kauswagan, CDO',            '09172000015'],
            [16, 'Vicente Reyes',     'Son',      'Barangay 17, CDO',          '09182000016'],
            [17, 'Amelita Buenaventura','Daughter','Lapasan, CDO',             '09192000017'],
            [18, 'Domingo Salazar',   'Husband',  'Bulua, CDO',                '09202000018'],
            [19, 'Rowena Pascual',    'Wife',     'Gusa, CDO',                 '09212000019'],
            [20, 'Arturo Navarro',    'Son',      'Nazareth, CDO',             '09222000020'],
            [21, 'Glenda Padilla',    'Wife',     'Camaman-an, CDO',           '09232000021'],
            [22, 'Jorge Castillo',    'Son',      'Carmen, CDO',               '09242000022'],
            [23, 'Divina Soriano',    'Daughter', 'Barangay 9, CDO',           '09252000023'],
            [24, 'Benjamin Marcelo',  'Son',      'Macabalan, CDO',            '09262000024'],
            [25, 'Violeta Guerrero',  'Wife',     'Indahag, CDO',              '09272000025'],
            [26, 'Ernesto Aguilar',   'Son',      'Cugman, CDO',               '09282000026'],
            [27, 'Carina Miranda',    'Daughter', 'Balulang, CDO',             '09292000027'],
            [28, 'Nestor Medina',     'Husband',  'Iponan, CDO',               '09302000028'],
            [29, 'Alicia Vargas',     'Wife',     'Agusan, CDO',               '09172000029'],
            [30, 'Norberto Ibarra',   'Son',      'Consolacion, CDO',          '09182000030'],
            [31, 'Maricel Delos Santos','Daughter','Puerto, CDO',              '09192000031'],
            [32, 'Ricardo Ocampo',    'Husband',  'Kauswagan, CDO',            '09202000032'],
            [33, 'Evelyn Reyes',      'Wife',     'Barangay 22, CDO',          '09212000033'],
            [34, 'Leonardo Abad',     'Son',      'Lapasan, CDO',              '09222000034'],
            [35, 'Gertrudes Jimenez', 'Daughter', 'Gusa, CDO',                 '09232000035'],
            [36, 'Arsenio Cabrera',   'Son',      'Nazareth, CDO',             '09242000036'],
            [37, 'Josefina Pineda',   'Wife',     'Camaman-an, CDO',           '09252000037'],
            [38, 'Dennis Alvarez',    'Son',      'Carmen, CDO',               '09262000038'],
            [39, 'Maricel Guevarra',  'Daughter', 'Macabalan, CDO',            '09272000039'],
            [40, 'Renato Lim',        'Husband',  'Indahag, CDO',              '09282000040'],
            [41, 'Rowena Dela Torre', 'Daughter', 'Cugman, CDO',               '09292000041'],
            [42, 'Ernesto Reyes',     'Son',      'Balulang, CDO',             '09302000042'],
            [43, 'Patricia Santiago', 'Wife',     'Iponan, CDO',               '09172000043'],
            [44, 'Marco Fernandez',   'Son',      'Agusan, CDO',               '09182000044'],
            [45, 'Irene Herrera',     'Wife',     'Consolacion, CDO',          '09192000045'],
            [46, 'Antonio Dela Rosa', 'Son',      'Puerto, CDO',               '09202000046'],
            [47, 'Sheila Bondoc',     'Daughter', 'Kauswagan, CDO',            '09212000047'],
            [48, 'Bernard Manalo',    'Son',      'Barangay 34, CDO',          '09222000048'],
            [49, 'Carla Perez',       'Daughter', 'Lapasan, CDO',              '09232000049'],
            [50, 'Roberto Sarmiento', 'Son',      'Gusa, CDO',                 '09242000050'],
            [51, 'Lorna Velasco',     'Wife',     'Nazareth, CDO',             '09252000051'],
            [52, 'Alfonso Belen',     'Son',      'Camaman-an, CDO',           '09262000052'],
            [53, 'Maricel Corpus',    'Daughter', 'Carmen, CDO',               '09272000053'],
            [54, 'Ramon Enriquez',    'Husband',  'Macabalan, CDO',            '09282000054'],
            [55, 'Elena Gutierrez',   'Wife',     'Indahag, CDO',              '09292000055'],
            [56, 'Rodrigo Lacson',    'Son',      'Cugman, CDO',               '09302000056'],
            [57, 'Cristina Mateo',    'Daughter', 'Balulang, CDO',             '09172000057'],
            [58, 'Alejandro Natividad','Husband', 'Iponan, CDO',               '09182000058'],
            [59, 'Marites Oblena',    'Wife',     'Agusan, CDO',               '09192000059'],
            [60, 'Jose Patriarca',    'Son',      'Consolacion, CDO',          '09202000060'],
            [61, 'Gloria Quiambao',   'Wife',     'Puerto, CDO',               '09212000061'],
            [62, 'Eduardo Robredo',   'Son',      'Kauswagan, CDO',            '09222000062'],
            [63, 'Anita Soriano',     'Daughter', 'Barangay 40, CDO',          '09232000063'],
            [64, 'Renato Tadena',     'Husband',  'Lapasan, CDO',              '09242000064'],
            [65, 'Josefa Umali',      'Daughter', 'Gusa, CDO',                 '09252000065'],
            [66, 'Carlos Valencia',   'Son',      'Nazareth, CDO',             '09262000066'],
            [67, 'Nelia Yap',         'Wife',     'Camaman-an, CDO',           '09272000067'],
            [68, 'Rodrigo Zamora',    'Son',      'Carmen, CDO',               '09282000068'],
            [69, 'Cristina Abrenica', 'Daughter', 'Macabalan, CDO',            '09292000069'],
            [70, 'Alfonso Balois',    'Husband',  'Indahag, CDO',              '09302000070'],
            [71, 'Teresita Cadiz',    'Wife',     'Cugman, CDO',               '09172000071'],
            [72, 'Pedro Daza',        'Son',      'Balulang, CDO',             '09182000072'],
            [73, 'Marita Espino',     'Wife',     'Iponan, CDO',               '09192000073'],
            [74, 'Ernesto Feria',     'Son',      'Agusan, CDO',               '09202000074'],
            [75, 'Maria Gatmaitan',   'Daughter', 'Consolacion, CDO',          '09212000075'],
            [76, 'Antonio Hilario',   'Son',      'Puerto, CDO',               '09222000076'],
            [77, 'Carmelita Imperial','Wife',     'Kauswagan, CDO',            '09232000077'],
            [78, 'Jose Javier',       'Husband',  'Barangay 12, CDO',          '09242000078'],
            [79, 'Sheila Kimpo',      'Daughter', 'Lapasan, CDO',              '09252000079'],
            [80, 'Rodrigo Llamas',    'Son',      'Gusa, CDO',                 '09262000080'],
            [81, 'Gloria Maceda',     'Wife',     'Nazareth, CDO',             '09272000081'],
            [82, 'Eduardo Narciso',   'Son',      'Camaman-an, CDO',           '09282000082'],
            [83, 'Evelyn Ochoa',      'Wife',     'Carmen, CDO',               '09292000083'],
            [84, 'Ramon Pelayo',      'Son',      'Macabalan, CDO',            '09302000084'],
            [85, 'Marites Quezon',    'Wife',     'Indahag, CDO',              '09172000085'],
            [86, 'Jose Regalado',     'Son',      'Cugman, CDO',               '09182000086'],
            [87, 'Carmen Salcedo',    'Daughter', 'Balulang, CDO',             '09192000087'],
            [88, 'Rodrigo Tanedo',    'Son',      'Iponan, CDO',               '09202000088'],
            [89, 'Cristina Ubaldo',   'Wife',     'Agusan, CDO',               '09212000089'],
            [90, 'Pedro Varona',      'Son',      'Consolacion, CDO',          '09222000090'],
            [91, 'Maria Waga',        'Daughter', 'Puerto, CDO',               '09232000091'],
            [92, 'Jose Ybanez',       'Son',      'Kauswagan, CDO',            '09242000092'],
            [93, 'Gloria Zabala',     'Wife',     'Barangay 4, CDO',           '09252000093'],
            [94, 'Ramon Abella',      'Son',      'Lapasan, CDO',              '09262000094'],
            [95, 'Marites Boquiren',  'Daughter', 'Gusa, CDO',                 '09272000095'],
            [96, 'Jose Cainglet',     'Son',      'Nazareth, CDO',             '09282000096'],
            [97, 'Gloria Dacanay',    'Wife',     'Camaman-an, CDO',           '09292000097'],
            [98, 'Ramon Empleo',      'Son',      'Carmen, CDO',               '09302000098'],
            [99, 'Cristina Fontanilla','Daughter','Macabalan, CDO',            '09172000099'],
            [100,'Jose Guzman',       'Son',      'Indahag, CDO',              '09182000100'],
        ];

        foreach ($noks as $nok) {
            DB::table('next_of_kins')->insert([
                'patient_id'   => $nok[0],
                'full_name'    => $nok[1],
                'relationship' => $nok[2],
                'address'      => $nok[3],
                'phone_number' => $nok[4],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        $this->command->info('Next of kin seeded successfully.');
    }
}
