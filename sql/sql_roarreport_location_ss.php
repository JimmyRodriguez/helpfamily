(
SELECT c.name AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, c.code AS code FROM 
                                                 (stats_country_iso_codes AS c LEFT JOIN  
                                                 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.country FROM user_table AS ut 
                                                    WHERE  ut.valid IN (0,1,2) 
                                                    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                    GROUP BY ut.country 
                                                  ) AS t1 ON c.code = t1.country) RIGHT JOIN     
                                                  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.country FROM visit_stats AS vs 
                                                    WHERE   
                                                    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                    GROUP BY vs.country 
                                                   ) AS t2 ON c.code = t2.country 
                                                    WHERE stat != 'null' OR stat_vs != 'null' 
                                                 GROUP BY c.code ORDER BY ##order## , c.name ASC
)
 
 UNION
 
(
SELECT c.name AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, c.code AS code FROM 
                                                 (stats_country_iso_codes AS c LEFT JOIN  
                                                 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.country FROM user_table AS ut 
                                                    WHERE  ut.valid IN (0,1,2) 
                                                    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                    GROUP BY ut.country 
                                                  ) AS t1 ON c.code = t1.country) LEFT JOIN     
                                                  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.country FROM visit_stats AS vs
                                                  WHERE   
                                                    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                    GROUP BY vs.country 
                                                   ) AS t2 ON c.code = t2.country 
                                                    WHERE stat != 'null' OR stat_vs != 'null' 
                                                 GROUP BY c.code ORDER BY ##order## , c.name ASC
)