-- =============================================================
--  WELLMEADOWS HOSPITAL — Complete PostgreSQL Database
--  Convention: PascalCase table names, snake_case column names
--  Data: Filipino / Cagayan de Oro based
-- =============================================================

-- ─── DROP ALL TABLES (dependency order) ───────────────────────
DROP TABLE IF EXISTS WardRequisition CASCADE;
DROP TABLE IF EXISTS RequisitionItem CASCADE;
DROP TABLE IF EXISTS Supplier CASCADE;
DROP TABLE IF EXISTS PatientMedication CASCADE;
DROP TABLE IF EXISTS PharmaceuticalSupply CASCADE;
DROP TABLE IF EXISTS SurgicalSupply CASCADE;
DROP TABLE IF EXISTS PatientAllocation CASCADE;
DROP TABLE IF EXISTS StaffAllocation CASCADE;
DROP TABLE IF EXISTS WorkExperience CASCADE;
DROP TABLE IF EXISTS Qualification CASCADE;
DROP TABLE IF EXISTS OutPatient CASCADE;
DROP TABLE IF EXISTS InPatient CASCADE;
DROP TABLE IF EXISTS Appointment CASCADE;
DROP TABLE IF EXISTS MedicalRecord CASCADE;
DROP TABLE IF EXISTS NextOfKin CASCADE;
DROP TABLE IF EXISTS LocalDoctor CASCADE;
DROP TABLE IF EXISTS Patient CASCADE;
DROP TABLE IF EXISTS Bed CASCADE;
DROP TABLE IF EXISTS Ward CASCADE;
DROP TABLE IF EXISTS Department CASCADE;
DROP TABLE IF EXISTS Staff CASCADE;

-- =============================================================
--  CORE TABLES
-- =============================================================

CREATE TABLE Department (
    dept_id     SERIAL PRIMARY KEY,
    dept_name   VARCHAR(100) NOT NULL,
    location    VARCHAR(100)
);

CREATE TABLE Staff (
    staff_id        SERIAL PRIMARY KEY,
    first_name      VARCHAR(50)  NOT NULL,
    last_name       VARCHAR(50)  NOT NULL,
    address         VARCHAR(200),
    phone_number    VARCHAR(20),
    date_of_birth   DATE,
    sex             CHAR(1) CHECK (sex IN ('M','F')),
    nin             VARCHAR(20)  UNIQUE,
    position        VARCHAR(50),
    current_salary  DECIMAL(12,2),
    salary_scale    VARCHAR(20),
    contract_type   VARCHAR(10)  CHECK (contract_type IN ('Permanent','Temporary')),
    pay_type        VARCHAR(10)  CHECK (pay_type IN ('Weekly','Monthly')),
    hours_per_week  DECIMAL(4,1)
);

CREATE TABLE Ward (
    ward_id         SERIAL PRIMARY KEY,
    dept_id         INT REFERENCES Department(dept_id),
    ward_name       VARCHAR(100) NOT NULL,
    location        VARCHAR(100),
    total_beds      INT,
    tel_extension   VARCHAR(10),
    charge_nurse_id INT REFERENCES Staff(staff_id)
);

CREATE TABLE Bed (
    bed_id      SERIAL PRIMARY KEY,
    ward_id     INT NOT NULL REFERENCES Ward(ward_id),
    bed_number  VARCHAR(10) NOT NULL,
    status      VARCHAR(15) DEFAULT 'Available' CHECK (status IN ('Available','Occupied','Maintenance'))
);

-- =============================================================
--  PATIENT TABLES
-- =============================================================

CREATE TABLE Patient (
    patient_id          SERIAL PRIMARY KEY,
    first_name          VARCHAR(50)  NOT NULL,
    last_name           VARCHAR(50)  NOT NULL,
    address             VARCHAR(200),
    phone_number        VARCHAR(20),
    date_of_birth       DATE,
    sex                 CHAR(1) CHECK (sex IN ('M','F')),
    marital_status      VARCHAR(15)  CHECK (marital_status IN ('Single','Married','Widowed','Separated')),
    date_registered     DATE         DEFAULT CURRENT_DATE
);

CREATE TABLE NextOfKin (
    nok_id          SERIAL PRIMARY KEY,
    patient_id      INT NOT NULL REFERENCES Patient(patient_id) ON DELETE CASCADE,
    full_name       VARCHAR(100) NOT NULL,
    relationship    VARCHAR(50),
    address         VARCHAR(200),
    phone_number    VARCHAR(20)
);

CREATE TABLE LocalDoctor (
    doctor_id       SERIAL PRIMARY KEY,
    full_name       VARCHAR(100) NOT NULL,
    clinic_number   VARCHAR(30)  UNIQUE NOT NULL,
    address         VARCHAR(200),
    phone_number    VARCHAR(20)
);

-- =============================================================
--  STAFF SUPPORT TABLES
-- =============================================================

CREATE TABLE Qualification (
    qual_id         SERIAL PRIMARY KEY,
    staff_id        INT NOT NULL REFERENCES Staff(staff_id) ON DELETE CASCADE,
    qual_type       VARCHAR(100),
    date_obtained   DATE,
    institution     VARCHAR(150)
);

CREATE TABLE WorkExperience (
    exp_id          SERIAL PRIMARY KEY,
    staff_id        INT NOT NULL REFERENCES Staff(staff_id) ON DELETE CASCADE,
    position        VARCHAR(100),
    organization    VARCHAR(150),
    start_date      DATE,
    end_date        DATE
);

CREATE TABLE StaffAllocation (
    allocation_id   SERIAL PRIMARY KEY,
    staff_id        INT NOT NULL REFERENCES Staff(staff_id),
    ward_id         INT NOT NULL REFERENCES Ward(ward_id),
    week_beginning  DATE,
    shift_type      VARCHAR(10) CHECK (shift_type IN ('Early','Late','Night'))
);

-- =============================================================
--  PATIENT ACTIVITY TABLES
-- =============================================================

CREATE TABLE Appointment (
    appointment_id      SERIAL PRIMARY KEY,
    patient_id          INT NOT NULL REFERENCES Patient(patient_id),
    consultant_id       INT NOT NULL REFERENCES Staff(staff_id),
    appointment_date    DATE,
    appointment_time    TIME,
    examination_room    VARCHAR(20),
    outcome             VARCHAR(20) CHECK (outcome IN ('Outpatient','Waiting List','Discharged'))
);

CREATE TABLE InPatient (
    inpatient_id            SERIAL PRIMARY KEY,
    patient_id              INT NOT NULL REFERENCES Patient(patient_id),
    ward_id                 INT NOT NULL REFERENCES Ward(ward_id),
    bed_id                  INT REFERENCES Bed(bed_id),
    date_on_waiting_list    DATE,
    expected_stay_days      INT,
    date_admitted           DATE,
    date_expected_leave     DATE,
    date_actual_leave       DATE
);

CREATE TABLE OutPatient (
    outpatient_id       SERIAL PRIMARY KEY,
    patient_id          INT NOT NULL REFERENCES Patient(patient_id),
    appointment_date    DATE,
    appointment_time    TIME
);

CREATE TABLE MedicalRecord (
    record_id       SERIAL PRIMARY KEY,
    patient_id      INT NOT NULL REFERENCES Patient(patient_id),
    diagnosis       VARCHAR(255),
    treatment       VARCHAR(255),
    record_date     DATE,
    notes           TEXT
);

-- =============================================================
--  SUPPLIES TABLES
-- =============================================================

CREATE TABLE PharmaceuticalSupply (
    drug_id             SERIAL PRIMARY KEY,
    drug_name           VARCHAR(100) NOT NULL,
    description         VARCHAR(255),
    dosage              VARCHAR(50),
    method_of_admin     VARCHAR(30) CHECK (method_of_admin IN ('Oral','IV','Topical','Injection','Inhalation')),
    quantity_in_stock   INT DEFAULT 0,
    reorder_level       INT DEFAULT 10,
    cost_per_unit       DECIMAL(10,2)
);

CREATE TABLE SurgicalSupply (
    item_id             SERIAL PRIMARY KEY,
    item_name           VARCHAR(100) NOT NULL,
    item_type           VARCHAR(20) CHECK (item_type IN ('Surgical','Non-Surgical')),
    description         VARCHAR(255),
    quantity_in_stock   INT DEFAULT 0,
    reorder_level       INT DEFAULT 5,
    cost_per_unit       DECIMAL(10,2)
);

CREATE TABLE Supplier (
    supplier_id     SERIAL PRIMARY KEY,
    supplier_name   VARCHAR(150) NOT NULL,
    address         VARCHAR(200),
    phone_number    VARCHAR(20),
    fax_number      VARCHAR(20)
);

CREATE TABLE PatientMedication (
    medication_id       SERIAL PRIMARY KEY,
    patient_id          INT NOT NULL REFERENCES Patient(patient_id),
    drug_id             INT NOT NULL REFERENCES PharmaceuticalSupply(drug_id),
    units_per_day       INT,
    start_date          DATE,
    end_date            DATE
);

-- =============================================================
--  REQUISITION TABLES
-- =============================================================

CREATE TABLE WardRequisition (
    requisition_id      SERIAL PRIMARY KEY,
    ward_id             INT NOT NULL REFERENCES Ward(ward_id),
    requested_by_id     INT NOT NULL REFERENCES Staff(staff_id),
    requisition_date    DATE,
    signed_by_id        INT REFERENCES Staff(staff_id),
    date_signed         DATE
);

CREATE TABLE RequisitionItem (
    req_item_id         SERIAL PRIMARY KEY,
    requisition_id      INT NOT NULL REFERENCES WardRequisition(requisition_id),
    item_type           VARCHAR(15) CHECK (item_type IN ('Pharmaceutical','Surgical','Non-Surgical')),
    drug_id             INT REFERENCES PharmaceuticalSupply(drug_id),
    item_id             INT REFERENCES SurgicalSupply(item_id),
    quantity_required   INT,
    cost_per_unit       DECIMAL(10,2)
);

-- =============================================================
--  PatientAllocation (replaces old duplicates)
-- =============================================================

CREATE TABLE PatientAllocation (
    alloc_id        SERIAL PRIMARY KEY,
    patient_id      INT NOT NULL REFERENCES Patient(patient_id),
    ward_id         INT NOT NULL REFERENCES Ward(ward_id),
    bed_id          INT REFERENCES Bed(bed_id),
    date_on_waiting_list    DATE,
    expected_duration_days  INT,
    date_placed             DATE,
    date_expected_leave     DATE,
    actual_date_left        DATE
);


-- =============================================================
--  DATA: DEPARTMENTS
-- =============================================================

INSERT INTO Department (dept_name, location) VALUES
('Internal Medicine',       'A Block'),
('Surgery',                 'B Block'),
('Pediatrics',              'C Block'),
('Obstetrics & Gynecology', 'D Block'),
('Orthopedics',             'E Block'),
('Cardiology',              'F Block'),
('Neurology',               'G Block'),
('Geriatrics',              'H Block'),
('Emergency',               'A Block'),
('Out-Patient Clinic',      'Main Building');


-- =============================================================
--  DATA: STAFF (50 staff members)
-- =============================================================

