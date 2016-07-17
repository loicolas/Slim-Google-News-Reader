CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX user_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

INSERT INTO user SET email = 'test@test.fr', password = '$2y$10$AAbVI/8p4koMaT9ssbIKeuMhgyQtqn1/xtMqvmNseT6QxlOnzKwmu', username = 'JohnDoe';
INSERT INTO user_feed_preference SET user_id=1, feed='athome', active=1;
INSERT INTO user_feed_preference SET user_id=1, feed='slim', active=1;