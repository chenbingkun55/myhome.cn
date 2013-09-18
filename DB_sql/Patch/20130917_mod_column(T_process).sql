ALTER TABLE `task_lib`
MODIFY COLUMN `T_process`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `T_status`;