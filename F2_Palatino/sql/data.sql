CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE branches (
	branch_id INT AUTO_INCREMENT PRIMARY KEY,
	Manager VARCHAR(255),
	contact_number VARCHAR(255),
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
	added_by VARCHAR(255),
	last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	last_updated_by VARCHAR(255)
);


create table activity_logs (
	Applicant_id INT AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	email VARCHAR(255),
	gender VARCHAR(255),
	address VARCHAR(255),
    job_position VARCHAR(255),
    application_status VARCHAR (255),
    branch_id INT,
	date_applied TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);