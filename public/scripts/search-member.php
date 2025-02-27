<?php
require __DIR__ . '/../../config/database.php';

session_start();
$familyId = $_SESSION['family_id']; // Assuming family_id is stored in session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? '';

    if (empty($search)) {
        echo json_encode(['success' => false, 'message' => 'Search query is empty.']);
        exit();
    }
    try {
        $stmt = $pdo->prepare("SELECT * FROM children WHERE family_id = :family_id AND name LIKE :search");
        $stmt->execute([
            ':family_id' => $familyId,
            ':search' => '%' . $search . '%'
        ]);
        $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($children)) {
            echo json_encode(['success' => false, 'message' => 'No family members found.']);
        } else {
            
            $result = '<table class="table table-striped">';
            $result .= '<thead><tr><th>Photo</th><th>Name</th><th>Birth Date</th><th>Gender</th><th>Blood Type</th><th>Status</th><th>Actions</th></tr></thead>';
            $result .= '<tbody>';
            foreach ($children as $child) {
                $result .= '<tr>';
                $result .= '<td><img src="../pages/' . htmlspecialchars($child['photo']) . '" alt="Profile Photo" class="img-thumbnail" width="50"></td>';
                $result .= '<td>' . htmlspecialchars($child['name']) . '</td>';
                $result .= '<td>' . htmlspecialchars($child['birth_date']) . '</td>';
                $result .= '<td>' . htmlspecialchars($child['gender']) . '</td>';
                $result .= '<td>' . htmlspecialchars($child['blood_type']) . '</td>';
                $result .= '<td>' . ($child['status'] == 1 ? 'Alive' : 'Dead') . '</td>';
                $result .= '<td><a href="child_details.php?id=' . $child['id'] . '" class="badge badge-info">View</a> ';
                $result .= '<a href="edit_child.php?id=' . $child['id'] . '" class="badge badge-warning">Edit</a> ';
                $result .= '<a href="delete_child.php?id=' . $child['id'] . '" class="badge badge-danger">Delete</a></td>';
                $result .= '</tr>';
            }
            $result .= '</tbody></table>';

            echo json_encode(['success' => true, 'message' => $result]);
        }
    } catch (PDOException $e) {
        error_log("Database error: ");
    }
}
