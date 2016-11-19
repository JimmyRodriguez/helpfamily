SELECT *


FROM (

SELECT IFNULL(COUNT( browser ) , 0 ) AS browser_count, sb.browser_name
FROM user_table AS ut, stats_browser AS sb
WHERE ut.valid != '2'
AND ut.browser = sb.browser_code
GROUP BY sb.browser_code
ORDER BY COUNT( browser ) DESC
LIMIT 1
) AS bu,

(
SELECT IFNULL(COUNT(userid),0) AS os_count, so.os_name FROM user_table AS ut, stats_os AS so 
   WHERE valid!='2' AND ut.os = so.os_code GROUP BY so.os_code ORDER BY COUNT(userid) DESC LIMIT 1
) AS ou,

(
SELECT IFNULL(COUNT(userid),0) AS country_count, lower(sc.name) AS country_name FROM user_table AS ut, stats_country_iso_codes AS sc 
WHERE valid!='2' AND ut.country = sc.code GROUP BY country ORDER BY COUNT(userid) DESC LIMIT 1
) AS cu,

(SELECT IFNULL(COUNT(userid),0) AS lang_count, sl.language AS lang_name FROM user_table AS ut, stats_lang AS sl 
WHERE valid!='2' AND sl.lang_code = ut.lang GROUP BY lang ORDER BY COUNT(userid) DESC LIMIT 1
) AS lu