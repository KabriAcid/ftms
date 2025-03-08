<?php
function getMembers($pdo, $gender = null, $status = null, $query = null)
{
    $sql = "SELECT * FROM members WHERE 1=1";

    if ($gender !== null) {
        $sql .= " AND gender = :gender";
    }

    if ($status !== null) {
        $sql .= " AND status = :status";
    }

    if ($query !== null) {
        $sql .= " AND (first_name LIKE :query OR last_name LIKE :query)";
        $query = '%' . $query . '%';
    }

    $stmt = $pdo->prepare($sql);

    if ($gender !== null) {
        $stmt->bindParam(':gender', $gender);
    }

    if ($status !== null) {
        $stmt->bindParam(':status', $status);
    }

    if ($query !== null) {
        $stmt->bindParam(':query', $query);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
