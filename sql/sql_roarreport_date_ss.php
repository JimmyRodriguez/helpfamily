(
SELECT t1.date_joined AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t1.date_joined AS code FROM 
                                             
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS date_visited FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y') 
                                              ) AS t2  RIGHT JOIN 
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS date_joined FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') 
                                               ) AS t1 ON t2.date_visited= t1.date_joined
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t1.date_joined ORDER BY ##order## , t1.date_joined ASC
)
 
 UNION
 
(
SELECT t2.date_visited AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t2.date_visited AS code FROM 
                                             
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS date_visited FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y') 
                                              ) AS t2  LEFT JOIN     
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS date_joined FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') 
                                               ) AS t1 ON t2.date_visited= t1.date_joined
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t2.date_visited ORDER BY ##order## , t2.date_visited ASC
)