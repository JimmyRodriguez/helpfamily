
SELECT COUNT(*) AS pagecount FROM (
(SELECT vs.visitors, ut.users, vs.landingpage FROM 
    (SELECT COUNT(landingpage) AS visitors, landingpage
    
    FROM visit_stats
    
    WHERE lp_flag = 1
    
    AND date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)
    
    ##search_vs##
    
    GROUP BY landingpage
    
   
    
    ) AS vs RIGHT JOIN
    
    (SELECT COUNT(userid) AS users, landingpage
    
    FROM user_table
    
    WHERE valid IN (0,1,2)
    
    AND date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY)
    
    ##search_ut##
    
    GROUP BY landingpage
    ) AS ut ON ut.landingpage = vs.landingpage
    
    
)

UNION


(
    SELECT vs.visitors, ut.users, vs.landingpage FROM
        (SELECT COUNT(landingpage) AS visitors, landingpage
        
        FROM visit_stats
        
        WHERE lp_flag = 1
        
        AND date_visited > DATE_SUB(NOW(),INTERVAL ##days## DAY)
        
        ##search_vs##
        
        GROUP BY landingpage
        ) AS vs LEFT JOIN
        
        (SELECT COUNT(userid) AS users, landingpage
        
        FROM user_table
        
        WHERE valid IN (0,1,2)
        
        AND date_joined > DATE_SUB(NOW(),INTERVAL ##days## DAY)
        
        ##search_ut##
        
        GROUP BY landingpage
        ) AS ut ON ut.landingpage = vs.landingpage
    
   
)


) AS c