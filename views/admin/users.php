<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <script>
        function openEditModal(id, name, email, role, status) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_name').innerText = name;
            document.getElementById('edit_email').innerText = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_status').value = status;
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</head>

<body>
    <nav class="navbar" style="background-color: #34495e;">
        <div class="container">
            <a href="<?= APP_URL ?>/admin/dashboard" class="brand">KavaChaiHut Admin</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/admin/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/admin/users">Users</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>User Management</h1>

        <table
            style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
            <thead>
                <tr style="background: #ecf0f1; text-align: left;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Role</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;">#<?= $user['id'] ?></td>
                        <td style="padding: 12px;"><?= htmlspecialchars($user['name']) ?></td>
                        <td style="padding: 12px;"><?= htmlspecialchars($user['email']) ?></td>
                        <td style="padding: 12px;"><?= ucfirst($user['role']) ?></td>
                        <td style="padding: 12px;"><?= ucfirst($user['status']) ?></td>
                        <td style="padding: 12px;">
                            <button
                                onclick="openEditModal('<?= $user['id'] ?>', '<?= htmlspecialchars($user['name']) ?>', '<?= htmlspecialchars($user['email']) ?>', '<?= $user['role'] ?>', '<?= $user['status'] ?>')"
                                class="btn"
                                style="background: #3498db; color: white; padding: 5px 10px; font-size: 0.9rem;">Edit</button>

                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <form action="<?= APP_URL ?>/admin/user/delete" method="POST" style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn"
                                        style="background: #c0392b; color: white; padding: 5px 10px; font-size: 0.9rem;">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
        <div style="background: white; width: 400px; margin: 100px auto; padding: 20px; border-radius: 8px;">
            <h2>Edit User</h2>
            <p><strong>Name:</strong> <span id="edit_name"></span></p>
            <p><strong>Email:</strong> <span id="edit_email"></span></p>

            <form action="<?= APP_URL ?>/admin/user/update" method="POST">
                <input type="hidden" name="user_id" id="edit_user_id">

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="edit_role" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="manager">Restaurant Manager</option>
                        <option value="delivery_partner">Delivery Partner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeEditModal()" class="btn"
                        style="background: #95a5a6; color: white;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #34495e;">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>