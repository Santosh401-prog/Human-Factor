CREATE TABLE patients (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT(3) NOT NULL
);

INSERT INTO patients (name, age) 
VALUES ('John Doe', 34), ('Jane Smith', 28), ('Bob Johnson', 40);
