(
SELECT t1.refid AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t1.refid AS code FROM
                                             
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.refid FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.refid 
                                              ) AS t2  RIGHT JOIN 
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.refid FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                GROUP BY ut.refid 
                                               ) AS t1 ON LOWER(t2.refid) = LOWER(t1.refid)  
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t1.refid ORDER BY ##order## , t1.refid ASC
)
 
 UNION
 
(
SELECT t2.refid AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, t2.refid AS code FROM 
                                           
                                             (  SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.refid FROM visit_stats AS vs 
                                                WHERE   
                                                vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                GROUP BY vs.refid 
                                              ) AS t2  LEFT JOIN    
                                              (SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.refid FROM user_table AS ut 
                                                WHERE  ut.valid IN (0,1,2) 
                                                AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                GROUP BY ut.refid 
                                               ) AS t1 ON LOWER(t2.refid) = LOWER(t1.refid) 
                                                WHERE stat != 'null' OR stat_vs != 'null' 
                                             GROUP BY t2.refid ORDER BY ##order## , t2.refid ASC
)