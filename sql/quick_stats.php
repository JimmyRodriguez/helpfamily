SELECT *


FROM  (

SELECT IFNULL( COUNT( browser ) , 0 ) AS browser_count_v, sb.browser_name AS browser_name_v
FROM visit_stats AS vs, stats_browser AS sb
WHERE vs.browser = sb.browser_code
AND vs.lp_flag=1
GROUP BY sb.browser_code
ORDER BY COUNT( browser ) DESC
LIMIT 1
) AS bv,



(
SELECT IFNULL(COUNT(userid),0) AS os_count_v, so.os_name AS os_name_v FROM visit_stats AS vs, stats_os AS so 
   WHERE vs.os = so.os_code AND vs.lp_flag=1 GROUP BY so.os_code ORDER BY COUNT(userid) DESC LIMIT 1
) AS ov,


(
SELECT IFNULL(COUNT(userid),0) AS country_count_v, lower(sc.name) AS country_name_v FROM visit_stats AS vs, stats_country_iso_codes AS sc 
WHERE vs.country = sc.code AND vs.lp_flag=1 GROUP BY country ORDER BY COUNT(userid) DESC LIMIT 1
) AS cv,



(SELECT IFNULL(COUNT(userid),0) AS lang_count_v, sl.language AS lang_name_v FROM visit_stats AS vs, stats_lang AS sl 
WHERE  sl.lang_code =  vs.lang AND vs.lp_flag=1 GROUP BY lang ORDER BY COUNT(userid) DESC LIMIT 1
) AS lv