CREATE DATABASE IF NOT EXISTS employee_management_system;
USE employee_management_system;

DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS departments;

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL UNIQUE,
    department_code VARCHAR(20) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_no VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) DEFAULT NULL,
    job_title VARCHAR(100) NOT NULL,
    hire_date DATE NOT NULL,
    salary DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    department_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_employee_department
        FOREIGN KEY (department_id) REFERENCES departments(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    time_in TIME DEFAULT NULL,
    time_out TIME DEFAULT NULL,
    attendance_status ENUM('Present', 'Absent', 'Late', 'On Leave') NOT NULL DEFAULT 'Present',
    remarks VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attendance_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO departments (department_name, department_code, description) VALUES
('Human Resources', 'HR', 'Nagdumala sa recruitment, records sa empleyado, ug employee relations'),
('Information Technology', 'IT', 'Nag-atiman sa computers, network, systems, ug technical support'),
('Finance', 'FIN', 'Nagdumala sa budget, sweldo, bayranan, ug financial records'),
('Operations', 'OPS', 'Nagdumala sa adlaw-adlaw nga operasyon sa kompanya'),
('Customer Service', 'CS', 'Nag-atiman sa mga pangutana ug concern sa mga kliyente'),
('Sales and Marketing', 'SM', 'Nagpasiugda sa produkto ug nagdumala sa sales activities'),
('Administration', 'ADMIN', 'Nagtabang sa office coordination, files, ug internal support'),
('Logistics', 'LOG', 'Nagdumala sa delivery, inventory movement, ug scheduling'),
('Procurement', 'PROC', 'Nagdumala sa pagpalit sa supplies ug pag-coordinate sa suppliers'),
('Research and Development', 'RD', 'Nagtuon ug nagpalambo sa bag-ong ideas, proseso, ug serbisyo');

INSERT INTO employees (employee_no, first_name, last_name, email, phone, job_title, hire_date, salary, status, department_id) VALUES
('EMP-1001', 'John', 'Doe', 'john.doe@email.com', '09123456789', 'HR Officer', '2024-01-10', 25000.00, 'Active', 1),
('EMP-1002', 'Jane', 'Smith', 'jane.smith@email.com', '09987654321', 'System Administrator', '2023-06-15', 35000.00, 'Active', 2),
('EMP-1003', 'Mark', 'Lee', 'mark.lee@email.com', '09112223344', 'Accountant', '2022-03-20', 30000.00, 'Active', 3),
('EMP-1004', 'Junriel', 'Abellanosa', 'junriel.abellanosa@email.com', '09124567890', 'Operations Assistant', '2023-02-14', 22000.00, 'Active', 4),
('EMP-1005', 'Maricel', 'Bation', 'maricel.bation@email.com', '09125678901', 'Customer Service Representative', '2024-03-01', 21000.00, 'Active', 5),
('EMP-1006', 'Rodel', 'Cabahug', 'rodel.cabahug@email.com', '09126789012', 'Sales Associate', '2022-07-21', 24000.00, 'Active', 6),
('EMP-1007', 'Lyn', 'Dalogdog', 'lyn.dalogdog@email.com', '09127890123', 'Administrative Officer', '2021-11-10', 26000.00, 'Active', 7),
('EMP-1008', 'Nestor', 'Ebarle', 'nestor.ebarle@email.com', '09128901234', 'Logistics Coordinator', '2023-08-05', 23500.00, 'Active', 8),
('EMP-1009', 'Gemma', 'Fernandez', 'gemma.fernandez@email.com', '09129012345', 'Procurement Staff', '2024-01-17', 22500.00, 'Active', 9),
('EMP-1010', 'Arvin', 'Gica', 'arvin.gica@email.com', '09130123456', 'Research Assistant', '2022-05-09', 28000.00, 'Active', 10),
('EMP-1011', 'Cherry', 'Hingpit', 'cherry.hingpit@email.com', '09131234567', 'HR Assistant', '2023-09-12', 21500.00, 'Active', 1),
('EMP-1012', 'Bong', 'Igot', 'bong.igot@email.com', '09132345678', 'Technical Support Staff', '2021-12-03', 27000.00, 'Active', 2),
('EMP-1013', 'Elsa', 'Jumawan', 'elsa.jumawan@email.com', '09133456789', 'Finance Clerk', '2024-02-20', 23000.00, 'Active', 3),
('EMP-1014', 'Toto', 'Kilat', 'toto.kilat@email.com', '09134567890', 'Operations Supervisor', '2020-10-15', 32000.00, 'Active', 4),
('EMP-1015', 'Mylene', 'Lagdameo', 'mylene.lagdameo@email.com', '09135678901', 'Customer Support Officer', '2022-06-11', 24500.00, 'Active', 5),
('EMP-1016', 'Ramil', 'Mancao', 'ramil.mancao@email.com', '09136789012', 'Marketing Assistant', '2023-04-22', 23800.00, 'Active', 6),
('EMP-1017', 'Susan', 'Neri', 'susan.neri@email.com', '09137890123', 'Office Secretary', '2021-01-29', 25000.00, 'Active', 7),
('EMP-1018', 'Dindo', 'Ompad', 'dindo.ompad@email.com', '09138901234', 'Warehouse Staff', '2024-03-18', 20500.00, 'Active', 8),
('EMP-1019', 'Karen', 'Paderna', 'karen.paderna@email.com', '09139012345', 'Purchasing Assistant', '2023-05-30', 22700.00, 'Active', 9),
('EMP-1020', 'Leo', 'Quijano', 'leo.quijano@email.com', '09140123456', 'Project Researcher', '2022-09-08', 29500.00, 'Active', 10),
('EMP-1021', 'Joan', 'Rabaya', 'joan.rabaya@email.com', '09141234567', 'Recruitment Staff', '2024-01-05', 22200.00, 'Active', 1),
('EMP-1022', 'Patrick', 'Sabio', 'patrick.sabio@email.com', '09142345678', 'Network Technician', '2023-07-13', 28500.00, 'Active', 2),
('EMP-1023', 'Nena', 'Tabanao', 'nena.tabanao@email.com', '09143456789', 'Accounting Assistant', '2022-08-16', 24000.00, 'Active', 3),
('EMP-1024', 'Rico', 'Ubanan', 'rico.ubanan@email.com', '09144567890', 'Operations Clerk', '2024-02-08', 21000.00, 'Inactive', 4),
('EMP-1025', 'May', 'Villarin', 'may.villarin@email.com', '09145678901', 'Client Relations Staff', '2021-06-25', 24800.00, 'Active', 5),
('EMP-1026', 'Jasper', 'Wenceslao', 'jasper.wenceslao@email.com', '09146789012', 'Sales Coordinator', '2023-10-19', 25500.00, 'Active', 6),
('EMP-1027', 'Tessa', 'Ybanez', 'tessa.ybanez@email.com', '09147890123', 'Admin Assistant', '2022-11-27', 23200.00, 'Active', 7),
('EMP-1028', 'Randy', 'Zosa', 'randy.zosa@email.com', '09148901234', 'Delivery Dispatcher', '2024-03-10', 21800.00, 'Active', 8);

INSERT INTO attendance (employee_id, attendance_date, time_in, time_out, attendance_status, remarks) VALUES
(1, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'On time'),
(2, '2026-04-15', '08:20:00', '17:00:00', 'Late', 'Traffic'),
(3, '2026-04-15', NULL, NULL, 'On Leave', 'Approved leave'),
(4, '2026-04-15', '08:05:00', '17:00:00', 'Present', 'Niabot sakto ra, nakahuman sa mga buluhaton'),
(5, '2026-04-15', '08:10:00', '17:00:00', 'Late', 'Naulahi gamay tungod sa trapik'),
(6, '2026-04-15', '07:58:00', '17:05:00', 'Present', 'Sayo niabot ug aktibo sa duty'),
(7, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Kompleto ang attendance karong adlawa'),
(8, '2026-04-15', NULL, NULL, 'On Leave', 'Naka-file ug leave para family occasion'),
(9, '2026-04-15', '08:15:00', '17:00:00', 'Late', 'Na-delay sa biyahe gikan probinsya'),
(10, '2026-04-15', '08:00:00', '17:10:00', 'Present', 'Nag-overtime gamay para mahuman ang report'),
(11, '2026-04-15', '07:55:00', '17:00:00', 'Present', 'Sayo ni-report sa opisina'),
(12, '2026-04-15', '08:30:00', '17:00:00', 'Late', 'Naulahi tungod sa maintenance sa dalan'),
(13, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Normal nga duty'),
(14, '2026-04-15', '07:50:00', '17:20:00', 'Present', 'Nanguna sa morning operations briefing'),
(15, '2026-04-15', NULL, NULL, 'Absent', 'Wala naka-duty ug wala naka-inform daan'),
(16, '2026-04-15', '08:12:00', '17:00:00', 'Late', 'Gamay nga kalangan sa pagsulod'),
(17, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Naasikaso ang office files ug schedules'),
(18, '2026-04-15', '08:03:00', '17:00:00', 'Present', 'Naasikaso ang stocks ug warehouse tasks'),
(19, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Nakapadala sa purchase requests'),
(20, '2026-04-15', '07:57:00', '17:08:00', 'Present', 'Nakompleto ang research summary'),
(21, '2026-04-15', '08:20:00', '17:00:00', 'Late', 'Naulahi tungod sa ulan'),
(22, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Nag-monitor sa network ug devices'),
(23, '2026-04-15', NULL, NULL, 'On Leave', 'On leave kay naay personal nga lakaw'),
(24, '2026-04-15', '08:08:00', '17:00:00', 'Present', 'Nakasuporta sa adlaw-adlaw nga operasyon'),
(25, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Na-entertain ang mga client concerns'),
(26, '2026-04-15', '07:59:00', '17:15:00', 'Present', 'Nihuman sa sales monitoring report'),
(27, '2026-04-15', '08:18:00', '17:00:00', 'Late', 'Naulahi ug gamay tungod sa sakyanan'),
(28, '2026-04-15', '08:00:00', '17:00:00', 'Present', 'Na-coordinate ang delivery schedules');