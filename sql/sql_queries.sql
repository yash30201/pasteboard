CREATE TABLE paste (
	id INT NOT NULL AUTO_INCREMENT,
	created_at TIMESTAMP DEFAULT now(),
	modified_at TIMESTAMP DEFAULT now() ON UPDATE now(),
	type ENUM('text', 'image') NOT NULL,
	title VARCHAR(200) NOT NULL,
	content VARCHAR(1000) NOT NULL,
	user_id VARCHAR(130) NOT NULL,
	PRIMARY KEY (id)
);
