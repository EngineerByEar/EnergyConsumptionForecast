CREATE TABLE `model` (
  `model_id` int UNIQUE NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) UNIQUE PRIMARY KEY NOT NULL,
  `model_creator` varchar(255) NOT NULL,
  `model_creation` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `model_type` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL
);

CREATE TABLE `model_features` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `feature_name` varchar(255) NOT NULL
);

CREATE TABLE `model_hyperparameters` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `hyperparameter` varchar(255) NOT NULL,
  `value` float NOT NULL
);

CREATE TABLE `model_training_data` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `training_start` datetime NOT NULL,
  `training_end` datetime NOT NULL
);

CREATE TABLE `model_score` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `score` float NOT NULL
);

ALTER TABLE `model_type` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_features` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_hyperparameters` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_training_data` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model` ADD FOREIGN KEY (`model_id`) REFERENCES `model_score` (`model_id`) ON DELETE CASCADE;
