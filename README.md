# gesifar-api

`npm start `

to visualize data in the browser

**in Lagaron:**

create database called gasifar-api
run following SQL commands:
```
CREATE TABLE `usuarios` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL DEFAULT NULL,
	`lastname` VARCHAR(50) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`password` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
```

Run and create data:
```
INSERT INTO usuarios(NAME,lastname,email,PASSWORD) VALUES('Laura','Schell','admin1@gmail.com','admin1');
```
And
```
INSERT INTO usuarios(NAME,lastname,email,PASSWORD) VALUES('Juan','Perez','admin2@gmail.com','admin2');
```

Then
```
CREATE TABLE `profesionales` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`DNI` VARCHAR(10) NULL DEFAULT NULL,
	`name` VARCHAR(50) NULL DEFAULT NULL,
	`lastName` VARCHAR(50) NULL DEFAULT NULL,
	`profesion` VARCHAR(50) NULL DEFAULT NULL,
	`area` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
```
And 
`INSERT INTO profesionales(dni, NAME,lastname,profesion,area) VALUES('23456789','Maria','Lopez','Enfermera','Cirugia General');`

And lastly
`INSERT INTO profesionales(dni, NAME,lastname,profesion,area) VALUES('54657698','Jose','Gomez','Medico','Pediatria');`
