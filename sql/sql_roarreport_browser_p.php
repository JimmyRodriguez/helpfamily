SELECT * FROM (

SELECT b.browser_name AS name , IFNULL(COUNT( ut.userid ),0) AS stat,FORMAT(IFNULL(COUNT( ut.userid ),0),0) AS stat_f, b.browser_code AS code
FROM stats_browser AS b, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND b.browser_code = ut.browser
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.browser ORDER BY COUNT( ut.userid ) DESC , b.browser_name ASC ) AS t1 RIGHT JOIN

(

SELECT  b.browser_name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, b.browser_code AS code
FROM stats_browser AS b, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND b.browser_code = vs.browser
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.browser ORDER BY COUNT( vs.visitid ) DESC , b.browser_name ASC ) AS t2 ON t2.code=t1.code

UNION

SELECT * FROM (

SELECT b.browser_name AS name , IFNULL(COUNT( ut.userid ),0) AS stat,FORMAT(IFNULL(COUNT( ut.userid ),0),0) AS stat_f, b.browser_code AS code
FROM stats_browser AS b, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND b.browser_code = ut.browser
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.browser ORDER BY COUNT( ut.userid ) DESC , b.browser_name ASC ) AS t1 LEFT JOIN

(

SELECT  b.browser_name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, b.browser_code AS code
FROM stats_browser AS b, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND b.browser_code = vs.browser
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.browser ORDER BY COUNT( vs.visitid ) DESC , b.browser_name ASC ) AS t2 ON t2.code=t1.code

