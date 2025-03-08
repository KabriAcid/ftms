<?php
require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../helpers/helpers.php';

$query = isset($_GET['query']) ? $_GET['query'] : null;
$members = getMembers($pdo, 'Male', null, $query);

$defaultImage = '../uploads/user.png';

if ($members):
    foreach ($members as $member):
?>
        <div class="member-card">
            <?php if ($member['profile_picture']): ?>
                <img src="<?php echo htmlspecialchars($member['profile_picture']); ?>" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
            <?php else: ?>
                <img src="<?php echo file_exists($defaultImage) ? $defaultImage : 'uploads/user.png'; ?>" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;">
            <?php endif; ?>
            <div>
                <h5><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h5>
                <p>Birth Date: <?php echo htmlspecialchars($member['birth_date']); ?></p>
                <a href="member-details.php?id=<?php echo $member['id']; ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    <?php
    endforeach;
else:
    ?>
    <p>No members found.</p>
<?php endif; ?>