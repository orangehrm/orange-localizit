<h1>Users List</h1>

<table>
  <thead>
    <tr>
      <th>User</th>
      <th>Login name</th>
      <th>Password</th>
      <th>User type</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
      <td><a href="<?php echo url_for('authentication/show?user_id='.$user->getUserId()) ?>"><?php echo $user->getUserId() ?></a></td>
      <td><?php echo $user->getLoginName() ?></td>
      <td><?php echo $user->getPassword() ?></td>
      <td><?php echo $user->getUserTypeId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('authentication/new') ?>">New</a>
