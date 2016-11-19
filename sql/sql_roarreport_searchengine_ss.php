(
SELECT t1.searchengine AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t1.searchengine AS code FROM 
                                             
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.searchengine FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND vs.searchengine!='none'  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.searchengine 
                                              ) AS t2  RIGHT JOIN     
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.searchengine FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND ut.searchengine!='none' ##narrow_user## 
                                                GROUP BY ut.searchengine 
                                               ) AS t1 ON LOWER(t2.searchengine)= LOWER(t1.searchengine)  
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t1.searchengine ORDER BY ##order## , t1.searchengine ASC
)
 
 UNION
 
(
SELECT t2.searchengine AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t2.searchengine AS code FROM 
                                             
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.searchengine FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND vs.searchengine!='none'  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.searchengine 
                                              ) AS t2  LEFT JOIN    
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.searchengine FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND ut.searchengine!='none' ##narrow_user## 
                                                GROUP BY ut.searchengine 
                                               ) AS t1 ON LOWER(t2.searchengine)= LOWER(t1.searchengine) 
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t2.searchengine ORDER BY ##order## , t2.searchengine ASC
)