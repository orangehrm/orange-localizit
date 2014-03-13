SET @general_id := (SELECT `id` FROM `ohrm_group` WHERE `name` ='General' LIMIT 1);

UPDATE `ohrm_source` SET `group_id`=@general_id WHERE NOT `group_id` = @general_id;

DELETE FROM `ohrm_group` WHERE NOT `id` = @general_id;

DELETE FROM `ohrm_source` WHERE `id` NOT IN (SELECT * FROM (SELECT MIN(s.`id`) FROM `ohrm_source` s GROUP BY BINARY s.`value`) x);
