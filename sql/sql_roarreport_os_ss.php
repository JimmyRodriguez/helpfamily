(SELECT o.os_name AS name,  IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, o.os_code AS code
FROM 
 (stats_os AS o LEFT JOIN  
 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.os FROM user_table AS ut 
    WHERE  ut.valid IN (0,1,2) 
    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
    GROUP BY ut.os 
  ) AS t1 ON o.os_code = t1.os) RIGHT JOIN    
  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.os FROM visit_stats AS vs 
    WHERE   
    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1  AND vs.lp_flag = 1
    GROUP BY vs.os 
   ) AS t2 ON o.os_code = t2.os  
    WHERE stat != 'null' OR stat_vs != 'null' 
 GROUP BY o.os_code ORDER BY ##order## , o.os_name ASC)
 
 UNION
 
( SELECT o.os_name AS name,  IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, o.os_code AS code
FROM 
 (stats_os AS o LEFT JOIN  
 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.os FROM user_table AS ut 
    WHERE  ut.valid IN (0,1,2) 
    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
    GROUP BY ut.os 
  ) AS t1 ON o.os_code = t1.os) LEFT JOIN    
  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.os FROM visit_stats AS vs 
    WHERE   
    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1 AND vs.lp_flag = 1
    GROUP BY vs.os 
   ) AS t2 ON o.os_code = t2.os  
    WHERE stat != 'null' OR stat_vs != 'null' 
 GROUP BY o.os_code ORDER BY ##order## , o.os_name ASC)