SELECT FORMAT(visitors,0)AS visitors, FORMAT(users,0) AS users,landingpage, FORMAT(conversion,1) AS conversion FROM (
SELECT IFNULL(visitors,0) AS visitors, IFNULL(users,0) AS users,
IFNULL(landingpage,'not-set') AS landingpage,
IFNULL((IFNULL(users,0)/IFNULL(visitors,0))*100,0) AS conversion FROM (

(SELECT vs.visitors, ut.users, ut.landingpage FROM 
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
) AS t
) AS s
ORDER BY ##order## 
LIMIT ##limit##