<?php
// Family summary
function getFamilySummary($pdo, $family_id)
{
    // Initialize result array
    $result = [];

    // Query to get the family name and family code
    $stmt = $pdo->prepare('SELECT * FROM families WHERE id = :family_id');
    if ($stmt->execute(['family_id' => $family_id])) {
        $family = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($family) {
            $result = array_merge($result, $family);
        }
    }

    // Query to get the number of members in the family
    $stmt = $pdo->prepare('SELECT COUNT(*) AS member_count FROM members WHERE family_id = :family_id');
    if ($stmt->execute(['family_id' => $family_id])) {
        $member_count = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($member_count) {
            $result = array_merge($result, $member_count);
        }
    }

    return $result;
}


function getRecentActivities($pdo, $family_id)
{
    // Query to get the recent activities for the family
    $stmt = $pdo->prepare('SELECT *
FROM activities
WHERE family_id = :family_id
ORDER BY created_at DESC
LIMIT 5');
    $stmt->execute(['family_id' => $family_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUpcomingEvents($pdo, $family_id)
{
    // Query to get the upcoming events for the family
    $stmt = $pdo->prepare('SELECT *
                            FROM events
                            WHERE family_id = :family_id
                            AND event_date >= CURDATE()
                            ORDER BY event_date ASC
                            LIMIT 5');
    $stmt->execute(['family_id' => $family_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
