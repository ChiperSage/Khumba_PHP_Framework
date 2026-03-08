<h2>User Profile</h2>
<?php if ($user): ?>
    <p><strong>ID:</strong> <?= SecurityHelper::e($user['id']) ?></p>
    <p><strong>Name:</strong> <?= SecurityHelper::e($user['name'] ?? '-') ?></p>
    <p><strong>Email:</strong> <?= SecurityHelper::e($user['email'] ?? '-') ?></p>
<?php endif; ?>
