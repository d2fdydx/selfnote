CREATE TABLE user_levels (
	id INTEGER PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	grade INTEGER UNSIGNED NOT NULL,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
	id INTEGER PRIMARY KEY,
	user_name VARCHAR(50) NOT NULL,
	nickname VARCHAR(100) ,
	password CHAR(255) NOT NULL,
	user_levels_id INTEGER UNSIGNED NOT NULL DEFAULT 0,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_levels_id) REFERENCES user_levels(id)
);

