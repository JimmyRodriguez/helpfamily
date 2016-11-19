(
 SELECT l.language AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, l.lang_code AS code FROM 
                                                 (stats_lang AS l LEFT JOIN  
                                                 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.lang FROM user_table AS ut 
                                                    WHERE  ut.valid IN (0,1,2) 
                                                    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                    GROUP BY ut.lang 
                                                  ) AS t1 ON l.lang_code = t1.lang) RIGHT JOIN  
                                                  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.lang FROM visit_stats AS vs 
                                                    WHERE   
                                                    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                    GROUP BY vs.lang 
                                                   ) AS t2 ON l.lang_code = t2.lang  
                                                    WHERE stat != 'null' OR stat_vs != 'null' 
                                                 GROUP BY l.lang_code ORDER BY ##order## , l.language ASC
)
 
 UNION
 
(
 SELECT l.language AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, l.lang_code AS code FROM 
                                                 (stats_lang AS l LEFT JOIN  
                                                 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.lang FROM user_table AS ut 
                                                    WHERE  ut.valid IN (0,1,2) 
                                                    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                    GROUP BY ut.lang 
                                                  ) AS t1 ON l.lang_code = t1.lang) LEFT JOIN     
                                                  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.lang FROM visit_stats AS vs 
                                                    WHERE   
                                                    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                    GROUP BY vs.lang 
                                                   ) AS t2 ON l.lang_code = t2.lang  
                                                    WHERE stat != 'null' OR stat_vs != 'null' 
                                                 GROUP BY l.lang_code ORDER BY ##order## , l.language ASC
)