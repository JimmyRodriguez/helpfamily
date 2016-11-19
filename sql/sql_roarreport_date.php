SELECT * FROM (

SELECT DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') ORDER BY COUNT( ut.userid ) DESC , DATE_FORMAT(ut.date_joined,'%d/%m/%Y')ASC ) AS t1 RIGHT JOIN

(

SELECT DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'



AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y')  ORDER BY COUNT( vs.visitid ) DESC , DATE_FORMAT(vs.date_visited,'%d/%m/%Y')  ASC ) AS t2 ON t2.code=t1.code


UNION

SELECT * FROM (

SELECT DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS code
FROM  user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND  bt.userid='##userid##'


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') ORDER BY COUNT( ut.userid ) DESC , DATE_FORMAT(ut.date_joined,'%d/%m/%Y')ASC ) AS t1 LEFT JOIN

(

SELECT DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS code
FROM  visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'



AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND  bt.userid='##userid##'


AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y')  ORDER BY COUNT( vs.visitid ) DESC , DATE_FORMAT(vs.date_visited,'%d/%m/%Y')  ASC ) AS t2 ON t2.code=t1.code
