<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WellmeadowsSeeder extends Seeder
{
    public function run(): void
    {
        // ================================================================
        //  WARDS (uses existing wards table from leader's migration)
        // ================================================================
        $this->command->info('Seeding wards...');

        $wards = [
            ['name' => 'General Medicine Ward', 'floor' => 1, 'capacity' => 24],
            ['name' => 'Surgical Ward', 'floor' => 1, 'capacity' => 20],
            ['name' => 'Pediatric Ward', 'floor' => 1, 'capacity' => 18],
            ['name' => 'Maternity Ward', 'floor' => 1, 'capacity' => 16],
            ['name' => 'Orthopedic Ward', 'floor' => 2, 'capacity' => 20],
            ['name' => 'Cardiology Ward', 'floor' => 2, 'capacity' => 16],
            ['name' => 'Neurology Ward', 'floor' => 3, 'capacity' => 14],
            ['name' => 'Geriatric Ward', 'floor' => 1, 'capacity' => 24],
            ['name' => 'Emergency Ward', 'floor' => 0, 'capacity' => 20],
            ['name' => 'Out-Patient Clinic', 'floor' => 0, 'capacity' => 28],
        ];

        foreach ($wards as $ward) {
            DB::table('wards')->insertOrIgnore([
                ...$ward,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ================================================================
        //  PATIENTS (100 Filipino CDO-based patients)
        // ================================================================
        $this->command->info('Seeding 100 patients...');

        $patients = [
            ['Juan', 'Santos', '1945-03-12', 'M', 'Married', 'Purok 4, Bulua, Cagayan de Oro', '09171000001', 'juan.santos@gmail.com', 'A+', 'None', 'Hypertension', '2025-01-05'],
            ['Maria', 'Reyes', '1938-07-24', 'F', 'Widowed', 'Purok 2, Lapasan, Cagayan de Oro', '09181000002', 'maria.reyes@gmail.com', 'B+', 'Penicillin', 'Diabetes Type 2', '2025-01-07'],
            ['Pedro', 'Garcia', '1950-11-03', 'M', 'Married', 'Barangay 4, Cagayan de Oro', '09191000003', 'pedro.garcia@gmail.com', 'O+', 'None', 'Osteoarthritis', '2025-01-10'],
            ['Rosario', 'Dela Cruz', '1942-05-18', 'F', 'Married', 'Gusa, Cagayan de Oro', '09201000004', 'rosario.delacruz@gmail.com', 'A-', 'Aspirin', 'Coronary Artery Disease', '2025-01-12'],
            ['Eduardo', 'Flores', '1955-09-30', 'M', 'Married', 'Nazareth, Cagayan de Oro', '09211000005', 'eduardo.flores@gmail.com', 'B-', 'None', 'Chronic Kidney Disease', '2025-01-15'],
            ['Consolacion', 'Bautista', '1948-02-14', 'F', 'Widowed', 'Camaman-an, Cagayan de Oro', '09221000006', 'consolacion.bautista@gmail.com', 'AB+', 'Sulfa', 'COPD', '2025-01-18'],
            ['Amado', 'Villanueva', '1952-06-07', 'M', 'Married', 'Carmen, Cagayan de Oro', '09231000007', 'amado.villanueva@gmail.com', 'O-', 'None', 'Stroke (Ischemic)', '2025-01-20'],
            ['Leonora', 'Cruz', '1939-12-22', 'F', 'Widowed', 'Macabalan, Cagayan de Oro', '09241000008', 'leonora.cruz@gmail.com', 'A+', 'None', 'Alzheimer\'s Disease', '2025-01-22'],
            ['Bernardo', 'Torres', '1946-08-16', 'M', 'Married', 'Cugman, Cagayan de Oro', '09251000009', 'bernardo.torres@gmail.com', 'B+', 'Ibuprofen', 'Hip Fracture', '2025-01-25'],
            ['Remedios', 'Gonzales', '1943-04-09', 'F', 'Married', 'Balulang, Cagayan de Oro', '09261000010', 'remedios.gonzales@gmail.com', 'O+', 'None', 'Atrial Fibrillation', '2025-01-28'],
            ['Alfredo', 'Mendoza', '1957-01-27', 'M', 'Married', 'Iponan, Cagayan de Oro', '09271000011', 'alfredo.mendoza@gmail.com', 'A+', 'None', 'Pneumonia', '2025-02-01'],
            ['Teresita', 'Ramos', '1940-10-05', 'F', 'Widowed', 'Agusan, Cagayan de Oro', '09281000012', 'teresita.ramos@gmail.com', 'B+', 'Penicillin', 'UTI', '2025-02-03'],
            ['Victorino', 'Diaz', '1953-07-14', 'M', 'Separated', 'Consolacion, Cagayan de Oro', '09291000013', 'victorino.diaz@gmail.com', 'AB-', 'None', 'Parkinson\'s Disease', '2025-02-05'],
            ['Erlinda', 'Morales', '1947-03-28', 'F', 'Married', 'Puerto, Cagayan de Oro', '09301000014', 'erlinda.morales@gmail.com', 'O+', 'None', 'Osteoporosis', '2025-02-08'],
            ['Celestino', 'Aquino', '1960-11-19', 'M', 'Married', 'Kauswagan, Cagayan de Oro', '09171000015', 'celestino.aquino@gmail.com', 'A+', 'None', 'Congestive Heart Failure', '2025-02-10'],
            ['Natividad', 'Reyes', '1936-06-02', 'F', 'Widowed', 'Barangay 17, Cagayan de Oro', '09181000016', 'natividad.reyes@gmail.com', 'B-', 'Codeine', 'Dementia', '2025-02-12'],
            ['Gregorio', 'Buenaventura', '1949-09-11', 'M', 'Married', 'Lapasan, Cagayan de Oro', '09191000017', 'gregorio.buenaventura@gmail.com', 'O+', 'None', 'Peptic Ulcer', '2025-02-15'],
            ['Esperanza', 'Salazar', '1944-01-30', 'F', 'Married', 'Bulua, Cagayan de Oro', '09201000018', 'esperanza.salazar@gmail.com', 'A-', 'None', 'Deep Vein Thrombosis', '2025-02-18'],
            ['Rodrigo', 'Pascual', '1958-05-23', 'M', 'Married', 'Gusa, Cagayan de Oro', '09211000019', 'rodrigo.pascual@gmail.com', 'B+', 'None', 'Lumbar Spondylosis', '2025-02-20'],
            ['Felicidad', 'Navarro', '1941-08-07', 'F', 'Widowed', 'Nazareth, Cagayan de Oro', '09221000020', 'felicidad.navarro@gmail.com', 'O+', 'None', 'Anemia', '2025-02-22'],
            ['Aurelio', 'Padilla', '1954-04-15', 'M', 'Married', 'Camaman-an, Cagayan de Oro', '09231000021', 'aurelio.padilla@gmail.com', 'A+', 'None', 'Hypertension, Diabetes', '2025-03-01'],
            ['Carmelita', 'Castillo', '1937-12-28', 'F', 'Widowed', 'Carmen, Cagayan de Oro', '09241000022', 'carmelita.castillo@gmail.com', 'B+', 'None', 'Rheumatoid Arthritis', '2025-03-03'],
            ['Domingo', 'Soriano', '1962-07-04', 'M', 'Married', 'Barangay 9, Cagayan de Oro', '09251000023', 'domingo.soriano@gmail.com', 'O-', 'None', 'Femur Fracture', '2025-03-05'],
            ['Visitacion', 'Marcelo', '1945-02-17', 'F', 'Separated', 'Macabalan, Cagayan de Oro', '09261000024', 'visitacion.marcelo@gmail.com', 'A+', 'None', 'Chronic Heart Failure', '2025-03-08'],
            ['Proceso', 'Guerrero', '1951-10-08', 'M', 'Married', 'Indahag, Cagayan de Oro', '09271000025', 'proceso.guerrero@gmail.com', 'B+', 'None', 'Urinary Retention', '2025-03-10'],
            ['Eduvigis', 'Aguilar', '1939-06-20', 'F', 'Widowed', 'Cugman, Cagayan de Oro', '09281000026', 'eduvigis.aguilar@gmail.com', 'O+', 'None', 'Pulmonary Embolism', '2025-03-12'],
            ['Lucio', 'Miranda', '1956-03-14', 'M', 'Married', 'Balulang, Cagayan de Oro', '09291000027', 'lucio.miranda@gmail.com', 'A-', 'None', 'Transient Ischemic Attack', '2025-03-15'],
            ['Adoracion', 'Medina', '1943-11-26', 'F', 'Married', 'Iponan, Cagayan de Oro', '09301000028', 'adoracion.medina@gmail.com', 'B+', 'None', 'Cataract (bilateral)', '2025-03-18'],
            ['Simeon', 'Vargas', '1948-08-03', 'M', 'Married', 'Agusan, Cagayan de Oro', '09171000029', 'simeon.vargas@gmail.com', 'O+', 'None', 'Prostate Hyperplasia', '2025-03-20'],
            ['Purificacion', 'Ibarra', '1935-04-09', 'F', 'Widowed', 'Consolacion, Cagayan de Oro', '09181000030', 'purificacion.ibarra@gmail.com', 'A+', 'None', 'Hypothyroidism', '2025-03-22'],
            ['Iluminado', 'Delos Santos', '1964-01-18', 'M', 'Married', 'Puerto, Cagayan de Oro', '09191000031', 'iluminado.delossantos@gmail.com', 'B+', 'None', 'Hypertension', '2025-04-01'],
            ['Angelita', 'Ocampo', '1946-09-05', 'F', 'Married', 'Kauswagan, Cagayan de Oro', '09201000032', 'angelita.ocampo@gmail.com', 'O-', 'Aspirin', 'Diabetes Type 2', '2025-04-03'],
            ['Ruperto', 'Reyes', '1953-05-29', 'M', 'Married', 'Barangay 22, Cagayan de Oro', '09211000033', 'ruperto.reyes@gmail.com', 'A+', 'None', 'COPD', '2025-04-05'],
            ['Dolores', 'Abad', '1940-02-11', 'F', 'Widowed', 'Lapasan, Cagayan de Oro', '09221000034', 'dolores.abad@gmail.com', 'B-', 'None', 'Osteoporosis', '2025-04-08'],
            ['Saturnino', 'Jimenez', '1959-12-24', 'M', 'Separated', 'Gusa, Cagayan de Oro', '09231000035', 'saturnino.jimenez@gmail.com', 'O+', 'None', 'Lumbar Spondylosis', '2025-04-10'],
            ['Soledad', 'Cabrera', '1942-07-16', 'F', 'Married', 'Nazareth, Cagayan de Oro', '09241000036', 'soledad.cabrera@gmail.com', 'A+', 'Penicillin', 'Anemia', '2025-04-12'],
            ['Maximo', 'Pineda', '1950-03-07', 'M', 'Married', 'Camaman-an, Cagayan de Oro', '09251000037', 'maximo.pineda@gmail.com', 'B+', 'None', 'Congestive Heart Failure', '2025-04-15'],
            ['Candelaria', 'Alvarez', '1936-10-20', 'F', 'Widowed', 'Carmen, Cagayan de Oro', '09261000038', 'candelaria.alvarez@gmail.com', 'O+', 'None', 'Dementia', '2025-04-18'],
            ['Florentino', 'Guevarra', '1957-06-13', 'M', 'Married', 'Macabalan, Cagayan de Oro', '09271000039', 'florentino.guevarra@gmail.com', 'A-', 'None', 'Peptic Ulcer', '2025-04-20'],
            ['Resurreccion', 'Lim', '1944-01-25', 'F', 'Married', 'Indahag, Cagayan de Oro', '09281000040', 'resurreccion.lim@gmail.com', 'B+', 'None', 'Atrial Fibrillation', '2025-04-22'],
            ['Hermogenes', 'Dela Torre', '1963-09-08', 'M', 'Married', 'Cugman, Cagayan de Oro', '09291000041', 'hermogenes.delatorre@gmail.com', 'O+', 'None', 'Stroke (Ischemic)', '2025-05-01'],
            ['Magdalena', 'Reyes', '1938-05-21', 'F', 'Widowed', 'Balulang, Cagayan de Oro', '09301000042', 'magdalena.reyes@gmail.com', 'A+', 'None', 'Alzheimer\'s Disease', '2025-05-03'],
            ['Timoteo', 'Santiago', '1952-02-14', 'M', 'Married', 'Iponan, Cagayan de Oro', '09171000043', 'timoteo.santiago@gmail.com', 'B+', 'None', 'Hip Fracture', '2025-05-05'],
            ['Corazon', 'Fernandez', '1947-11-27', 'F', 'Married', 'Agusan, Cagayan de Oro', '09181000044', 'corazon.fernandez@gmail.com', 'O-', 'None', 'Osteoarthritis', '2025-05-08'],
            ['Bartolome', 'Herrera', '1955-08-10', 'M', 'Married', 'Consolacion, Cagayan de Oro', '09191000045', 'bartolome.herrera@gmail.com', 'A+', 'Sulfa', 'Coronary Artery Disease', '2025-05-10'],
            ['Presentacion', 'Dela Rosa', '1941-04-03', 'F', 'Widowed', 'Puerto, Cagayan de Oro', '09201000046', 'presentacion.delarosa@gmail.com', 'B+', 'None', 'Hypertension', '2025-05-12'],
            ['Crisostomo', 'Bondoc', '1961-12-16', 'M', 'Married', 'Kauswagan, Cagayan de Oro', '09211000047', 'crisostomo.bondoc@gmail.com', 'O+', 'None', 'Chronic Kidney Disease', '2025-05-15'],
            ['Epifania', 'Manalo', '1943-07-29', 'F', 'Married', 'Barangay 34, Cagayan de Oro', '09221000048', 'epifania.manalo@gmail.com', 'A-', 'None', 'Rheumatoid Arthritis', '2025-05-18'],
            ['Exequiel', 'Perez', '1948-03-22', 'M', 'Separated', 'Lapasan, Cagayan de Oro', '09231000049', 'exequiel.perez@gmail.com', 'B+', 'Ibuprofen', 'Lumbar Spondylosis', '2025-05-20'],
            ['Milagros', 'Sarmiento', '1935-10-15', 'F', 'Widowed', 'Gusa, Cagayan de Oro', '09241000050', 'milagros.sarmiento@gmail.com', 'O+', 'None', 'Anemia', '2025-05-22'],
            ['Esteban', 'Velasco', '1966-06-08', 'M', 'Married', 'Nazareth, Cagayan de Oro', '09251000051', 'esteban.velasco@gmail.com', 'A+', 'None', 'Hypertension', '2025-06-01'],
            ['Rufina', 'Belen', '1940-02-21', 'F', 'Widowed', 'Camaman-an, Cagayan de Oro', '09261000052', 'rufina.belen@gmail.com', 'B+', 'None', 'Diabetes Type 2', '2025-06-03'],
            ['Meliton', 'Corpus', '1954-11-04', 'M', 'Married', 'Carmen, Cagayan de Oro', '09271000053', 'meliton.corpus@gmail.com', 'O-', 'None', 'COPD', '2025-06-05'],
            ['Imelda', 'Enriquez', '1946-08-17', 'F', 'Married', 'Macabalan, Cagayan de Oro', '09281000054', 'imelda.enriquez@gmail.com', 'A+', 'Penicillin', 'Osteoporosis', '2025-06-08'],
            ['Demetrio', 'Gutierrez', '1960-04-30', 'M', 'Married', 'Indahag, Cagayan de Oro', '09291000055', 'demetrio.gutierrez@gmail.com', 'B-', 'None', 'Prostate Hyperplasia', '2025-06-10'],
            ['Primitiva', 'Lacson', '1937-01-13', 'F', 'Widowed', 'Cugman, Cagayan de Oro', '09301000056', 'primitiva.lacson@gmail.com', 'O+', 'None', 'Hypothyroidism', '2025-06-12'],
            ['Abundio', 'Mateo', '1949-09-26', 'M', 'Married', 'Balulang, Cagayan de Oro', '09171000057', 'abundio.mateo@gmail.com', 'A+', 'None', 'Peptic Ulcer', '2025-06-15'],
            ['Consuelo', 'Natividad', '1944-06-09', 'F', 'Married', 'Iponan, Cagayan de Oro', '09181000058', 'consuelo.natividad@gmail.com', 'B+', 'None', 'Deep Vein Thrombosis', '2025-06-18'],
            ['Juanito', 'Oblena', '1958-02-22', 'M', 'Married', 'Agusan, Cagayan de Oro', '09191000059', 'juanito.oblena@gmail.com', 'O+', 'Codeine', 'Congestive Heart Failure', '2025-06-20'],
            ['Felipa', 'Patriarca', '1941-11-05', 'F', 'Widowed', 'Consolacion, Cagayan de Oro', '09201000060', 'felipa.patriarca@gmail.com', 'A-', 'None', 'Dementia', '2025-06-22'],
            ['Arsenio', 'Quiambao', '1953-07-18', 'M', 'Married', 'Puerto, Cagayan de Oro', '09211000061', 'arsenio.quiambao@gmail.com', 'B+', 'None', 'Atrial Fibrillation', '2025-07-01'],
            ['Norberta', 'Robredo', '1939-04-01', 'F', 'Widowed', 'Kauswagan, Cagayan de Oro', '09221000062', 'norberta.robredo@gmail.com', 'O+', 'None', 'Osteoarthritis', '2025-07-03'],
            ['Glicerio', 'Soriano', '1965-01-14', 'M', 'Married', 'Barangay 40, Cagayan de Oro', '09231000063', 'glicerio.soriano@gmail.com', 'A+', 'None', 'Hypertension', '2025-07-05'],
            ['Asuncion', 'Tadena', '1942-10-27', 'F', 'Married', 'Lapasan, Cagayan de Oro', '09241000064', 'asuncion.tadena@gmail.com', 'B-', 'Aspirin', 'Coronary Artery Disease', '2025-07-08'],
            ['Macario', 'Umali', '1956-07-10', 'M', 'Separated', 'Gusa, Cagayan de Oro', '09251000065', 'macario.umali@gmail.com', 'O+', 'None', 'Chronic Kidney Disease', '2025-07-10'],
            ['Visitacion', 'Valencia', '1943-03-23', 'F', 'Married', 'Nazareth, Cagayan de Oro', '09261000066', 'visitacion.valencia@gmail.com', 'A+', 'None', 'Anemia', '2025-07-12'],
            ['Wenceslao', 'Yap', '1951-12-06', 'M', 'Married', 'Camaman-an, Cagayan de Oro', '09271000067', 'wenceslao.yap@gmail.com', 'B+', 'None', 'Stroke (Ischemic)', '2025-07-15'],
            ['Zenaida', 'Zamora', '1938-08-19', 'F', 'Widowed', 'Carmen, Cagayan de Oro', '09281000068', 'zenaida.zamora@gmail.com', 'O-', 'None', 'Alzheimer\'s Disease', '2025-07-18'],
            ['Patricio', 'Abrenica', '1960-05-02', 'M', 'Married', 'Macabalan, Cagayan de Oro', '09291000069', 'patricio.abrenica@gmail.com', 'A+', 'None', 'Hip Fracture', '2025-07-20'],
            ['Lilia', 'Balois', '1947-01-15', 'F', 'Married', 'Indahag, Cagayan de Oro', '09301000070', 'lilia.balois@gmail.com', 'B+', 'None', 'Pulmonary Embolism', '2025-07-22'],
            ['Victorino', 'Cadiz', '1955-10-28', 'M', 'Married', 'Cugman, Cagayan de Oro', '09171000071', 'victorino.cadiz@gmail.com', 'O+', 'None', 'Parkinson\'s Disease', '2025-08-01'],
            ['Encarnacion', 'Daza', '1940-07-11', 'F', 'Widowed', 'Balulang, Cagayan de Oro', '09181000072', 'encarnacion.daza@gmail.com', 'A-', 'None', 'Hypothyroidism', '2025-08-03'],
            ['Marciano', 'Espino', '1963-03-24', 'M', 'Married', 'Iponan, Cagayan de Oro', '09191000073', 'marciano.espino@gmail.com', 'B+', 'None', 'Lumbar Spondylosis', '2025-08-05'],
            ['Juana', 'Feria', '1944-12-07', 'F', 'Married', 'Agusan, Cagayan de Oro', '09201000074', 'juana.feria@gmail.com', 'O+', 'Penicillin', 'Osteoporosis', '2025-08-08'],
            ['Rosendo', 'Gatmaitan', '1958-08-20', 'M', 'Married', 'Consolacion, Cagayan de Oro', '09211000075', 'rosendo.gatmaitan@gmail.com', 'A+', 'None', 'Coronary Artery Disease', '2025-08-10'],
            ['Severina', 'Hilario', '1936-05-03', 'F', 'Widowed', 'Puerto, Cagayan de Oro', '09221000076', 'severina.hilario@gmail.com', 'B-', 'None', 'Dementia', '2025-08-12'],
            ['Gaudencio', 'Imperial', '1950-01-16', 'M', 'Married', 'Kauswagan, Cagayan de Oro', '09231000077', 'gaudencio.imperial@gmail.com', 'O+', 'None', 'Congestive Heart Failure', '2025-08-15'],
            ['Florencia', 'Javier', '1945-10-29', 'F', 'Married', 'Barangay 12, Cagayan de Oro', '09241000078', 'florencia.javier@gmail.com', 'A+', 'None', 'Rheumatoid Arthritis', '2025-08-18'],
            ['Renato', 'Kimpo', '1962-07-12', 'M', 'Separated', 'Lapasan, Cagayan de Oro', '09251000079', 'renato.kimpo@gmail.com', 'B+', 'None', 'COPD', '2025-08-20'],
            ['Herminia', 'Llamas', '1941-03-25', 'F', 'Widowed', 'Gusa, Cagayan de Oro', '09261000080', 'herminia.llamas@gmail.com', 'O-', 'None', 'Atrial Fibrillation', '2025-08-22'],
            ['Quintin', 'Maceda', '1957-12-08', 'M', 'Married', 'Nazareth, Cagayan de Oro', '09271000081', 'quintin.maceda@gmail.com', 'A+', 'None', 'Hypertension', '2025-09-01'],
            ['Gregoria', 'Narciso', '1939-08-21', 'F', 'Widowed', 'Camaman-an, Cagayan de Oro', '09281000082', 'gregoria.narciso@gmail.com', 'B+', 'Sulfa', 'Diabetes Type 2', '2025-09-03'],
            ['Leoncio', 'Ochoa', '1953-05-04', 'M', 'Married', 'Carmen, Cagayan de Oro', '09291000083', 'leoncio.ochoa@gmail.com', 'O+', 'None', 'Urinary Retention', '2025-09-05'],
            ['Norma', 'Pelayo', '1946-01-17', 'F', 'Married', 'Macabalan, Cagayan de Oro', '09301000084', 'norma.pelayo@gmail.com', 'A-', 'None', 'Anemia', '2025-09-08'],
            ['Emiliano', 'Quezon', '1967-10-30', 'M', 'Married', 'Indahag, Cagayan de Oro', '09171000085', 'emiliano.quezon@gmail.com', 'B+', 'None', 'Stroke (Ischemic)', '2025-09-10'],
            ['Dalisay', 'Regalado', '1943-07-13', 'F', 'Married', 'Cugman, Cagayan de Oro', '09181000086', 'dalisay.regalado@gmail.com', 'O+', 'None', 'Osteoarthritis', '2025-09-12'],
            ['Celestino', 'Salcedo', '1951-03-26', 'M', 'Married', 'Balulang, Cagayan de Oro', '09191000087', 'celestino.salcedo@gmail.com', 'A+', 'Ibuprofen', 'Hip Fracture', '2025-09-15'],
            ['Concepcion', 'Tanedo', '1937-12-09', 'F', 'Widowed', 'Iponan, Cagayan de Oro', '09201000088', 'concepcion.tanedo@gmail.com', 'B-', 'None', 'Hypothyroidism', '2025-09-18'],
            ['Domingo', 'Ubaldo', '1960-08-22', 'M', 'Married', 'Agusan, Cagayan de Oro', '09211000089', 'domingo.ubaldo@gmail.com', 'O+', 'None', 'Peptic Ulcer', '2025-09-20'],
            ['Nieves', 'Varona', '1945-05-05', 'F', 'Married', 'Consolacion, Cagayan de Oro', '09221000090', 'nieves.varona@gmail.com', 'A+', 'None', 'Congestive Heart Failure', '2025-09-22'],
            ['Apolinario', 'Waga', '1955-01-18', 'M', 'Married', 'Puerto, Cagayan de Oro', '09231000091', 'apolinario.waga@gmail.com', 'B+', 'None', 'Prostate Hyperplasia', '2025-10-01'],
            ['Margarita', 'Ybanez', '1940-10-01', 'F', 'Widowed', 'Kauswagan, Cagayan de Oro', '09241000092', 'margarita.ybanez@gmail.com', 'O-', 'None', 'Dementia', '2025-10-03'],
            ['Filomeno', 'Zabala', '1964-06-14', 'M', 'Married', 'Barangay 4, Cagayan de Oro', '09251000093', 'filomeno.zabala@gmail.com', 'A+', 'None', 'Hypertension', '2025-10-05'],
            ['Resureccion', 'Abella', '1942-02-27', 'F', 'Married', 'Lapasan, Cagayan de Oro', '09261000094', 'resureccion.abella@gmail.com', 'B+', 'Penicillin', 'Coronary Artery Disease', '2025-10-08'],
            ['Bibiano', 'Boquiren', '1949-11-10', 'M', 'Separated', 'Gusa, Cagayan de Oro', '09271000095', 'bibiano.boquiren@gmail.com', 'O+', 'None', 'Chronic Kidney Disease', '2025-10-10'],
            ['Nena', 'Cainglet', '1935-07-23', 'F', 'Widowed', 'Nazareth, Cagayan de Oro', '09281000096', 'nena.cainglet@gmail.com', 'A-', 'None', 'Alzheimer\'s Disease', '2025-10-12'],
            ['Rodolfo', 'Dacanay', '1968-04-06', 'M', 'Married', 'Camaman-an, Cagayan de Oro', '09291000097', 'rodolfo.dacanay@gmail.com', 'B+', 'None', 'COPD', '2025-10-15'],
            ['Lourdes', 'Empleo', '1944-12-19', 'F', 'Married', 'Carmen, Cagayan de Oro', '09301000098', 'lourdes.empleo@gmail.com', 'O+', 'None', 'Osteoporosis', '2025-10-18'],
            ['Segundo', 'Fontanilla', '1952-09-02', 'M', 'Married', 'Macabalan, Cagayan de Oro', '09171000099', 'segundo.fontanilla@gmail.com', 'A+', 'None', 'Lumbar Spondylosis', '2025-10-20'],
            ['Pilar', 'Guzman', '1941-05-15', 'F', 'Widowed', 'Indahag, Cagayan de Oro', '09181000100', 'pilar.guzman@gmail.com', 'B-', 'None', 'Anemia', '2025-10-22'],
        ];

        foreach ($patients as $p) {
            $patientId = DB::table('patients')->insertGetId([
                'first_name' => $p[0],
                'last_name' => $p[1],
                'date_of_birth' => $p[2],
                'sex' => $p[3],
                'marital_status' => $p[4],
                'address' => $p[5],
                'phone_number' => $p[6],
                'email' => $p[7],
                'blood_type' => $p[8],
                'allergies' => $p[9],
                'medical_conditions' => $p[10],
                'date_registered' => $p[11],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Next of kin for every patient
            DB::table('next_of_kins')->insert([
                'patient_id' => $patientId,
                'full_name' => 'Emergency Contact of ' . $p[0] . ' ' . $p[1],
                'relationship' => 'Spouse/Child',
                'address' => $p[5],
                'phone_number' => '09' . rand(100000000, 999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('100 patients seeded!');

        // ================================================================
        //  ADMISSIONS (first 25 patients admitted to various wards)
        // ================================================================
        $this->command->info('Seeding admissions...');

        $wardIds = DB::table('wards')->pluck('id')->toArray();
        $patientIds = DB::table('patients')->pluck('id')->toArray();

        $admissions = [
            [$patientIds[0], $wardIds[0] ?? 1, 'A-101', '2025-01-10', 14, '2025-01-24', '2025-01-23'],
            [$patientIds[2], $wardIds[1] ?? 2, 'B-201', '2025-01-15', 7, '2025-01-22', '2025-01-21'],
            [$patientIds[4], $wardIds[4] ?? 5, 'E-501', '2025-01-20', 10, '2025-01-30', '2025-01-28'],
            [$patientIds[6], $wardIds[0] ?? 1, 'A-102', '2025-01-25', 5, '2025-01-30', '2025-01-29'],
            [$patientIds[8], $wardIds[2] ?? 3, 'C-301', '2025-01-30', 12, '2025-02-11', '2025-02-10'],
            [$patientIds[10], $wardIds[5] ?? 6, 'F-601', '2025-02-06', 8, '2025-02-14', '2025-02-13'],
            [$patientIds[12], $wardIds[6] ?? 7, 'G-701', '2025-02-10', 6, '2025-02-16', '2025-02-15'],
            [$patientIds[14], $wardIds[7] ?? 8, 'H-801', '2025-02-15', 15, '2025-03-02', '2025-02-28'],
            [$patientIds[16], $wardIds[1] ?? 2, 'B-202', '2025-02-20', 9, '2025-03-01', '2025-02-27'],
            [$patientIds[18], $wardIds[3] ?? 4, 'D-401', '2025-02-25', 7, '2025-03-04', '2025-03-03'],
            // Currently admitted (no actual leave date)
            [$patientIds[20], $wardIds[0] ?? 1, 'A-103', '2025-05-06', 14, '2025-05-20', null],
            [$patientIds[22], $wardIds[2] ?? 3, 'C-302', '2025-05-10', 10, '2025-05-20', null],
            [$patientIds[24], $wardIds[5] ?? 6, 'F-602', '2025-05-15', 7, '2025-05-22', null],
            [$patientIds[26], $wardIds[7] ?? 8, 'H-802', '2025-05-20', 15, '2025-06-04', null],
            [$patientIds[28], $wardIds[1] ?? 2, 'B-203', '2025-05-25', 5, '2025-05-30', null],
        ];

        foreach ($admissions as $a) {
            DB::table('admissions')->insert([
                'patient_id' => $a[0],
                'ward_id' => $a[1],
                'bed_number' => $a[2],
                'date_on_waiting_list' => $a[3],
                'expected_stay_days' => $a[4],
                'date_admitted' => $a[3],
                'date_expected_leave' => $a[5],
                'date_actual_leave' => $a[6],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Admissions seeded!');

        // ================================================================
        //  MEDICAL RECORDS (30 records)
        // ================================================================
        $this->command->info('Seeding medical records...');

        $records = [
            [$patientIds[0], 'Hypertension', 'Amlodipine 5mg daily', '2025-01-10', 'Monitor BP weekly'],
            [$patientIds[1], 'Type 2 Diabetes', 'Metformin 500mg twice daily', '2025-01-08', 'Low sugar diet advised'],
            [$patientIds[2], 'Osteoarthritis', 'Celecoxib 200mg daily', '2025-01-15', 'Physio referral given'],
            [$patientIds[3], 'Coronary Artery Disease', 'Aspirin 80mg, Atorvastatin', '2025-01-13', 'Cardiology follow-up'],
            [$patientIds[4], 'Chronic Kidney Disease', 'Dietary modification', '2025-01-20', 'Nephrology consult'],
            [$patientIds[5], 'COPD', 'Salbutamol inhaler PRN', '2025-01-19', 'Avoid smoke exposure'],
            [$patientIds[6], 'Stroke (Ischemic)', 'Aspirin, Clopidogrel, Rehab', '2025-01-25', 'Neurological monitoring'],
            [$patientIds[7], 'Alzheimer\'s Disease', 'Donepezil 10mg nightly', '2025-01-23', 'Family counseled'],
            [$patientIds[8], 'Hip Fracture', 'ORIF surgery, PT', '2025-01-30', 'Weight-bearing precautions'],
            [$patientIds[9], 'Atrial Fibrillation', 'Warfarin, Rate control', '2025-01-29', 'INR monitoring required'],
            [$patientIds[10], 'Pneumonia', 'Amoxicillin-Clavulanate IV', '2025-02-06', 'Oxygen support prn'],
            [$patientIds[11], 'UTI', 'Ciprofloxacin 500mg', '2025-02-04', 'Increase fluid intake'],
            [$patientIds[12], 'Parkinson\'s Disease', 'Levodopa-Carbidopa', '2025-02-10', 'Fall risk — bed rails up'],
            [$patientIds[13], 'Osteoporosis', 'Alendronate 70mg weekly', '2025-02-09', 'DXA scan scheduled'],
            [$patientIds[14], 'Congestive Heart Failure', 'Furosemide, Carvedilol', '2025-02-15', 'Daily weight monitoring'],
            [$patientIds[15], 'Dementia', 'Supportive care, Memantine', '2025-02-13', 'Wandering risk assessed'],
            [$patientIds[16], 'Peptic Ulcer', 'Omeprazole 40mg, Amoxicillin', '2025-02-20', 'Avoid NSAIDs'],
            [$patientIds[17], 'Deep Vein Thrombosis', 'Heparin IV, then Warfarin', '2025-02-19', 'Compression stockings'],
            [$patientIds[18], 'Lumbar Spondylosis', 'Tramadol, Physiotherapy', '2025-02-25', 'Avoid heavy lifting'],
            [$patientIds[19], 'Anemia', 'Iron supplementation, B12', '2025-02-23', 'Monthly CBC'],
            [$patientIds[20], 'Hypertension, Diabetes', 'Combination therapy', '2025-03-06', 'Dual condition monitoring'],
            [$patientIds[21], 'Rheumatoid Arthritis', 'Methotrexate, Folic Acid', '2025-03-04', 'Joint protection education'],
            [$patientIds[22], 'Femur Fracture', 'ORIF, Post-op PT', '2025-03-10', 'Non-weight bearing 6 weeks'],
            [$patientIds[23], 'Chronic Heart Failure', 'Digoxin, Spironolactone', '2025-03-09', 'Low sodium diet'],
            [$patientIds[24], 'Urinary Retention', 'Tamsulosin, Catheterization', '2025-03-15', 'Urology referral'],
            [$patientIds[25], 'Pulmonary Embolism', 'Heparin IV, Warfarin', '2025-03-13', 'Bed rest strictly'],
            [$patientIds[26], 'Transient Ischemic Attack', 'Aspirin, Statins', '2025-03-20', 'Brain MRI ordered'],
            [$patientIds[27], 'Cataract (bilateral)', 'Surgery scheduled', '2025-03-19', 'Pre-op clearance done'],
            [$patientIds[28], 'Prostate Hyperplasia', 'Tamsulosin, Finasteride', '2025-03-25', 'Urology monitoring'],
            [$patientIds[29], 'Hypothyroidism', 'Levothyroxine 50mcg daily', '2025-03-23', 'TSH recheck in 6 weeks'],
        ];

        foreach ($records as $r) {
            DB::table('medical_records')->insert([
                'patient_id' => $r[0],
                'diagnosis' => $r[1],
                'treatment' => $r[2],
                'record_date' => $r[3],
                'notes' => $r[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Medical records seeded!');
        $this->command->info('✅ WellmeadowsSeeder complete!');
    }
}
