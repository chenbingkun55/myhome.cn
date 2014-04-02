ALTER TABLE `task_lib`
ADD COLUMN `T_exp_time`  char(12) NULL COMMENT '预计用时,以秒为单位' AFTER `T_date`;