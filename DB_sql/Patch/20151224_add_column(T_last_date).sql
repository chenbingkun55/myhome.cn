ALTER TABLE `task_lib`
ADD COLUMN `T_last_date`  char(12) NULL COMMENT '最后更新时间' AFTER `C_date`;
