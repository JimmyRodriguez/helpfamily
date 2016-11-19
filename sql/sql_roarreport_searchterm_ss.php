(
SELECT t1.searchterm AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t1.searchterm AS code FROM 
                                      
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.searchterm FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND vs.searchterm!='---'  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.searchterm 
                                              ) AS t2  RIGHT JOIN    
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.searchterm FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND ut.searchterm!='---' ##narrow_user## 
                                                GROUP BY ut.searchterm 
                                               ) AS t1 ON LOWER(t2.searchterm)= LOWER(t1.searchterm) 
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t1.searchterm ORDER BY ##order## , t1.searchterm  ASC
)
 
 UNION
 
(
SELECT t2.searchterm AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t2.searchterm AS code FROM 
                                          
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.searchterm FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND vs.searchterm!='---'  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.searchterm 
                                              ) AS t2  LEFT JOIN 
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.searchterm FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) AND ut.searchterm!='---' ##narrow_user## 
                                                GROUP BY ut.searchterm 
                                               ) AS t1 ON LOWER(t2.searchterm)= LOWER(t1.searchterm) 
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t2.searchterm ORDER BY ##order## , t2.searchterm  ASC
)