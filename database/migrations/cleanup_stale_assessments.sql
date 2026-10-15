-- =====================================================================
-- One-time cleanup script for stale 'in_progress' user_assessments.
--
-- Marks any in_progress assessment record as 'completed' if the user
-- already completed and submitted an assessment (i.e. has a row in
-- assessment_results taken on or after the assessment's creation/update).
-- =====================================================================

UPDATE user_assessments ua
JOIN (
    SELECT user_id, MAX(taken_at) AS latest_taken
    FROM assessment_results
    GROUP BY user_id
) ar ON ua.user_id = ar.user_id
SET ua.status = 'completed',
    ua.updated_at = NOW()
WHERE ua.status = 'in_progress'
  AND ua.created_at <= ar.latest_taken;
