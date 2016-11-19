SELECT * FROM (

SELECT l.language AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, l.lang_code AS code
FROM stats_lang AS l, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND l.lang_code = ut.lang
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.lang ORDER BY COUNT( ut.userid ) DESC , l.language ASC ) AS t1 RIGHT JOIN

(

SELECT l.language AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, l.lang_code AS code
FROM stats_lang AS l, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND l.lang_code = vs.lang
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.lang ORDER BY COUNT( vs.visitid ) DESC , l.lang_code ASC ) AS t2 ON t2.code=t1.code


UNION

SELECT * FROM (

SELECT l.language AS name, COUNT( ut.userid ) AS stat,FORMAT(COUNT( ut.userid ),0) AS stat_f, l.lang_code AS code
FROM stats_lang AS l, user_table AS ut, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'

AND ut.valid IN ( 0, 1 )
AND l.lang_code = ut.lang
AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND ut.date_joined > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )


AND (bt.domain = ut.refdomain OR bt.referalid = ut.refid )

##narrow_user##

GROUP BY ut.lang ORDER BY COUNT( ut.userid ) DESC , l.language ASC ) AS t1 LEFT JOIN

(

SELECT l.language AS name, COUNT( vs.visitid ) AS stat_vs, FORMAT(COUNT( vs.visitid ),0) AS stat_vs_f, l.lang_code AS code
FROM stats_lang AS l, visit_stats AS vs, blogroar_blogtable AS bt,blogroar_keygen AS bk, blogroar_shareblog AS sb

WHERE bt.blogid = '##id##'


AND l.lang_code = vs.lang
AND vs.date_visited > DATE_SUB( NOW( ) , INTERVAL ##days## DAY )

AND (bk.keygen='##pkey##' OR bt.userid='##userid##')
AND sb.keygen = bk.keygen AND bt.blogid = sb.regblogid AND sb.valid=1 AND bk.valid=1

AND (bt.domain = vs.refdomain OR bt.referalid = vs.refid )

##narrow_visit##  AND vs.lp_flag = 1

GROUP BY vs.lang ORDER BY COUNT( vs.visitid ) DESC , l.lang_code ASC ) AS t2 ON t2.code=t1.code

