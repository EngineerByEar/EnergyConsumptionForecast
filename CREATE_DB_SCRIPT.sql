CREATE TABLE `model` (
  `model_id` int UNIQUE NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) UNIQUE PRIMARY KEY NOT NULL,
  `model_creator` varchar(255) NOT NULL,
  `model_creation` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `model_type` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL,
  `model_type` varchar(255) NOT NULL
);

CREATE TABLE `model_features` (
  `model_id` int NOT NULL,
  `feature_name` varchar(255) NOT NULL
);

CREATE TABLE `model_hyperparameters` (
  `model_id` int NOT NULL,
  `hyperparameter` varchar(255) NOT NULL,
  `value` float NOT NULL
);

CREATE TABLE `model_training_data` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL,
  `training_start` datetime NOT NULL,
  `training_end` datetime NOT NULL
);

CREATE TABLE `model_score` (
  `model_id` int UNIQUE PRIMARY KEY NOT NULL,
  `score` float NOT NULL
);

CREATE UNIQUE INDEX `feature_index` ON `model_features` (`model_id`, `feature_name`);

CREATE UNIQUE INDEX `hyperparameter_index` ON `model_hyperparameters` (`model_id`, `hyperparameter`);

ALTER TABLE `model_type` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_features` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_hyperparameters` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_training_data` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;

ALTER TABLE `model_score` ADD FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE CASCADE;
