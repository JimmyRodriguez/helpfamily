SELECT * FROM (

SELECT o.os_name AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, o.os_code AS code
FROM stats_os AS o, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND o.os_code = ut.os
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.os ORDER BY COUNT( ut.userid ) DESC , o.os_name ASC ) AS t1 RIGHT JOIN

(

SELECT o.os_name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, o.os_code AS code
FROM stats_os AS o, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND o.os_code = vs.os
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.os ORDER BY COUNT( vs.visitid ) DESC , o.os_name ASC ) AS t2 ON t2.code=t1.code

UNION

SELECT * FROM (

SELECT o.os_name AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, o.os_code AS code
FROM stats_os AS o, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND o.os_code = ut.os
AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.os ORDER BY COUNT( ut.userid ) DESC , o.os_name ASC ) AS t1 LEFT JOIN

(

SELECT o.os_name AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, o.os_code AS code
FROM stats_os AS o, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND o.os_code = vs.os
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.os ORDER BY COUNT( vs.visitid ) DESC , o.os_name ASC ) AS t2 ON t2.code=t1.code