INSERT INTO Staff (first_name, last_name, address, phone_number, date_of_birth, sex, nin, position, current_salary, salary_scale, contract_type, pay_type, hours_per_week) VALUES
-- Charge Nurses
('Maria Luisa', 'Reyes',       'Purok 3, Bulua, Cagayan de Oro',           '09171234501', '1975-03-15', 'F', 'NIN-001', 'Charge Nurse',    38000, '5A', 'Permanent', 'Monthly', 40),
('Jose Ramon',  'Dela Cruz',   'Purok 5, Lapasan, Cagayan de Oro',         '09181234502', '1972-07-22', 'M', 'NIN-002', 'Charge Nurse',    38000, '5A', 'Permanent', 'Monthly', 40),
('Evelyn',      'Mangubat',    'Purok 2, Macabalan, Cagayan de Oro',       '09191234503', '1978-11-08', 'F', 'NIN-003', 'Charge Nurse',    38000, '5A', 'Permanent', 'Monthly', 40),
('Ricardo',     'Omipon',      'Balulang, Cagayan de Oro',                  '09201234504', '1980-05-30', 'M', 'NIN-004', 'Charge Nurse',    38000, '5A', 'Permanent', 'Monthly', 40),
('Lourdes',     'Tabalbag',    'Cugman, Cagayan de Oro',                    '09211234505', '1976-09-14', 'F', 'NIN-005', 'Charge Nurse',    38000, '5A', 'Permanent', 'Monthly', 40),
-- Consultants
('Dr. Fernando','Catubig',     'Camaman-an, Cagayan de Oro',                '09221234506', '1968-01-20', 'M', 'NIN-006', 'Consultant',      75000, '8B', 'Permanent', 'Monthly', 40),
('Dr. Analiza', 'Sabal',       'Nazareth, Cagayan de Oro',                  '09231234507', '1970-06-17', 'F', 'NIN-007', 'Consultant',      75000, '8B', 'Permanent', 'Monthly', 40),
('Dr. Roberto', 'Ilagan',      'Carmen, Cagayan de Oro',                    '09241234508', '1965-12-05', 'M', 'NIN-008', 'Consultant',      75000, '8B', 'Permanent', 'Monthly', 40),
('Dr. Cristina','Fajardo',     'Gusa, Cagayan de Oro',                      '09251234509', '1973-04-28', 'F', 'NIN-009', 'Consultant',      75000, '8B', 'Permanent', 'Monthly', 40),
('Dr. Manuel',  'Bustamante',  'Barangay 4, Cagayan de Oro',               '09261234510', '1967-08-11', 'M', 'NIN-010', 'Consultant',      75000, '8B', 'Permanent', 'Monthly', 40),
-- Staff Nurses
('Ana',         'Pepito',      'Consolacion, Cagayan de Oro',               '09271234511', '1990-02-14', 'F', 'NIN-011', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Rodrigo',     'Lumapas',     'Iponan, Cagayan de Oro',                    '09281234512', '1988-10-30', 'M', 'NIN-012', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Jenelyn',     'Ocon',        'Indahag, Cagayan de Oro',                   '09291234513', '1992-07-19', 'F', 'NIN-013', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Marlon',      'Tabobo',      'Barangay 17, Cagayan de Oro',              '09301234514', '1987-03-22', 'M', 'NIN-014', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Rosario',     'Bacalso',     'Agusan, Cagayan de Oro',                    '09171234515', '1993-11-05', 'F', 'NIN-015', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Emelita',     'Dagohoy',     'Kauswagan, Cagayan de Oro',                '09181234516', '1989-08-17', 'F', 'NIN-016', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Jerome',      'Cabanero',    'Puerto, Cagayan de Oro',                    '09191234517', '1991-05-25', 'M', 'NIN-017', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Sheryl',      'Montecillo',  'Barangay 40, Cagayan de Oro',              '09201234518', '1994-01-09', 'F', 'NIN-018', 'Staff Nurse',     22000, '3C', 'Temporary', 'Monthly', 40),
('Dennis',      'Uy',          'Lapasan, Cagayan de Oro',                   '09211234519', '1986-09-12', 'M', 'NIN-019', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Carmelita',   'Velez',       'Bulua, Cagayan de Oro',                     '09221234520', '1995-04-03', 'F', 'NIN-020', 'Staff Nurse',     22000, '3C', 'Temporary', 'Monthly', 40),
-- Junior Nurses
('Mark',        'Abayon',      'Barangay 1, Cagayan de Oro',               '09231234521', '1998-06-18', 'M', 'NIN-021', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Lenie',       'Sumalinog',   'Gusa, Cagayan de Oro',                      '09241234522', '1999-02-27', 'F', 'NIN-022', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Patrick',     'Geverola',    'Camaman-an, Cagayan de Oro',                '09251234523', '1997-11-14', 'M', 'NIN-023', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Maribeth',    'Delos Reyes', 'Nazareth, Cagayan de Oro',                  '09261234524', '2000-08-03', 'F', 'NIN-024', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Aldrin',      'Pañares',     'Macabalan, Cagayan de Oro',                 '09271234525', '1998-04-21', 'M', 'NIN-025', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
-- Doctors
('Dr. Lorna',   'Dalogdog',    'Barangay 22, Cagayan de Oro',              '09281234526', '1975-10-09', 'F', 'NIN-026', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Dr. Ariel',   'Macaraeg',    'Iponan, Cagayan de Oro',                    '09291234527', '1979-05-16', 'M', 'NIN-027', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Dr. Marites', 'Caballero',   'Carmen, Cagayan de Oro',                    '09301234528', '1981-12-24', 'F', 'NIN-028', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Dr. Renato',  'Jaboneta',    'Balulang, Cagayan de Oro',                  '09171234529', '1977-07-07', 'M', 'NIN-029', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Dr. Gloria',  'Estorque',    'Consolacion, Cagayan de Oro',               '09181234530', '1983-03-31', 'F', 'NIN-030', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
-- Auxiliaries
('Danilo',      'Tumulak',     'Barangay 9, Cagayan de Oro',               '09191234531', '1985-09-25', 'M', 'NIN-031', 'Auxiliary',       12000, '1A', 'Permanent', 'Monthly', 40),
('Nenita',      'Cañada',      'Agusan, Cagayan de Oro',                    '09201234532', '1982-06-13', 'F', 'NIN-032', 'Auxiliary',       12000, '1A', 'Permanent', 'Monthly', 40),
('Rolando',     'Gepitulan',   'Cugman, Cagayan de Oro',                    '09211234533', '1980-02-28', 'M', 'NIN-033', 'Auxiliary',       12000, '1A', 'Permanent', 'Monthly', 40),
('Melinda',     'Sison',       'Barangay 34, Cagayan de Oro',              '09221234534', '1988-11-17', 'F', 'NIN-034', 'Auxiliary',       12000, '1A', 'Temporary', 'Weekly',  40),
('Ernesto',     'Paquibot',    'Indahag, Cagayan de Oro',                   '09231234535', '1979-08-04', 'M', 'NIN-035', 'Auxiliary',       12000, '1A', 'Permanent', 'Monthly', 40),
-- Physiotherapists
('Cecilia',     'Palamine',    'Kauswagan, Cagayan de Oro',                '09241234536', '1984-04-19', 'F', 'NIN-036', 'Physiotherapist', 35000, '4B', 'Permanent', 'Monthly', 40),
('Vincent',     'Saavedra',    'Lapasan, Cagayan de Oro',                   '09251234537', '1986-12-07', 'M', 'NIN-037', 'Physiotherapist', 35000, '4B', 'Permanent', 'Monthly', 40),
-- Admin
('Remedios',    'Estrada',     'Puerto, Cagayan de Oro',                    '09261234538', '1970-05-22', 'F', 'NIN-038', 'Personnel Officer',42000,'6A', 'Permanent', 'Monthly', 40),
('Antonio',     'Villanueva',  'Barangay 2, Cagayan de Oro',               '09271234539', '1965-01-30', 'M', 'NIN-039', 'Medical Director', 95000,'9A', 'Permanent', 'Monthly', 40),
('Florencia',   'Abella',      'Nazareth, Cagayan de Oro',                  '09281234540', '1988-07-15', 'F', 'NIN-040', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Michael',     'Cagasan',     'Gusa, Cagayan de Oro',                      '09291234541', '1991-10-29', 'M', 'NIN-041', 'Staff Nurse',     22000, '3C', 'Temporary', 'Monthly', 40),
('Teresita',    'Bacus',       'Bulua, Cagayan de Oro',                     '09301234542', '1993-03-08', 'F', 'NIN-042', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Ramon',       'Malinao',     'Camaman-an, Cagayan de Oro',                '09171234543', '1987-08-20', 'M', 'NIN-043', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Felicitas',   'Casimero',    'Carmen, Cagayan de Oro',                    '09181234544', '1990-06-11', 'F', 'NIN-044', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Rogelio',     'Bacalzo',     'Macabalan, Cagayan de Oro',                 '09191234545', '1982-01-25', 'M', 'NIN-045', 'Auxiliary',       12000, '1A', 'Permanent', 'Monthly', 40),
('Julieta',     'Libarios',    'Barangay 12, Cagayan de Oro',              '09201234546', '1979-09-03', 'F', 'NIN-046', 'Staff Nurse',     22000, '3C', 'Permanent', 'Monthly', 40),
('Nestor',      'Opena',       'Iponan, Cagayan de Oro',                    '09211234547', '1984-04-17', 'M', 'NIN-047', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Aileen',      'Quijano',     'Consolacion, Cagayan de Oro',               '09221234548', '1996-11-30', 'F', 'NIN-048', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40),
('Bonifacio',   'Ramirez',     'Agusan, Cagayan de Oro',                    '09231234549', '1971-07-14', 'M', 'NIN-049', 'Doctor',          55000, '7A', 'Permanent', 'Monthly', 40),
('Salvacion',   'Torralba',    'Indahag, Cagayan de Oro',                   '09241234550', '1994-02-06', 'F', 'NIN-050', 'Junior Nurse',    16000, '2A', 'Temporary', 'Monthly', 40);


-- =============================================================
--  DATA: WARDS (10 wards + out-patient clinic)
-- =============================================================

INSERT INTO Ward (dept_id, ward_name, location, total_beds, tel_extension, charge_nurse_id) VALUES
(1, 'General Medicine Ward',  'A Block, Floor 1', 24, 'Extn-1101', 1),
(2, 'Surgical Ward',          'B Block, Floor 1', 20, 'Extn-1201', 2),
(3, 'Pediatric Ward',         'C Block, Floor 1', 18, 'Extn-1301', 3),
(4, 'Maternity Ward',         'D Block, Floor 1', 16, 'Extn-1401', 4),
(5, 'Orthopedic Ward',        'E Block, Floor 2', 20, 'Extn-1501', 5),
(6, 'Cardiology Ward',        'F Block, Floor 2', 16, 'Extn-1601', 1),
(7, 'Neurology Ward',         'G Block, Floor 3', 14, 'Extn-1701', 2),
(8, 'Geriatric Ward',         'H Block, Floor 1', 24, 'Extn-1801', 3),
(9, 'Emergency Ward',         'A Block, Ground',  20, 'Extn-1901', 4),
(10,'Out-Patient Clinic',     'Main Bldg, GF',    28, 'Extn-2001', 5);


-- =============================================================
--  DATA: BEDS (20 per ward, 10 wards = 200 beds)
-- =============================================================

INSERT INTO Bed (ward_id, bed_number, status) VALUES
-- Ward 1
(1,'A-101','Occupied'),(1,'A-102','Occupied'),(1,'A-103','Available'),(1,'A-104','Occupied'),
(1,'A-105','Available'),(1,'A-106','Occupied'),(1,'A-107','Maintenance'),(1,'A-108','Occupied'),
(1,'A-109','Available'),(1,'A-110','Occupied'),(1,'A-111','Occupied'),(1,'A-112','Available'),
(1,'A-113','Occupied'),(1,'A-114','Available'),(1,'A-115','Occupied'),(1,'A-116','Occupied'),
(1,'A-117','Available'),(1,'A-118','Occupied'),(1,'A-119','Available'),(1,'A-120','Occupied'),
-- Ward 2
(2,'B-201','Occupied'),(2,'B-202','Available'),(2,'B-203','Occupied'),(2,'B-204','Occupied'),
(2,'B-205','Available'),(2,'B-206','Occupied'),(2,'B-207','Occupied'),(2,'B-208','Available'),
(2,'B-209','Occupied'),(2,'B-210','Occupied'),(2,'B-211','Available'),(2,'B-212','Occupied'),
(2,'B-213','Occupied'),(2,'B-214','Available'),(2,'B-215','Occupied'),(2,'B-216','Available'),
(2,'B-217','Occupied'),(2,'B-218','Occupied'),(2,'B-219','Available'),(2,'B-220','Occupied'),
-- Ward 3
(3,'C-301','Occupied'),(3,'C-302','Occupied'),(3,'C-303','Available'),(3,'C-304','Occupied'),
(3,'C-305','Available'),(3,'C-306','Occupied'),(3,'C-307','Occupied'),(3,'C-308','Available'),
(3,'C-309','Occupied'),(3,'C-310','Available'),(3,'C-311','Occupied'),(3,'C-312','Occupied'),
(3,'C-313','Available'),(3,'C-314','Occupied'),(3,'C-315','Available'),(3,'C-316','Occupied'),
(3,'C-317','Occupied'),(3,'C-318','Available'),(3,'C-319','Occupied'),(3,'C-320','Occupied'),
-- Ward 4
(4,'D-401','Occupied'),(4,'D-402','Available'),(4,'D-403','Occupied'),(4,'D-404','Occupied'),
(4,'D-405','Available'),(4,'D-406','Occupied'),(4,'D-407','Available'),(4,'D-408','Occupied'),
(4,'D-409','Occupied'),(4,'D-410','Available'),(4,'D-411','Occupied'),(4,'D-412','Occupied'),
(4,'D-413','Available'),(4,'D-414','Occupied'),(4,'D-415','Available'),(4,'D-416','Occupied'),
(4,'D-417','Occupied'),(4,'D-418','Available'),(4,'D-419','Occupied'),(4,'D-420','Occupied'),
-- Ward 5
(5,'E-501','Occupied'),(5,'E-502','Occupied'),(5,'E-503','Available'),(5,'E-504','Occupied'),
(5,'E-505','Maintenance'),(5,'E-506','Occupied'),(5,'E-507','Available'),(5,'E-508','Occupied'),
(5,'E-509','Occupied'),(5,'E-510','Available'),(5,'E-511','Occupied'),(5,'E-512','Occupied'),
(5,'E-513','Available'),(5,'E-514','Occupied'),(5,'E-515','Available'),(5,'E-516','Occupied'),
(5,'E-517','Occupied'),(5,'E-518','Available'),(5,'E-519','Occupied'),(5,'E-520','Occupied'),
-- Ward 6
(6,'F-601','Occupied'),(6,'F-602','Available'),(6,'F-603','Occupied'),(6,'F-604','Occupied'),
(6,'F-605','Available'),(6,'F-606','Occupied'),(6,'F-607','Occupied'),(6,'F-608','Available'),
(6,'F-609','Occupied'),(6,'F-610','Available'),(6,'F-611','Occupied'),(6,'F-612','Occupied'),
(6,'F-613','Available'),(6,'F-614','Occupied'),(6,'F-615','Available'),(6,'F-616','Occupied'),
(6,'F-617','Occupied'),(6,'F-618','Available'),(6,'F-619','Occupied'),(6,'F-620','Occupied'),
-- Ward 7
(7,'G-701','Occupied'),(7,'G-702','Occupied'),(7,'G-703','Available'),(7,'G-704','Occupied'),
(7,'G-705','Available'),(7,'G-706','Occupied'),(7,'G-707','Occupied'),(7,'G-708','Available'),
(7,'G-709','Occupied'),(7,'G-710','Available'),(7,'G-711','Occupied'),(7,'G-712','Occupied'),
(7,'G-713','Available'),(7,'G-714','Occupied'),(7,'G-715','Available'),(7,'G-716','Occupied'),
(7,'G-717','Occupied'),(7,'G-718','Available'),(7,'G-719','Occupied'),(7,'G-720','Occupied'),
-- Ward 8
(8,'H-801','Occupied'),(8,'H-802','Available'),(8,'H-803','Occupied'),(8,'H-804','Occupied'),
(8,'H-805','Available'),(8,'H-806','Occupied'),(8,'H-807','Available'),(8,'H-808','Occupied'),
(8,'H-809','Occupied'),(8,'H-810','Available'),(8,'H-811','Occupied'),(8,'H-812','Occupied'),
(8,'H-813','Available'),(8,'H-814','Occupied'),(8,'H-815','Available'),(8,'H-816','Occupied'),
(8,'H-817','Occupied'),(8,'H-818','Available'),(8,'H-819','Occupied'),(8,'H-820','Occupied'),
-- Ward 9
(9,'I-901','Occupied'),(9,'I-902','Occupied'),(9,'I-903','Available'),(9,'I-904','Occupied'),
(9,'I-905','Available'),(9,'I-906','Occupied'),(9,'I-907','Occupied'),(9,'I-908','Available'),
(9,'I-909','Occupied'),(9,'I-910','Available'),(9,'I-911','Occupied'),(9,'I-912','Occupied'),
(9,'I-913','Available'),(9,'I-914','Occupied'),(9,'I-915','Available'),(9,'I-916','Occupied'),
(9,'I-917','Occupied'),(9,'I-918','Available'),(9,'I-919','Occupied'),(9,'I-920','Occupied'),
-- Ward 10
(10,'J-1001','Available'),(10,'J-1002','Available'),(10,'J-1003','Available'),(10,'J-1004','Available'),
(10,'J-1005','Available'),(10,'J-1006','Available'),(10,'J-1007','Available'),(10,'J-1008','Available'),
(10,'J-1009','Available'),(10,'J-1010','Available'),(10,'J-1011','Available'),(10,'J-1012','Available'),
(10,'J-1013','Available'),(10,'J-1014','Available'),(10,'J-1015','Available'),(10,'J-1016','Available'),
(10,'J-1017','Available'),(10,'J-1018','Available'),(10,'J-1019','Available'),(10,'J-1020','Available');


-- =============================================================
--  DATA: PATIENTS (100 patients, Filipino CDO-based)
-- =============================================================

INSERT INTO Patient (first_name, last_name, address, phone_number, date_of_birth, sex, marital_status, date_registered) VALUES
('Juan',         'Santos',       'Purok 4, Bulua, Cagayan de Oro',            '09171000001', '1945-03-12', 'M', 'Married',   '2025-01-05'),
('Maria',        'Reyes',        'Purok 2, Lapasan, Cagayan de Oro',          '09181000002', '1938-07-24', 'F', 'Widowed',   '2025-01-07'),
('Pedro',        'Garcia',       'Barangay 4, Cagayan de Oro',               '09191000003', '1950-11-03', 'M', 'Married',   '2025-01-10'),
('Rosario',      'Dela Cruz',    'Gusa, Cagayan de Oro',                      '09201000004', '1942-05-18', 'F', 'Married',   '2025-01-12'),
('Eduardo',      'Flores',       'Nazareth, Cagayan de Oro',                  '09211000005', '1955-09-30', 'M', 'Married',   '2025-01-15'),
('Consolacion',  'Bautista',     'Camaman-an, Cagayan de Oro',                '09221000006', '1948-02-14', 'F', 'Widowed',   '2025-01-18'),
('Amado',        'Villanueva',   'Carmen, Cagayan de Oro',                    '09231000007', '1952-06-07', 'M', 'Married',   '2025-01-20'),
('Leonora',      'Cruz',         'Macabalan, Cagayan de Oro',                 '09241000008', '1939-12-22', 'F', 'Widowed',   '2025-01-22'),
('Bernardo',     'Torres',       'Cugman, Cagayan de Oro',                    '09251000009', '1946-08-16', 'M', 'Married',   '2025-01-25'),
('Remedios',     'Gonzales',     'Balulang, Cagayan de Oro',                  '09261000010', '1943-04-09', 'F', 'Married',   '2025-01-28'),
('Alfredo',      'Mendoza',      'Iponan, Cagayan de Oro',                    '09271000011', '1957-01-27', 'M', 'Married',   '2025-02-01'),
('Teresita',     'Ramos',        'Agusan, Cagayan de Oro',                    '09281000012', '1940-10-05', 'F', 'Widowed',   '2025-02-03'),
('Victorino',    'Diaz',         'Consolacion, Cagayan de Oro',               '09291000013', '1953-07-14', 'M', 'Separated', '2025-02-05'),
('Erlinda',      'Morales',      'Puerto, Cagayan de Oro',                    '09301000014', '1947-03-28', 'F', 'Married',   '2025-02-08'),
('Celestino',    'Aquino',       'Kauswagan, Cagayan de Oro',                '09171000015', '1960-11-19', 'M', 'Married',   '2025-02-10'),
('Natividad',    'Reyes',        'Barangay 17, Cagayan de Oro',              '09181000016', '1936-06-02', 'F', 'Widowed',   '2025-02-12'),
('Gregorio',     'Buenaventura', 'Lapasan, Cagayan de Oro',                   '09191000017', '1949-09-11', 'M', 'Married',   '2025-02-15'),
('Esperanza',    'Salazar',      'Bulua, Cagayan de Oro',                     '09201000018', '1944-01-30', 'F', 'Married',   '2025-02-18'),
('Rodrigo',      'Pascual',      'Gusa, Cagayan de Oro',                      '09211000019', '1958-05-23', 'M', 'Married',   '2025-02-20'),
('Felicidad',    'Navarro',      'Nazareth, Cagayan de Oro',                  '09221000020', '1941-08-07', 'F', 'Widowed',   '2025-02-22'),
('Aurelio',      'Padilla',      'Camaman-an, Cagayan de Oro',                '09231000021', '1954-04-15', 'M', 'Married',   '2025-03-01'),
('Carmelita',    'Castillo',     'Carmen, Cagayan de Oro',                    '09241000022', '1937-12-28', 'F', 'Widowed',   '2025-03-03'),
('Domingo',      'Soriano',      'Barangay 9, Cagayan de Oro',               '09251000023', '1962-07-04', 'M', 'Married',   '2025-03-05'),
('Visitacion',   'Marcelo',      'Macabalan, Cagayan de Oro',                 '09261000024', '1945-02-17', 'F', 'Separated', '2025-03-08'),
('Proceso',      'Guerrero',     'Indahag, Cagayan de Oro',                   '09271000025', '1951-10-08', 'M', 'Married',   '2025-03-10'),
('Eduvigis',     'Aguilar',      'Cugman, Cagayan de Oro',                    '09281000026', '1939-06-20', 'F', 'Widowed',   '2025-03-12'),
('Lucio',        'Miranda',      'Balulang, Cagayan de Oro',                  '09291000027', '1956-03-14', 'M', 'Married',   '2025-03-15'),
('Adoracion',    'Medina',       'Iponan, Cagayan de Oro',                    '09301000028', '1943-11-26', 'F', 'Married',   '2025-03-18'),
('Simeon',       'Vargas',       'Agusan, Cagayan de Oro',                    '09171000029', '1948-08-03', 'M', 'Married',   '2025-03-20'),
('Purificacion', 'Ibarra',       'Consolacion, Cagayan de Oro',               '09181000030', '1935-04-09', 'F', 'Widowed',   '2025-03-22'),
('Iluminado',    'Delos Santos', 'Puerto, Cagayan de Oro',                    '09191000031', '1964-01-18', 'M', 'Married',   '2025-04-01'),
('Angelita',     'Ocampo',       'Kauswagan, Cagayan de Oro',                '09201000032', '1946-09-05', 'F', 'Married',   '2025-04-03'),
('Ruperto',      'Reyes',        'Barangay 22, Cagayan de Oro',              '09211000033', '1953-05-29', 'M', 'Married',   '2025-04-05'),
('Dolores',      'Abad',         'Lapasan, Cagayan de Oro',                   '09221000034', '1940-02-11', 'F', 'Widowed',   '2025-04-08'),
('Saturnino',    'Jimenez',      'Gusa, Cagayan de Oro',                      '09231000035', '1959-12-24', 'M', 'Separated', '2025-04-10'),
('Soledad',      'Cabrera',      'Nazareth, Cagayan de Oro',                  '09241000036', '1942-07-16', 'F', 'Married',   '2025-04-12'),
('Maximo',       'Pineda',       'Camaman-an, Cagayan de Oro',                '09251000037', '1950-03-07', 'M', 'Married',   '2025-04-15'),
('Candelaria',   'Alvarez',      'Carmen, Cagayan de Oro',                    '09261000038', '1936-10-20', 'F', 'Widowed',   '2025-04-18'),
('Florentino',   'Guevarra',     'Macabalan, Cagayan de Oro',                 '09271000039', '1957-06-13', 'M', 'Married',   '2025-04-20'),
('Resurreccion', 'Lim',          'Indahag, Cagayan de Oro',                   '09281000040', '1944-01-25', 'F', 'Married',   '2025-04-22'),
('Hermogenes',   'Dela Torre',   'Cugman, Cagayan de Oro',                    '09291000041', '1963-09-08', 'M', 'Married',   '2025-05-01'),
('Magdalena',    'Reyes',        'Balulang, Cagayan de Oro',                  '09301000042', '1938-05-21', 'F', 'Widowed',   '2025-05-03'),
('Timoteo',      'Santiago',     'Iponan, Cagayan de Oro',                    '09171000043', '1952-02-14', 'M', 'Married',   '2025-05-05'),
('Corazon',      'Fernandez',    'Agusan, Cagayan de Oro',                    '09181000044', '1947-11-27', 'F', 'Married',   '2025-05-08'),
('Bartolome',    'Herrera',      'Consolacion, Cagayan de Oro',               '09191000045', '1955-08-10', 'M', 'Married',   '2025-05-10'),
('Presentacion', 'Dela Rosa',    'Puerto, Cagayan de Oro',                    '09201000046', '1941-04-03', 'F', 'Widowed',   '2025-05-12'),
('Crisostomo',   'Bondoc',       'Kauswagan, Cagayan de Oro',                '09211000047', '1961-12-16', 'M', 'Married',   '2025-05-15'),
('Epifania',     'Manalo',       'Barangay 34, Cagayan de Oro',              '09221000048', '1943-07-29', 'F', 'Married',   '2025-05-18'),
('Exequiel',     'Perez',        'Lapasan, Cagayan de Oro',                   '09231000049', '1948-03-22', 'M', 'Separated', '2025-05-20'),
('Milagros',     'Sarmiento',    'Gusa, Cagayan de Oro',                      '09241000050', '1935-10-15', 'F', 'Widowed',   '2025-05-22'),
('Esteban',      'Velasco',      'Nazareth, Cagayan de Oro',                  '09251000051', '1966-06-08', 'M', 'Married',   '2025-06-01'),
('Rufina',       'Belen',        'Camaman-an, Cagayan de Oro',                '09261000052', '1940-02-21', 'F', 'Widowed',   '2025-06-03'),
('Meliton',      'Corpus',       'Carmen, Cagayan de Oro',                    '09271000053', '1954-11-04', 'M', 'Married',   '2025-06-05'),
('Imelda',       'Enriquez',     'Macabalan, Cagayan de Oro',                 '09281000054', '1946-08-17', 'F', 'Married',   '2025-06-08'),
('Demetrio',     'Gutierrez',    'Indahag, Cagayan de Oro',                   '09291000055', '1960-04-30', 'M', 'Married',   '2025-06-10'),
('Primitiva',    'Lacson',       'Cugman, Cagayan de Oro',                    '09301000056', '1937-01-13', 'F', 'Widowed',   '2025-06-12'),
('Abundio',      'Mateo',        'Balulang, Cagayan de Oro',                  '09171000057', '1949-09-26', 'M', 'Married',   '2025-06-15'),
('Consuelo',     'Natividad',    'Iponan, Cagayan de Oro',                    '09181000058', '1944-06-09', 'F', 'Married',   '2025-06-18'),
('Juanito',      'Oblena',       'Agusan, Cagayan de Oro',                    '09191000059', '1958-02-22', 'M', 'Married',   '2025-06-20'),
('Felipa',       'Patriarca',    'Consolacion, Cagayan de Oro',               '09201000060', '1941-11-05', 'F', 'Widowed',   '2025-06-22'),
('Arsenio',      'Quiambao',     'Puerto, Cagayan de Oro',                    '09211000061', '1953-07-18', 'M', 'Married',   '2025-07-01'),
('Norberta',     'Robredo',      'Kauswagan, Cagayan de Oro',                '09221000062', '1939-04-01', 'F', 'Widowed',   '2025-07-03'),
('Glicerio',     'Soriano',      'Barangay 40, Cagayan de Oro',              '09231000063', '1965-01-14', 'M', 'Married',   '2025-07-05'),
('Asuncion',     'Tadena',       'Lapasan, Cagayan de Oro',                   '09241000064', '1942-10-27', 'F', 'Married',   '2025-07-08'),
('Macario',      'Umali',        'Gusa, Cagayan de Oro',                      '09251000065', '1956-07-10', 'M', 'Separated', '2025-07-10'),
('Visitacion',   'Valencia',     'Nazareth, Cagayan de Oro',                  '09261000066', '1943-03-23', 'F', 'Married',   '2025-07-12'),
('Wenceslao',    'Yap',          'Camaman-an, Cagayan de Oro',                '09271000067', '1951-12-06', 'M', 'Married',   '2025-07-15'),
('Zenaida',      'Zamora',       'Carmen, Cagayan de Oro',                    '09281000068', '1938-08-19', 'F', 'Widowed',   '2025-07-18'),
('Patricio',     'Abrenica',     'Macabalan, Cagayan de Oro',                 '09291000069', '1960-05-02', 'M', 'Married',   '2025-07-20'),
('Lilia',        'Balois',       'Indahag, Cagayan de Oro',                   '09301000070', '1947-01-15', 'F', 'Married',   '2025-07-22'),
('Victorino',    'Cadiz',        'Cugman, Cagayan de Oro',                    '09171000071', '1955-10-28', 'M', 'Married',   '2025-08-01'),
('Encarnacion',  'Daza',         'Balulang, Cagayan de Oro',                  '09181000072', '1940-07-11', 'F', 'Widowed',   '2025-08-03'),
('Marciano',     'Espino',       'Iponan, Cagayan de Oro',                    '09191000073', '1963-03-24', 'M', 'Married',   '2025-08-05'),
('Juana',        'Feria',        'Agusan, Cagayan de Oro',                    '09201000074', '1944-12-07', 'F', 'Married',   '2025-08-08'),
('Rosendo',      'Gatmaitan',    'Consolacion, Cagayan de Oro',               '09211000075', '1958-08-20', 'M', 'Married',   '2025-08-10'),
('Severina',     'Hilario',      'Puerto, Cagayan de Oro',                    '09221000076', '1936-05-03', 'F', 'Widowed',   '2025-08-12'),
('Gaudencio',    'Imperial',     'Kauswagan, Cagayan de Oro',                '09231000077', '1950-01-16', 'M', 'Married',   '2025-08-15'),
('Florencia',    'Javier',       'Barangay 12, Cagayan de Oro',              '09241000078', '1945-10-29', 'F', 'Married',   '2025-08-18'),
('Renato',       'Kimpo',        'Lapasan, Cagayan de Oro',                   '09251000079', '1962-07-12', 'M', 'Separated', '2025-08-20'),
('Herminia',     'Llamas',       'Gusa, Cagayan de Oro',                      '09261000080', '1941-03-25', 'F', 'Widowed',   '2025-08-22'),
('Quintin',      'Maceda',       'Nazareth, Cagayan de Oro',                  '09271000081', '1957-12-08', 'M', 'Married',   '2025-09-01'),
('Gregoria',     'Narciso',      'Camaman-an, Cagayan de Oro',                '09281000082', '1939-08-21', 'F', 'Widowed',   '2025-09-03'),
('Leoncio',      'Ochoa',        'Carmen, Cagayan de Oro',                    '09291000083', '1953-05-04', 'M', 'Married',   '2025-09-05'),
('Norma',        'Pelayo',       'Macabalan, Cagayan de Oro',                 '09301000084', '1946-01-17', 'F', 'Married',   '2025-09-08'),
('Emiliano',     'Quezon',       'Indahag, Cagayan de Oro',                   '09171000085', '1967-10-30', 'M', 'Married',   '2025-09-10'),
('Dalisay',      'Regalado',     'Cugman, Cagayan de Oro',                    '09181000086', '1943-07-13', 'F', 'Married',   '2025-09-12'),
('Celestino',    'Salcedo',      'Balulang, Cagayan de Oro',                  '09191000087', '1951-03-26', 'M', 'Married',   '2025-09-15'),
('Concepcion',   'Tañedo',       'Iponan, Cagayan de Oro',                    '09201000088', '1937-12-09', 'F', 'Widowed',   '2025-09-18'),
('Domingo',      'Ubaldo',       'Agusan, Cagayan de Oro',                    '09211000089', '1960-08-22', 'M', 'Married',   '2025-09-20'),
('Nieves',       'Varona',       'Consolacion, Cagayan de Oro',               '09221000090', '1945-05-05', 'F', 'Married',   '2025-09-22'),
('Apolinario',   'Waga',         'Puerto, Cagayan de Oro',                    '09231000091', '1955-01-18', 'M', 'Married',   '2025-10-01'),
('Margarita',    'Ybañez',       'Kauswagan, Cagayan de Oro',                '09241000092', '1940-10-01', 'F', 'Widowed',   '2025-10-03'),
('Filomeno',     'Zabala',       'Barangay 4, Cagayan de Oro',               '09251000093', '1964-06-14', 'M', 'Married',   '2025-10-05'),
('Resureccion',  'Abella',       'Lapasan, Cagayan de Oro',                   '09261000094', '1942-02-27', 'F', 'Married',   '2025-10-08'),
('Bibiano',      'Boquiren',     'Gusa, Cagayan de Oro',                      '09271000095', '1949-11-10', 'M', 'Separated', '2025-10-10'),
('Nena',         'Cainglet',     'Nazareth, Cagayan de Oro',                  '09281000096', '1935-07-23', 'F', 'Widowed',   '2025-10-12'),
('Rodolfo',      'Dacanay',      'Camaman-an, Cagayan de Oro',                '09291000097', '1968-04-06', 'M', 'Married',   '2025-10-15'),
('Lourdes',      'Empleo',       'Carmen, Cagayan de Oro',                    '09301000098', '1944-12-19', 'F', 'Married',   '2025-10-18'),
('Segundo',      'Fontanilla',   'Macabalan, Cagayan de Oro',                 '09171000099', '1952-09-02', 'M', 'Married',   '2025-10-20'),
('Pilar',        'Guzman',       'Indahag, Cagayan de Oro',                   '09181000100', '1941-05-15', 'F', 'Widowed',   '2025-10-22');


-- =============================================================
--  DATA: NEXT OF KIN (one per patient, 100 records)
-- =============================================================

INSERT INTO NextOfKin (patient_id, full_name, relationship, address, phone_number) VALUES
(1,'Roberto Santos','Son','Purok 4, Bulua, CDO','09172000001'),
(2,'Carlos Reyes','Son','Purok 7, Lapasan, CDO','09182000002'),
(3,'Cristina Garcia','Daughter','Barangay 4, CDO','09192000003'),
(4,'Mario Dela Cruz','Husband','Gusa, CDO','09202000004'),
(5,'Luisa Flores','Wife','Nazareth, CDO','09212000005'),
(6,'Ramon Bautista','Son','Camaman-an, CDO','09222000006'),
(7,'Celia Villanueva','Wife','Carmen, CDO','09232000007'),
(8,'Tomas Cruz','Son','Macabalan, CDO','09242000008'),
(9,'Elena Torres','Wife','Cugman, CDO','09252000009'),
(10,'Raul Gonzales','Son','Balulang, CDO','09262000010'),
(11,'Josefina Mendoza','Wife','Iponan, CDO','09272000011'),
(12,'Ernesto Ramos','Son','Agusan, CDO','09282000012'),
(13,'Perla Diaz','Daughter','Consolacion, CDO','09292000013'),
(14,'Alejandro Morales','Husband','Puerto, CDO','09302000014'),
(15,'Patricia Aquino','Wife','Kauswagan, CDO','09172000015'),
(16,'Vicente Reyes','Son','Barangay 17, CDO','09182000016'),
(17,'Amelita Buenaventura','Daughter','Lapasan, CDO','09192000017'),
(18,'Domingo Salazar','Husband','Bulua, CDO','09202000018'),
(19,'Rowena Pascual','Wife','Gusa, CDO','09212000019'),
(20,'Arturo Navarro','Son','Nazareth, CDO','09222000020'),
(21,'Glenda Padilla','Wife','Camaman-an, CDO','09232000021'),
(22,'Jorge Castillo','Son','Carmen, CDO','09242000022'),
(23,'Divina Soriano','Daughter','Barangay 9, CDO','09252000023'),
(24,'Benjamin Marcelo','Son','Macabalan, CDO','09262000024'),
(25,'Violeta Guerrero','Wife','Indahag, CDO','09272000025'),
(26,'Ernesto Aguilar','Son','Cugman, CDO','09282000026'),
(27,'Carina Miranda','Daughter','Balulang, CDO','09292000027'),
(28,'Nestor Medina','Husband','Iponan, CDO','09302000028'),
(29,'Alicia Vargas','Wife','Agusan, CDO','09172000029'),
(30,'Norberto Ibarra','Son','Consolacion, CDO','09182000030'),
(31,'Maricel Delos Santos','Daughter','Puerto, CDO','09192000031'),
(32,'Ricardo Ocampo','Husband','Kauswagan, CDO','09202000032'),
(33,'Evelyn Reyes','Wife','Barangay 22, CDO','09212000033'),
(34,'Leonardo Abad','Son','Lapasan, CDO','09222000034'),
(35,'Gertrudes Jimenez','Daughter','Gusa, CDO','09232000035'),
(36,'Arsenio Cabrera','Son','Nazareth, CDO','09242000036'),
(37,'Josefina Pineda','Wife','Camaman-an, CDO','09252000037'),
(38,'Dennis Alvarez','Son','Carmen, CDO','09262000038'),
(39,'Maricel Guevarra','Daughter','Macabalan, CDO','09272000039'),
(40,'Renato Lim','Husband','Indahag, CDO','09282000040'),
(41,'Rowena Dela Torre','Daughter','Cugman, CDO','09292000041'),
(42,'Ernesto Reyes','Son','Balulang, CDO','09302000042'),
(43,'Patricia Santiago','Wife','Iponan, CDO','09172000043'),
(44,'Marco Fernandez','Son','Agusan, CDO','09182000044'),
(45,'Irene Herrera','Wife','Consolacion, CDO','09192000045'),
(46,'Antonio Dela Rosa','Son','Puerto, CDO','09202000046'),
(47,'Sheila Bondoc','Daughter','Kauswagan, CDO','09212000047'),
(48,'Bernard Manalo','Son','Barangay 34, CDO','09222000048'),
(49,'Carla Perez','Daughter','Lapasan, CDO','09232000049'),
(50,'Roberto Sarmiento','Son','Gusa, CDO','09242000050'),
(51,'Lorna Velasco','Wife','Nazareth, CDO','09252000051'),
(52,'Alfonso Belen','Son','Camaman-an, CDO','09262000052'),
(53,'Maricel Corpus','Daughter','Carmen, CDO','09272000053'),
(54,'Ramon Enriquez','Husband','Macabalan, CDO','09282000054'),
(55,'Elena Gutierrez','Wife','Indahag, CDO','09292000055'),
(56,'Rodrigo Lacson','Son','Cugman, CDO','09302000056'),
(57,'Cristina Mateo','Daughter','Balulang, CDO','09172000057'),
(58,'Alejandro Natividad','Husband','Iponan, CDO','09182000058'),
(59,'Marites Oblena','Wife','Agusan, CDO','09192000059'),
(60,'Jose Patriarca','Son','Consolacion, CDO','09202000060'),
(61,'Gloria Quiambao','Wife','Puerto, CDO','09212000061'),
(62,'Eduardo Robredo','Son','Kauswagan, CDO','09222000062'),
(63,'Anita Soriano','Daughter','Barangay 40, CDO','09232000063'),
(64,'Renato Tadena','Husband','Lapasan, CDO','09242000064'),
(65,'Josefa Umali','Daughter','Gusa, CDO','09252000065'),
(66,'Carlos Valencia','Son','Nazareth, CDO','09262000066'),
(67,'Nelia Yap','Wife','Camaman-an, CDO','09272000067'),
(68,'Rodrigo Zamora','Son','Carmen, CDO','09282000068'),
(69,'Cristina Abrenica','Daughter','Macabalan, CDO','09292000069'),
(70,'Alfonso Balois','Husband','Indahag, CDO','09302000070'),
(71,'Teresita Cadiz','Wife','Cugman, CDO','09172000071'),
(72,'Pedro Daza','Son','Balulang, CDO','09182000072'),
(73,'Marita Espino','Wife','Iponan, CDO','09192000073'),
(74,'Ernesto Feria','Son','Agusan, CDO','09202000074'),
(75,'Maria Gatmaitan','Daughter','Consolacion, CDO','09212000075'),
(76,'Antonio Hilario','Son','Puerto, CDO','09222000076'),
(77,'Carmelita Imperial','Wife','Kauswagan, CDO','09232000077'),
(78,'Jose Javier','Husband','Barangay 12, CDO','09242000078'),
(79,'Sheila Kimpo','Daughter','Lapasan, CDO','09252000079'),
(80,'Rodrigo Llamas','Son','Gusa, CDO','09262000080'),
(81,'Gloria Maceda','Wife','Nazareth, CDO','09272000081'),
(82,'Eduardo Narciso','Son','Camaman-an, CDO','09282000082'),
(83,'Evelyn Ochoa','Wife','Carmen, CDO','09292000083'),
(84,'Ramon Pelayo','Son','Macabalan, CDO','09302000084'),
(85,'Marites Quezon','Wife','Indahag, CDO','09172000085'),
(86,'Jose Regalado','Son','Cugman, CDO','09182000086'),
(87,'Carmen Salcedo','Daughter','Balulang, CDO','09192000087'),
(88,'Rodrigo Tañedo','Son','Iponan, CDO','09202000088'),
(89,'Cristina Ubaldo','Wife','Agusan, CDO','09212000089'),
(90,'Pedro Varona','Son','Consolacion, CDO','09222000090'),
(91,'Maria Waga','Daughter','Puerto, CDO','09232000091'),
(92,'Jose Ybañez','Son','Kauswagan, CDO','09242000092'),
(93,'Gloria Zabala','Wife','Barangay 4, CDO','09252000093'),
(94,'Ramon Abella','Son','Lapasan, CDO','09262000094'),
(95,'Marites Boquiren','Daughter','Gusa, CDO','09272000095'),
(96,'Jose Cainglet','Son','Nazareth, CDO','09282000096'),
(97,'Gloria Dacanay','Wife','Camaman-an, CDO','09292000097'),
(98,'Ramon Empleo','Son','Carmen, CDO','09302000098'),
(99,'Cristina Fontanilla','Daughter','Macabalan, CDO','09172000099'),
(100,'Jose Guzman','Son','Indahag, CDO','09182000100');


-- =============================================================
--  DATA: LOCAL DOCTORS (20 doctors, CDO-based)
-- =============================================================

INSERT INTO LocalDoctor (full_name, clinic_number, address, phone_number) VALUES
('Dr. Maribel Añonuevo',    'CDO-CLINIC-001', 'Capistrano St., Cagayan de Oro',    '088-857-1001'),
('Dr. Ernesto Balboa',      'CDO-CLINIC-002', 'Hayes St., Cagayan de Oro',         '088-857-1002'),
('Dr. Lucinda Cagatan',     'CDO-CLINIC-003', 'Velez St., Cagayan de Oro',         '088-857-1003'),
('Dr. Fidel Dalugdog',      'CDO-CLINIC-004', 'Tiano Brothers St., CDO',           '088-857-1004'),
('Dr. Perla Ebarle',        'CDO-CLINIC-005', 'Corrales Ave., Cagayan de Oro',     '088-857-1005'),
('Dr. Ramon Fabella',       'CDO-CLINIC-006', 'Osmeña St., Cagayan de Oro',        '088-857-1006'),
('Dr. Glenda Gaviola',      'CDO-CLINIC-007', 'Rizal St., Cagayan de Oro',         '088-857-1007'),
('Dr. Alfonso Hinayas',     'CDO-CLINIC-008', 'Gomez St., Cagayan de Oro',         '088-857-1008'),
('Dr. Josefa Igaya',        'CDO-CLINIC-009', 'Burgos St., Cagayan de Oro',        '088-857-1009'),
('Dr. Rodrigo Jaboneta',    'CDO-CLINIC-010', 'Mabini St., Cagayan de Oro',        '088-857-1010'),
('Dr. Maricel Kimpo',       'CDO-CLINIC-011', 'Del Pilar St., Cagayan de Oro',     '088-857-1011'),
('Dr. Nestor Lumapas',      'CDO-CLINIC-012', 'Luna St., Cagayan de Oro',          '088-857-1012'),
('Dr. Irene Macaraeg',      'CDO-CLINIC-013', 'Aguinaldo St., Cagayan de Oro',     '088-857-1013'),
('Dr. Benigno Nacalaban',   'CDO-CLINIC-014', 'Recto Ave., Cagayan de Oro',        '088-857-1014'),
('Dr. Carmelita Opena',     'CDO-CLINIC-015', 'Pabayo St., Cagayan de Oro',        '088-857-1015'),
('Dr. Eduardo Pardillo',    'CDO-CLINIC-016', 'Abejuela Rd., Cagayan de Oro',      '088-857-1016'),
('Dr. Soledad Quiblat',     'CDO-CLINIC-017', 'Kauswagan Highway, CDO',            '088-857-1017'),
('Dr. Domingo Ragandang',   'CDO-CLINIC-018', 'Indahag Road, Cagayan de Oro',      '088-857-1018'),
('Dr. Florinda Salabao',    'CDO-CLINIC-019', 'Bulua National Road, CDO',          '088-857-1019'),
('Dr. Arnulfo Tabalbag',    'CDO-CLINIC-020', 'Carmen Road, Cagayan de Oro',       '088-857-1020');


-- =============================================================
--  DATA: QUALIFICATIONS (staff 1–30, at least one each)
-- =============================================================

INSERT INTO Qualification (staff_id, qual_type, date_obtained, institution) VALUES
(1, 'BSN Nursing',              '1997-04-10', 'Xavier University – Ateneo de Cagayan'),
(2, 'BSN Nursing',              '1994-05-15', 'Capitol University'),
(3, 'BSN Nursing',              '2000-03-22', 'Liceo de Cagayan University'),
(4, 'BSN Nursing',              '2002-06-18', 'Xavier University – Ateneo de Cagayan'),
(5, 'BSN Nursing',              '1998-04-25', 'Capitol University'),
(6, 'Doctor of Medicine',       '1992-04-05', 'University of the Philippines Manila'),
(6, 'Diplomate in Internal Med','2000-08-12', 'Philippine Board of Internal Medicine'),
(7, 'Doctor of Medicine',       '1994-06-20', 'Cebu Institute of Medicine'),
(7, 'Diplomate in Surgery',     '2002-10-30', 'Philippine Board of Surgery'),
(8, 'Doctor of Medicine',       '1989-04-15', 'Far Eastern University Institute of Medicine'),
(9, 'Doctor of Medicine',       '1997-06-10', 'University of Santo Tomas'),
(10,'Doctor of Medicine',       '1991-04-22', 'University of the Philippines Manila'),
(11,'BSN Nursing',              '2012-04-18', 'Xavier University – Ateneo de Cagayan'),
(12,'BSN Nursing',              '2010-05-20', 'Capitol University'),
(13,'BSN Nursing',              '2014-04-12', 'Liceo de Cagayan University'),
(14,'BSN Nursing',              '2009-06-15', 'Xavier University – Ateneo de Cagayan'),
(15,'BSN Nursing',              '2015-04-08', 'Capitol University'),
(16,'BSN Nursing',              '2011-05-25', 'Liceo de Cagayan University'),
(17,'BSN Nursing',              '2013-04-14', 'Xavier University – Ateneo de Cagayan'),
(18,'BSN Nursing',              '2016-06-20', 'Capitol University'),
(19,'BSN Nursing',              '2008-04-10', 'Xavier University – Ateneo de Cagayan'),
(20,'BSN Nursing',              '2017-05-15', 'Liceo de Cagayan University'),
(26,'Doctor of Medicine',       '1999-04-18', 'University of the Philippines Manila'),
(27,'Doctor of Medicine',       '2003-06-22', 'Cebu Institute of Medicine'),
(28,'Doctor of Medicine',       '2005-04-14', 'Far Eastern University Institute of Medicine'),
(29,'Doctor of Medicine',       '2001-05-30', 'University of Santo Tomas'),
(30,'Doctor of Medicine',       '2007-04-08', 'Cebu Institute of Medicine'),
(36,'BS Physical Therapy',      '2006-05-12', 'Capitol University'),
(37,'BS Physical Therapy',      '2008-04-20', 'Xavier University – Ateneo de Cagayan'),
(38,'BSBA Human Resources',     '1992-04-15', 'Liceo de Cagayan University'),
(39,'Doctor of Medicine',       '1988-05-20', 'University of the Philippines Manila');


-- =============================================================
--  DATA: WORK EXPERIENCE (selected staff)
-- =============================================================

INSERT INTO WorkExperience (staff_id, position, organization, start_date, end_date) VALUES
(1, 'Staff Nurse',       'Northern Mindanao Medical Center',       '1997-06-01', '2002-05-31'),
(1, 'Senior Nurse',      'J.R. Borja General Hospital',            '2002-06-01', '2010-12-31'),
(2, 'Staff Nurse',       'Cagayan de Oro Medical Center',          '1994-07-01', '2000-06-30'),
(2, 'Charge Nurse',      'Polymedic General Hospital',             '2000-07-01', '2010-12-31'),
(3, 'Staff Nurse',       'Maria Reyna-Xavier University Hospital', '2000-05-01', '2008-04-30'),
(4, 'Staff Nurse',       'Northern Mindanao Medical Center',       '2002-07-01', '2010-06-30'),
(5, 'Staff Nurse',       'Capitol University Medical Center',      '1998-06-01', '2006-05-31'),
(6, 'Resident Doctor',   'J.R. Borja General Hospital',            '1992-07-01', '1995-06-30'),
(6, 'Attending Physician','Cagayan de Oro Medical Center',         '1995-07-01', '2005-12-31'),
(7, 'Resident Doctor',   'Northern Mindanao Medical Center',       '1994-07-01', '1997-06-30'),
(8, 'Consultant',        'Maria Reyna-Xavier University Hospital', '1989-07-01', '2000-12-31'),
(9, 'Resident Doctor',   'Polymedic General Hospital',             '1997-07-01', '2001-06-30'),
(10,'Consultant',        'J.R. Borja General Hospital',            '1991-07-01', '2003-12-31'),
(36,'Physical Therapist','Northern Mindanao Medical Center',       '2006-07-01', '2015-06-30'),
(37,'Physical Therapist','Capitol University Medical Center',      '2008-07-01', '2018-06-30'),
(38,'HR Officer',        'Cagayan de Oro Medical Center',          '1992-07-01', '2010-06-30'),
(39,'Chief of Medicine', 'J.R. Borja General Hospital',            '1988-07-01', '2015-12-31');


-- =============================================================
--  DATA: STAFF ALLOCATION (staff assigned to wards, weekly)
-- =============================================================

INSERT INTO StaffAllocation (staff_id, ward_id, week_beginning, shift_type) VALUES
-- Ward 1 team
(11, 1, '2026-05-04', 'Early'),(12, 1, '2026-05-04', 'Late'),
(13, 1, '2026-05-04', 'Night'),(26, 1, '2026-05-04', 'Early'),
(31, 1, '2026-05-04', 'Early'),(21, 1, '2026-05-04', 'Late'),
-- Ward 2 team
(14, 2, '2026-05-04', 'Early'),(15, 2, '2026-05-04', 'Late'),
(16, 2, '2026-05-04', 'Night'),(27, 2, '2026-05-04', 'Early'),
(32, 2, '2026-05-04', 'Early'),(22, 2, '2026-05-04', 'Night'),
-- Ward 3 team
(17, 3, '2026-05-04', 'Early'),(18, 3, '2026-05-04', 'Late'),
(40, 3, '2026-05-04', 'Night'),(28, 3, '2026-05-04', 'Early'),
(33, 3, '2026-05-04', 'Early'),(23, 3, '2026-05-04', 'Late'),
-- Ward 4 team
(19, 4, '2026-05-04', 'Early'),(20, 4, '2026-05-04', 'Late'),
(41, 4, '2026-05-04', 'Night'),(29, 4, '2026-05-04', 'Early'),
(34, 4, '2026-05-04', 'Early'),(24, 4, '2026-05-04', 'Night'),
-- Ward 5 team
(43, 5, '2026-05-04', 'Early'),(46, 5, '2026-05-04', 'Late'),
(42, 5, '2026-05-04', 'Night'),(30, 5, '2026-05-04', 'Early'),
(35, 5, '2026-05-04', 'Early'),(25, 5, '2026-05-04', 'Late'),
-- Ward 6 (Cardiology) - specialist staff cross-allocated
(6,  6, '2026-05-04', 'Early'),(11, 6, '2026-05-04', 'Late'),
(44, 6, '2026-05-04', 'Night'),(36, 6, '2026-05-04', 'Early'),
-- Ward 7 (Neurology)
(7,  7, '2026-05-04', 'Early'),(13, 7, '2026-05-04', 'Late'),
(47, 7, '2026-05-04', 'Night'),(37, 7, '2026-05-04', 'Early'),
-- Ward 8 (Geriatric)
(8,  8, '2026-05-04', 'Early'),(15, 8, '2026-05-04', 'Late'),
(48, 8, '2026-05-04', 'Night'),(45, 8, '2026-05-04', 'Early'),
-- Ward 9 (Emergency)
(9,  9, '2026-05-04', 'Early'),(17, 9, '2026-05-04', 'Late'),
(49, 9, '2026-05-04', 'Night'),(50, 9, '2026-05-04', 'Early'),
-- Ward 10 (Out-patient Clinic)
(10,10, '2026-05-04', 'Early'),(20, 10,'2026-05-04', 'Late'),
(26,10, '2026-05-04', 'Early'),(27, 10,'2026-05-04', 'Early');


-- =============================================================
--  DATA: APPOINTMENTS (50 appointments)
-- =============================================================

INSERT INTO Appointment (patient_id, consultant_id, appointment_date, appointment_time, examination_room, outcome) VALUES
(1,  6,  '2025-01-06', '09:00', 'Room A-101', 'Waiting List'),
(2,  7,  '2025-01-08', '10:00', 'Room A-102', 'Outpatient'),
(3,  8,  '2025-01-11', '09:30', 'Room B-201', 'Waiting List'),
(4,  9,  '2025-01-13', '11:00', 'Room B-202', 'Outpatient'),
(5,  10, '2025-01-16', '08:30', 'Room C-301', 'Waiting List'),
(6,  6,  '2025-01-19', '10:30', 'Room A-101', 'Outpatient'),
(7,  7,  '2025-01-21', '09:00', 'Room A-102', 'Waiting List'),
(8,  8,  '2025-01-23', '11:30', 'Room B-201', 'Outpatient'),
(9,  9,  '2025-01-26', '08:00', 'Room B-202', 'Waiting List'),
(10, 10, '2025-01-29', '10:00', 'Room C-301', 'Outpatient'),
(11, 6,  '2025-02-02', '09:30', 'Room A-101', 'Waiting List'),
(12, 7,  '2025-02-04', '10:30', 'Room A-102', 'Outpatient'),
(13, 8,  '2025-02-06', '11:00', 'Room B-201', 'Waiting List'),
(14, 9,  '2025-02-09', '09:00', 'Room B-202', 'Outpatient'),
(15, 10, '2025-02-11', '08:30', 'Room C-301', 'Waiting List'),
(16, 6,  '2025-02-13', '10:00', 'Room A-101', 'Outpatient'),
(17, 7,  '2025-02-16', '09:30', 'Room A-102', 'Waiting List'),
(18, 8,  '2025-02-19', '11:30', 'Room B-201', 'Outpatient'),
(19, 9,  '2025-02-21', '08:00', 'Room B-202', 'Waiting List'),
(20, 10, '2025-02-23', '10:30', 'Room C-301', 'Outpatient'),
(21, 6,  '2025-03-02', '09:00', 'Room A-101', 'Waiting List'),
(22, 7,  '2025-03-04', '10:00', 'Room A-102', 'Outpatient'),
(23, 8,  '2025-03-06', '09:30', 'Room B-201', 'Waiting List'),
(24, 9,  '2025-03-09', '11:00', 'Room B-202', 'Outpatient'),
(25, 10, '2025-03-11', '08:30', 'Room C-301', 'Waiting List'),
(26, 6,  '2025-03-13', '10:30', 'Room A-101', 'Outpatient'),
(27, 7,  '2025-03-16', '09:00', 'Room A-102', 'Waiting List'),
(28, 8,  '2025-03-19', '11:30', 'Room B-201', 'Outpatient'),
(29, 9,  '2025-03-21', '08:00', 'Room B-202', 'Waiting List'),
(30, 10, '2025-03-23', '10:00', 'Room C-301', 'Outpatient'),
(31, 6,  '2025-04-02', '09:30', 'Room A-101', 'Waiting List'),
(32, 7,  '2025-04-04', '10:30', 'Room A-102', 'Outpatient'),
(33, 8,  '2025-04-06', '11:00', 'Room B-201', 'Waiting List'),
(34, 9,  '2025-04-09', '09:00', 'Room B-202', 'Outpatient'),
(35, 10, '2025-04-11', '08:30', 'Room C-301', 'Waiting List'),
(36, 6,  '2025-04-13', '10:00', 'Room A-101', 'Outpatient'),
(37, 7,  '2025-04-16', '09:30', 'Room A-102', 'Waiting List'),
(38, 8,  '2025-04-19', '11:30', 'Room B-201', 'Outpatient'),
(39, 9,  '2025-04-21', '08:00', 'Room B-202', 'Waiting List'),
(40, 10, '2025-04-23', '10:30', 'Room C-301', 'Outpatient'),
(41, 6,  '2025-05-02', '09:00', 'Room A-101', 'Waiting List'),
(42, 7,  '2025-05-04', '10:00', 'Room A-102', 'Outpatient'),
(43, 8,  '2025-05-06', '09:30', 'Room B-201', 'Waiting List'),
(44, 9,  '2025-05-09', '11:00', 'Room B-202', 'Outpatient'),
(45, 10, '2025-05-11', '08:30', 'Room C-301', 'Waiting List'),
(46, 6,  '2025-05-13', '10:30', 'Room A-101', 'Outpatient'),
(47, 7,  '2025-05-16', '09:00', 'Room A-102', 'Waiting List'),
(48, 8,  '2025-05-19', '11:30', 'Room B-201', 'Outpatient'),
(49, 9,  '2025-05-21', '08:00', 'Room B-202', 'Waiting List'),
(50, 10, '2025-05-23', '10:30', 'Room C-301', 'Outpatient');


-- =============================================================
--  DATA: IN-PATIENTS (patients placed on wards / waiting list)
-- =============================================================

INSERT INTO InPatient (patient_id, ward_id, bed_id, date_on_waiting_list, expected_stay_days, date_admitted, date_expected_leave, date_actual_leave) VALUES
(1,  1, 1,  '2025-01-06', 14, '2025-01-10', '2025-01-24', '2025-01-23'),
(3,  2, 21, '2025-01-11', 7,  '2025-01-15', '2025-01-22', '2025-01-21'),
(5,  5, 81, '2025-01-16', 10, '2025-01-20', '2025-01-30', '2025-01-28'),
(7,  1, 2,  '2025-01-21', 5,  '2025-01-25', '2025-01-30', '2025-01-29'),
(9,  3, 41, '2025-01-26', 12, '2025-01-30', '2025-02-11', '2025-02-10'),
(11, 6, 101,'2025-02-02', 8,  '2025-02-06', '2025-02-14', '2025-02-13'),
(13, 7, 121,'2025-02-06', 6,  '2025-02-10', '2025-02-16', '2025-02-15'),
(15, 8, 141,'2025-02-11', 15, '2025-02-15', '2025-03-02', '2025-02-28'),
(17, 2, 22, '2025-02-16', 9,  '2025-02-20', '2025-03-01', '2025-02-27'),
(19, 4, 61, '2025-02-21', 7,  '2025-02-25', '2025-03-04', '2025-03-03'),
(21, 1, 3,  '2025-03-02', 11, '2025-03-06', '2025-03-17', '2025-03-16'),
(23, 5, 82, '2025-03-06', 8,  '2025-03-10', '2025-03-18', '2025-03-17'),
(25, 3, 42, '2025-03-11', 14, '2025-03-15', '2025-03-29', '2025-03-28'),
(27, 6, 102,'2025-03-16', 6,  '2025-03-20', '2025-03-26', '2025-03-25'),
(29, 8, 142,'2025-03-21', 10, '2025-03-25', '2025-04-04', '2025-04-03'),
(31, 2, 23, '2025-04-02', 7,  '2025-04-06', '2025-04-13', '2025-04-12'),
(33, 1, 4,  '2025-04-06', 9,  '2025-04-10', '2025-04-19', '2025-04-18'),
(35, 9, 161,'2025-04-11', 3,  '2025-04-12', '2025-04-15', '2025-04-14'),
(37, 5, 83, '2025-04-16', 12, '2025-04-20', '2025-05-02', '2025-04-30'),
(39, 7, 122,'2025-04-21', 8,  '2025-04-25', '2025-05-03', '2025-05-02'),
(41, 1, 5,  '2025-05-02', 14, '2025-05-06', '2025-05-20', NULL),
(43, 3, 43, '2025-05-06', 10, '2025-05-10', '2025-05-20', NULL),
(45, 6, 103,'2025-05-11', 7,  '2025-05-15', '2025-05-22', NULL),
(47, 8, 143,'2025-05-16', 15, '2025-05-20', '2025-06-04', NULL),
(49, 2, 24, '2025-05-21', 5,  '2025-05-25', '2025-05-30', NULL);


-- =============================================================
--  DATA: OUT-PATIENTS (patients seen at clinic)
-- =============================================================

INSERT INTO OutPatient (patient_id, appointment_date, appointment_time) VALUES
(2,  '2025-01-10', '09:00'),
(4,  '2025-01-15', '10:30'),
(6,  '2025-01-21', '11:00'),
(8,  '2025-01-25', '08:30'),
(10, '2025-02-01', '10:00'),
(12, '2025-02-06', '09:30'),
(14, '2025-02-11', '11:30'),
(16, '2025-02-15', '08:00'),
(18, '2025-02-21', '10:30'),
(20, '2025-02-25', '09:00'),
(22, '2025-03-06', '10:00'),
(24, '2025-03-11', '11:00'),
(26, '2025-03-15', '08:30'),
(28, '2025-03-21', '10:30'),
(30, '2025-03-25', '09:00'),
(32, '2025-04-06', '10:00'),
(34, '2025-04-11', '11:30'),
(36, '2025-04-15', '08:00'),
(38, '2025-04-21', '10:00'),
(40, '2025-04-25', '09:30'),
(42, '2025-05-06', '10:30'),
(44, '2025-05-11', '11:00'),
(46, '2025-05-15', '08:30'),
(48, '2025-05-21', '10:00'),
(50, '2025-05-25', '09:00');


-- =============================================================
--  DATA: MEDICAL RECORDS
-- =============================================================

INSERT INTO MedicalRecord (patient_id, diagnosis, treatment, record_date, notes) VALUES
(1,  'Hypertension',              'Amlodipine 5mg daily',           '2025-01-10', 'Monitor BP weekly'),
(2,  'Type 2 Diabetes',           'Metformin 500mg twice daily',    '2025-01-08', 'Low sugar diet advised'),
(3,  'Osteoarthritis',            'Celecoxib 200mg daily',          '2025-01-15', 'Physio referral given'),
(4,  'Coronary Artery Disease',   'Aspirin 80mg, Atorvastatin',     '2025-01-13', 'Cardiology follow-up'),
(5,  'Chronic Kidney Disease',    'Dietary modification, Erythropoietin','2025-01-20','Nephrology consult'),
(6,  'COPD',                      'Salbutamol inhaler PRN',         '2025-01-19', 'Avoid smoke exposure'),
(7,  'Stroke (Ischemic)',         'Aspirin, Clopidogrel, Rehab',    '2025-01-25', 'Neurological monitoring'),
(8,  'Alzheimers Disease',      'Donepezil 10mg nightly',        '2025-01-23', 'Family counseled'),
(9,  'Hip Fracture',              'ORIF surgery, PT',               '2025-01-30', 'Weight-bearing precautions'),
(10, 'Atrial Fibrillation',       'Warfarin, Rate control',         '2025-01-29', 'INR monitoring required'),
(11, 'Pneumonia',                 'Amoxicillin-Clavulanate IV',     '2025-02-06', 'Oxygen support prn'),
(12, 'UTI',                       'Ciprofloxacin 500mg',            '2025-02-04', 'Increase fluid intake'),
(13, 'Parkinsons Disease',      'Levodopa-Carbidopa',             '2025-02-10', 'Fall risk — bed rails up'),
(14, 'Osteoporosis',              'Alendronate 70mg weekly, Ca+',   '2025-02-09', 'DXA scan scheduled'),
(15, 'Congestive Heart Failure',  'Furosemide, Carvedilol',         '2025-02-15', 'Daily weight monitoring'),
(16, 'Dementia',                  'Supportive care, Memantine',     '2025-02-13', 'Wandering risk assessed'),
(17, 'Peptic Ulcer',              'Omeprazole 40mg, Amoxicillin',   '2025-02-20', 'Avoid NSAIDs'),
(18, 'Deep Vein Thrombosis',      'Heparin IV, then Warfarin',      '2025-02-19', 'Compression stockings'),
(19, 'Lumbar Spondylosis',        'Tramadol, Physiotherapy',        '2025-02-25', 'Avoid heavy lifting'),
(20, 'Anemia',                    'Iron supplementation, B12',      '2025-02-23', 'Monthly CBC'),
(21, 'Hypertension, Diabetes',    'Combination therapy',            '2025-03-06', 'Dual condition monitoring'),
(22, 'Rheumatoid Arthritis',      'Methotrexate, Folic Acid',       '2025-03-04', 'Joint protection education'),
(23, 'Femur Fracture',            'ORIF, Post-op PT',               '2025-03-10', 'Non-weight bearing 6 weeks'),
(24, 'Chronic Heart Failure',     'Digoxin, Spironolactone',        '2025-03-09', 'Low sodium diet'),
(25, 'Urinary Retention',         'Tamsulosin, Catheterization',    '2025-03-15', 'Urology referral'),
(26, 'Pulmonary Embolism',        'Heparin IV, Warfarin',           '2025-03-13', 'Bed rest strictly'),
(27, 'Transient Ischemic Attack', 'Aspirin, Statins',               '2025-03-20', 'Brain MRI ordered'),
(28, 'Cataract (bilateral)',      'Surgery scheduled',              '2025-03-19', 'Pre-op clearance done'),
(29, 'Prostate Hyperplasia',      'Tamsulosin, Finasteride',        '2025-03-25', 'Urology monitoring'),
(30, 'Hypothyroidism',            'Levothyroxine 50mcg daily',      '2025-03-23', 'TSH recheck in 6 weeks');


-- =============================================================
--  DATA: PHARMACEUTICAL SUPPLIES
-- =============================================================

INSERT INTO PharmaceuticalSupply (drug_name, description, dosage, method_of_admin, quantity_in_stock, reorder_level, cost_per_unit) VALUES
('Amlodipine',          'Calcium channel blocker',       '5mg',       'Oral',       500, 50,  12.50),
('Metformin',           'Antidiabetic',                  '500mg',     'Oral',       800, 80,  8.75),
('Celecoxib',           'COX-2 inhibitor',               '200mg',     'Oral',       300, 30,  25.00),
('Aspirin',             'Antiplatelet',                  '80mg',      'Oral',       1000,100, 3.50),
('Atorvastatin',        'Statin lipid-lowering',         '40mg',      'Oral',       600, 60,  18.00),
('Salbutamol',          'Bronchodilator inhaler',        '100mcg',    'Inhalation', 200, 20,  85.00),
('Clopidogrel',         'Antiplatelet',                  '75mg',      'Oral',       400, 40,  22.00),
('Donepezil',           'Cholinesterase inhibitor',      '10mg',      'Oral',       150, 15,  65.00),
('Warfarin',            'Anticoagulant',                 '5mg',       'Oral',       300, 30,  14.00),
('Amoxicillin-Clavulanate','Beta-lactam antibiotic',    '1.2g',      'IV',         200, 20,  95.00),
('Ciprofloxacin',       'Fluoroquinolone antibiotic',    '500mg',     'Oral',       400, 40,  20.00),
('Levodopa-Carbidopa',  'Antiparkinsonian',              '250/25mg',  'Oral',       100, 10,  45.00),
('Alendronate',         'Bisphosphonate',                '70mg',      'Oral',       200, 20,  55.00),
('Furosemide',          'Loop diuretic',                 '40mg',      'Oral',       500, 50,  5.00),
('Carvedilol',          'Beta-blocker',                  '12.5mg',    'Oral',       300, 30,  16.00),
('Memantine',           'NMDA antagonist',               '10mg',      'Oral',       100, 10,  70.00),
('Omeprazole',          'Proton pump inhibitor',         '40mg',      'Oral',       600, 60,  10.00),
('Heparin',             'Anticoagulant',                 '5000IU/ml', 'IV',         150, 15,  120.00),
('Tramadol',            'Opioid analgesic',              '50mg',      'Oral',       300, 30,  18.00),
('Morphine',            'Opioid analgesic',              '10mg/ml',   'IV',         100, 10,  150.00);


-- =============================================================
--  DATA: SURGICAL SUPPLIES
-- =============================================================

INSERT INTO SurgicalSupply (item_name, item_type, description, quantity_in_stock, reorder_level, cost_per_unit) VALUES
('Sterile Syringe 5ml',     'Surgical',     'Disposable syringe',           2000, 200, 5.00),
('Sterile Gloves (pair)',    'Surgical',     'Latex examination gloves',     3000, 300, 12.00),
('Sterile Dressing',        'Surgical',     'Gauze wound dressing',         2500, 250, 8.00),
('IV Cannula 18G',          'Surgical',     'Intravenous access cannula',   1500, 150, 15.00),
('Foley Catheter 16Fr',     'Surgical',     'Urinary catheter',             500,  50,  45.00),
('Nasogastric Tube',        'Surgical',     'Feeding/drainage tube',        300,  30,  60.00),
('Suture Kit',              'Surgical',     'Sterile suturing set',         400,  40,  85.00),
('Scalpel Blade No. 22',    'Surgical',     'Sterile surgical blade',       1000, 100, 10.00),
('Surgical Mask',           'Non-Surgical', 'Disposable face mask',         5000, 500, 3.50),
('Plastic Apron',           'Non-Surgical', 'Disposable protective apron',  4000, 400, 4.00),
('Plastic Bag (lg)',        'Non-Surgical', 'Clinical waste bag',           3000, 300, 2.50),
('Hand Sanitizer 500ml',    'Non-Surgical', 'Alcohol-based sanitizer',      500,  50,  65.00),
('Adhesive Bandage',        'Non-Surgical', 'Wound closure strip',          3000, 300, 2.00),
('Tongue Depressor',        'Non-Surgical', 'Disposable tongue blade',      2000, 200, 1.50),
('Specimen Container',      'Surgical',     'Sterile urine/specimen cup',   1000, 100, 8.00);


-- =============================================================
--  DATA: SUPPLIERS
-- =============================================================

INSERT INTO Supplier (supplier_name, address, phone_number, fax_number) VALUES
('MedSupply Philippines Inc.',    'Corrales Ave., Cagayan de Oro City',      '088-857-2001', '088-857-2011'),
('Pharma Depot CDO',              'Tiano Brothers St., Cagayan de Oro City', '088-857-2002', '088-857-2012'),
('Northern Mindanao MedCo',       'Kauswagan Highway, Cagayan de Oro City',  '088-857-2003', '088-857-2013'),
('Mindanao Surgical Supply Co.',  'Velez St., Cagayan de Oro City',          '088-857-2004', '088-857-2014'),
('PhilHealth Pharma Distributors','Capistrano St., Cagayan de Oro City',     '088-857-2005', '088-857-2015');


-- =============================================================
--  DATA: PATIENT MEDICATION
-- =============================================================

INSERT INTO PatientMedication (patient_id, drug_id, units_per_day, start_date, end_date) VALUES
(1,  1,  1, '2025-01-10', '2025-03-10'),
(2,  2,  2, '2025-01-08', '2025-04-08'),
(3,  3,  1, '2025-01-15', '2025-02-15'),
(4,  4,  1, '2025-01-13', NULL),
(4,  5,  1, '2025-01-13', NULL),
(5,  14, 1, '2025-01-20', NULL),
(6,  6,  4, '2025-01-19', NULL),
(7,  4,  1, '2025-01-25', NULL),
(7,  7,  1, '2025-01-25', NULL),
(8,  8,  1, '2025-01-23', NULL),
(9,  20, 3, '2025-01-30', '2025-02-14'),
(10, 9,  1, '2025-01-29', NULL),
(11, 10, 4, '2025-02-06', '2025-02-20'),
(12, 11, 2, '2025-02-04', '2025-02-11'),
(13, 12, 3, '2025-02-10', NULL),
(14, 13, 1, '2025-02-09', NULL),
(15, 14, 1, '2025-02-15', NULL),
(15, 15, 2, '2025-02-15', NULL),
(17, 17, 1, '2025-02-20', '2025-03-06'),
(18, 18, 24,'2025-02-19', '2025-03-05'),
(19, 19, 2, '2025-02-25', '2025-03-25'),
(20, 2,  2, '2025-02-23', NULL),
(21, 1,  1, '2025-03-06', NULL),
(21, 2,  2, '2025-03-06', NULL),
(22, 3,  1, '2025-03-04', NULL),
(23, 20, 3, '2025-03-10', '2025-04-10'),
(26, 18, 24,'2025-03-13', '2025-03-27'),
(27, 4,  1, '2025-03-20', NULL),
(29, 17, 1, '2025-03-25', NULL);


-- =============================================================
--  DATA: WARD REQUISITIONS
-- =============================================================

INSERT INTO WardRequisition (ward_id, requested_by_id, requisition_date, signed_by_id, date_signed) VALUES
(1, 1, '2026-01-10', 1, '2026-01-11'),
(2, 2, '2026-01-15', 2, '2026-01-16'),
(3, 3, '2026-01-20', 3, '2026-01-21'),
(5, 5, '2026-02-01', 5, '2026-02-02'),
(6, 1, '2026-02-10', 1, '2026-02-11'),
(8, 3, '2026-02-15', 3, '2026-02-16'),
(1, 1, '2026-03-01', 1, '2026-03-02'),
(4, 4, '2026-03-10', 4, '2026-03-11'),
(7, 2, '2026-03-15', 2, '2026-03-16'),
(9, 4, '2026-03-20', 4, '2026-03-21');


-- =============================================================
--  DATA: REQUISITION ITEMS
-- =============================================================

INSERT INTO RequisitionItem (requisition_id, item_type, drug_id, item_id, quantity_required, cost_per_unit) VALUES
(1, 'Pharmaceutical', 20,   NULL, 50,  150.00),
(1, 'Surgical',       NULL, 1,   200,  5.00),
(1, 'Non-Surgical',   NULL, 9,   500,  3.50),
(2, 'Pharmaceutical', 10,   NULL, 100, 95.00),
(2, 'Surgical',       NULL, 4,   150,  15.00),
(3, 'Pharmaceutical', 2,    NULL, 200, 8.75),
(3, 'Non-Surgical',   NULL, 10,  400,  4.00),
(4, 'Pharmaceutical', 19,   NULL, 100, 18.00),
(4, 'Surgical',       NULL, 3,   250,  8.00),
(5, 'Pharmaceutical', 1,    NULL, 100, 12.50),
(5, 'Pharmaceutical', 9,    NULL, 60,  14.00),
(6, 'Pharmaceutical', 8,    NULL, 30,  65.00),
(6, 'Surgical',       NULL, 5,   50,   45.00),
(7, 'Non-Surgical',   NULL, 12,  20,   65.00),
(7, 'Surgical',       NULL, 7,   40,   85.00),
(8, 'Pharmaceutical', 12,   NULL, 50,  45.00),
(9, 'Pharmaceutical', 7,    NULL, 80,  22.00),
(10,'Pharmaceutical', 18,   NULL, 30,  120.00),
(10,'Surgical',       NULL, 6,   30,   60.00);


-- =============================================================
--  DATA: PATIENT ALLOCATION (50 records)
-- =============================================================

INSERT INTO PatientAllocation (patient_id, ward_id, bed_id, date_on_waiting_list, expected_duration_days, date_placed, date_expected_leave, actual_date_left) VALUES
(1,  1, 1,  '2025-01-06', 14, '2025-01-10', '2025-01-24', '2025-01-23'),
(3,  2, 21, '2025-01-11', 7,  '2025-01-15', '2025-01-22', '2025-01-21'),
(5,  5, 81, '2025-01-16', 10, '2025-01-20', '2025-01-30', '2025-01-28'),
(7,  1, 2,  '2025-01-21', 5,  '2025-01-25', '2025-01-30', '2025-01-29'),
(9,  3, 41, '2025-01-26', 12, '2025-01-30', '2025-02-11', '2025-02-10'),
(11, 6, 101,'2025-02-02', 8,  '2025-02-06', '2025-02-14', '2025-02-13'),
(13, 7, 121,'2025-02-06', 6,  '2025-02-10', '2025-02-16', '2025-02-15'),
(15, 8, 141,'2025-02-11', 15, '2025-02-15', '2025-03-02', '2025-02-28'),
(17, 2, 22, '2025-02-16', 9,  '2025-02-20', '2025-03-01', '2025-02-27'),
(19, 4, 61, '2025-02-21', 7,  '2025-02-25', '2025-03-04', '2025-03-03'),
(21, 1, 3,  '2025-03-02', 11, '2025-03-06', '2025-03-17', '2025-03-16'),
(23, 5, 82, '2025-03-06', 8,  '2025-03-10', '2025-03-18', '2025-03-17'),
(25, 3, 42, '2025-03-11', 14, '2025-03-15', '2025-03-29', '2025-03-28'),
(27, 6, 102,'2025-03-16', 6,  '2025-03-20', '2025-03-26', '2025-03-25'),
(29, 8, 142,'2025-03-21', 10, '2025-03-25', '2025-04-04', '2025-04-03'),
(31, 2, 23, '2025-04-02', 7,  '2025-04-06', '2025-04-13', '2025-04-12'),
(33, 1, 4,  '2025-04-06', 9,  '2025-04-10', '2025-04-19', '2025-04-18'),
(35, 9, 161,'2025-04-11', 3,  '2025-04-12', '2025-04-15', '2025-04-14'),
(37, 5, 83, '2025-04-16', 12, '2025-04-20', '2025-05-02', '2025-04-30'),
(39, 7, 122,'2025-04-21', 8,  '2025-04-25', '2025-05-03', '2025-05-02'),
(41, 1, 5,  '2025-05-02', 14, '2025-05-06', '2025-05-20', NULL),
(43, 3, 43, '2025-05-06', 10, '2025-05-10', '2025-05-20', NULL),
(45, 6, 103,'2025-05-11', 7,  '2025-05-15', '2025-05-22', NULL),
(47, 8, 143,'2025-05-16', 15, '2025-05-20', '2025-06-04', NULL),
(49, 2, 24, '2025-05-21', 5,  '2025-05-25', '2025-05-30', NULL),
(51, 1, 6,  '2025-06-01', 10, '2025-06-05', '2025-06-15', '2025-06-14'),
(53, 4, 62, '2025-06-05', 7,  '2025-06-09', '2025-06-16', '2025-06-15'),
(55, 5, 84, '2025-06-10', 12, '2025-06-14', '2025-06-26', '2025-06-25'),
(57, 3, 44, '2025-06-15', 8,  '2025-06-19', '2025-06-27', '2025-06-26'),
(59, 8, 144,'2025-06-20', 14, '2025-06-24', '2025-07-08', '2025-07-07'),
(61, 6, 104,'2025-07-01', 6,  '2025-07-05', '2025-07-11', '2025-07-10'),
(63, 2, 25, '2025-07-05', 9,  '2025-07-09', '2025-07-18', '2025-07-17'),
(65, 7, 123,'2025-07-10', 11, '2025-07-14', '2025-07-25', '2025-07-24'),
(67, 1, 7,  '2025-07-15', 7,  '2025-07-19', '2025-07-26', '2025-07-25'),
(69, 5, 85, '2025-07-20', 10, '2025-07-24', '2025-08-03', '2025-08-02'),
(71, 9, 162,'2025-08-01', 3,  '2025-08-02', '2025-08-05', '2025-08-04'),
(73, 3, 45, '2025-08-05', 8,  '2025-08-09', '2025-08-17', '2025-08-16'),
(75, 8, 145,'2025-08-10', 14, '2025-08-14', '2025-08-28', '2025-08-27'),
(77, 6, 105,'2025-08-15', 7,  '2025-08-19', '2025-08-26', '2025-08-25'),
(79, 2, 26, '2025-08-20', 9,  '2025-08-24', '2025-09-02', '2025-09-01'),
(81, 1, 8,  '2025-09-01', 11, '2025-09-05', '2025-09-16', '2025-09-15'),
(83, 5, 86, '2025-09-05', 8,  '2025-09-09', '2025-09-17', '2025-09-16'),
(85, 7, 124,'2025-09-10', 6,  '2025-09-14', '2025-09-20', '2025-09-19'),
(87, 4, 63, '2025-09-15', 12, '2025-09-19', '2025-10-01', '2025-09-30'),
(89, 8, 146,'2025-09-20', 10, '2025-09-24', '2025-10-04', '2025-10-03'),
(91, 1, 9,  '2025-10-01', 7,  '2025-10-05', '2025-10-12', '2025-10-11'),
(93, 3, 46, '2025-10-05', 9,  '2025-10-09', '2025-10-18', '2025-10-17'),
(95, 6, 106,'2025-10-10', 5,  '2025-10-14', '2025-10-19', '2025-10-18'),
(97, 2, 27, '2025-10-15', 11, '2025-10-19', '2025-10-30', NULL),
(99, 5, 87, '2025-10-20', 8,  '2025-10-24', '2025-11-01', NULL);


-- =============================================================
--  USEFUL VIEWS
-- =============================================================

CREATE OR REPLACE VIEW v_patient_summary AS
SELECT
    p.patient_id,
    p.first_name || ' ' || p.last_name AS full_name,
    p.date_of_birth,
    DATE_PART('year', AGE(p.date_of_birth)) AS age,
    p.sex,
    p.marital_status,
    p.phone_number,
    p.date_registered,
    n.full_name AS next_of_kin,
    n.relationship,
    n.phone_number AS nok_phone
FROM Patient p
LEFT JOIN NextOfKin n ON p.patient_id = n.patient_id;

CREATE OR REPLACE VIEW v_ward_occupancy AS
SELECT
    w.ward_id,
    w.ward_name,
    w.location,
    w.total_beds,
    COUNT(b.bed_id) FILTER (WHERE b.status = 'Occupied') AS beds_occupied,
    COUNT(b.bed_id) FILTER (WHERE b.status = 'Available') AS beds_available,
    w.tel_extension,
    s.first_name || ' ' || s.last_name AS charge_nurse
FROM Ward w
LEFT JOIN Bed b ON w.ward_id = b.ward_id
LEFT JOIN Staff s ON w.charge_nurse_id = s.staff_id
GROUP BY w.ward_id, w.ward_name, w.location, w.total_beds, w.tel_extension, s.first_name, s.last_name;

CREATE OR REPLACE VIEW v_current_inpatients AS
SELECT
    p.patient_id,
    p.first_name || ' ' || p.last_name AS patient_name,
    w.ward_name,
    b.bed_number,
    ip.date_admitted,
    ip.date_expected_leave,
    ip.expected_stay_days
FROM InPatient ip
JOIN Patient p  ON ip.patient_id = p.patient_id
JOIN Ward w     ON ip.ward_id    = w.ward_id
LEFT JOIN Bed b ON ip.bed_id     = b.bed_id
WHERE ip.date_actual_leave IS NULL;

CREATE OR REPLACE VIEW v_staff_ward AS
SELECT
    s.staff_id,
    s.first_name || ' ' || s.last_name AS staff_name,
    s.position,
    w.ward_name,
    sa.shift_type,
    sa.week_beginning
FROM StaffAllocation sa
JOIN Staff s ON sa.staff_id = s.staff_id
JOIN Ward  w ON sa.ward_id  = w.ward_id;

