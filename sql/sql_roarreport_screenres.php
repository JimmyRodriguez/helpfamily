SELECT * FROM (

SELECT ut.screenres AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, ut.screenres AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )
AND bt.userid='##userid##'


##narrow_user##

GROUP BY ut.screenres ORDER BY COUNT( ut.userid ) DESC , ut.screenres ASC ) AS t1 RIGHT JOIN

(

SELECT vs.screenres AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, vs.screenres AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'



AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )
AND bt.userid='##userid##'


##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.screenres ORDER BY COUNT( vs.visitid ) DESC , vs.screenres ASC ) AS t2 ON t2.code=t1.code

UNION

SELECT * FROM (

SELECT ut.screenres AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, ut.screenres AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )
AND bt.userid='##userid##'


##narrow_user##

GROUP BY ut.screenres ORDER BY COUNT( ut.userid ) DESC , ut.screenres ASC ) AS t1 LEFT JOIN

(

SELECT vs.screenres AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, vs.screenres AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'



AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )
AND  bt.userid='##userid##'


##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.screenres ORDER BY COUNT( vs.visitid ) DESC , vs.screenres ASC ) AS t2 ON t2.code=t1.code

