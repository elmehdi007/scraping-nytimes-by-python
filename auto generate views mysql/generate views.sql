-- procedure auto generate views mysql
delimiter //

drop procedure if exists generate_views //
create procedure generate_views(IN database_name CHAR(255))
begin
    DECLARE done BOOL default false;
    DECLARE tablename CHAR(255);
	 DECLARE sql_text_log CHAR(255) DEFAULT '';
    DECLARE cur1 cursor for SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables 
	 								 WHERE table_type='BASE TABLE' and  TABLE_SCHEMA = database_name;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    open cur1;

    myloop: loop
        fetch cur1 into tablename;
        if done then
            leave myloop;
        end if;
        set @new_view_name = CONCAT('`view_',tablename,'`');
        SET @drop_view_commande = CONCAT(' DROP VIEW IF EXISTS ', @new_view_name, ' ;');
        SET @creat_view_commande= CONCAT(' CREATE VIEW ',@new_view_name ,' AS SELECT * FROM `', tablename,'` ;');
		  set sql_text_log = CONCAT(sql_text_log, @drop_view_commande, @creat_view_commande);
	    
		  prepare stmt FROM @drop_view_commande;
	  	  execute stmt;
	     drop prepare stmt;
	     
	     prepare stmt FROM @creat_view_commande;
	  	  execute stmt;
	     drop prepare stmt;
    end loop;
    
	 SELECT sql_text_log;
    close cur1;
end //

delimiter ;

call generate_views(DATABASE());#DATABASE() return selected database
