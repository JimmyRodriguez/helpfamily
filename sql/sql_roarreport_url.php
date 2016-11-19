SELECT * FROM (

SELECT ut.refurl AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, ut.refurl AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND  bt.userid='##userid##'


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.refurl ORDER BY COUNT( ut.userid ) DESC , ut.refurl ASC ) AS t1 RIGHT JOIN

(

SELECT vs.refurl AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, vs.refurl AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.refurl ORDER BY COUNT( vs.visitid ) DESC , vs.refurl ASC ) AS t2 ON t2.code=t1.code

UNION

SELECT * FROM (

SELECT ut.refurl AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, ut.refurl AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.refurl ORDER BY COUNT( ut.userid ) DESC , ut.refurl ASC ) AS t1 LEFT JOIN

(

SELECT vs.refurl AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, vs.refurl AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.refurl ORDER BY COUNT( vs.visitid ) DESC , vs.refurl ASC ) AS t2 ON t2.code=t1.code

