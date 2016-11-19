SELECT * FROM (

SELECT c.name AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, c.code AS code
FROM stats_country_iso_codes AS c, user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND c.code = ut.country
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'



AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.country ORDER BY COUNT( ut.userid ) DESC , c.name ASC ) AS t1 RIGHT JOIN

(

SELECT c.name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, c.code AS code
FROM stats_country_iso_codes AS c, visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'


AND c.code = vs.country
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'



AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.country ORDER BY COUNT( vs.visitid ) DESC , c.name ASC ) AS t2 ON t2.code=t1.code

UNION

SELECT * FROM (

SELECT c.name AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, c.code AS code
FROM stats_country_iso_codes AS c, user_table AS ut, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND c.code = ut.country
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'



AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.country ORDER BY COUNT( ut.userid ) DESC , c.name ASC ) AS t1 LEFT JOIN

(

SELECT c.name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, c.code AS code
FROM stats_country_iso_codes AS c, visit_stats AS vs, blogroar_blogtable AS bt

WHERE bt.blogid = '##id##'


AND c.code = vs.country
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND bt.userid='##userid##'



AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.country ORDER BY COUNT( vs.visitid ) DESC , c.name ASC ) AS t2 ON t2.code=t1.code

