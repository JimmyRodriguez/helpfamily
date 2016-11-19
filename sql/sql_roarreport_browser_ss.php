(
SELECT b.browser_name AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, b.browser_code AS code FROM 
                                                 (stats_browser AS b LEFT JOIN  
                                                 ( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.browser FROM user_table AS ut 
                                                    WHERE  ut.valid IN (0,1,2) 
                                                    AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
                                                    GROUP BY ut.browser 
                                                  ) AS t1 ON b.browser_code = t1.browser) RIGHT JOIN     
                                                  (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.browser FROM visit_stats AS vs 
                                                    WHERE   
                                                    vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
                                                    GROUP BY vs.browser 
                                                   ) AS t2 ON b.browser_code = t2.browser  
                                                    WHERE stat != 'null' OR stat_vs != 'null' 
                                                 GROUP BY b.browser_code ORDER BY ##order## , b.browser_name ASC
)
 
 UNION
 
(
SELECT b.browser_name AS name, IFNULL(stat,0) AS stat, IFNULL(stat_vs,0) AS stat_vs, FORMAT(IFNULL(stat,0),0) AS stat_f, FORMAT(IFNULL(stat_vs,0),0) AS stat_vs_f, b.browser_code AS code
FROM 
(stats_browser AS b LEFT JOIN  
( SELECT IFNULL(COUNT(ut.userid) ,0) AS stat,  ut.browser FROM user_table AS ut 
   WHERE  ut.valid IN (0,1,2) 
   AND ut.date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY) ##narrow_user## 
   GROUP BY ut.browser 
 ) AS t1 ON b.browser_code = t1.browser) LEFT JOIN     
 (SELECT IFNULL(COUNT(vs.visitid) ,0) AS stat_vs, vs.browser FROM visit_stats AS vs 
   WHERE   
   vs.date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)  ##narrow_visit##  AND vs.lp_flag = 1
   GROUP BY vs.browser 
  ) AS t2 ON b.browser_code = t2.browser  
   WHERE stat != 'null' OR stat_vs != 'null' 
GROUP BY b.browser_code ORDER BY ##order## , b.browser_name ASC
)