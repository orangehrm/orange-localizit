CREATE TABLE ohrm_label (label_id INT AUTO_INCREMENT, label_name VARCHAR(45) NOT NULL, label_comment VARCHAR(100), label_status VARCHAR(1) NOT NULL, PRIMARY KEY(label_id)) ENGINE = INNODB;
CREATE TABLE ohrm_language (language_id INT AUTO_INCREMENT, language_code VARCHAR(10) NOT NULL, language_name VARCHAR(45) NOT NULL, language_status VARCHAR(1) NOT NULL, PRIMARY KEY(language_id)) ENGINE = INNODB;
CREATE TABLE ohrm_language_label_string (language_label_string_id INT AUTO_INCREMENT, label_id INT NOT NULL, language_id INT NOT NULL, language_label_string VARCHAR(45) NOT NULL, language_label_string_status VARCHAR(1) NOT NULL, INDEX label_id_idx (label_id), INDEX language_id_idx (language_id), PRIMARY KEY(language_label_string_id)) ENGINE = INNODB;
CREATE TABLE ohrm_user (user_id INT AUTO_INCREMENT, login_name VARCHAR(25) NOT NULL, password VARCHAR(25) NOT NULL, user_type_id INT NOT NULL, PRIMARY KEY(user_id)) ENGINE = INNODB;
CREATE TABLE ohrm_user_type (id INT AUTO_INCREMENT, user_type VARCHAR(25) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE ohrm_user_language (id INT AUTO_INCREMENT, user_id INT NOT NULL, language_id INT NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE ohrm_language_label_string ADD CONSTRAINT ohrm_language_label_string_language_id_ohrm_language_language_id FOREIGN KEY (language_id) REFERENCES ohrm_language(language_id);
ALTER TABLE ohrm_language_label_string ADD CONSTRAINT ohrm_language_label_string_label_id_ohrm_label_label_id FOREIGN KEY (label_id) REFERENCES ohrm_label(label_id);