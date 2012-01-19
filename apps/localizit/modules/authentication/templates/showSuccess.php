<table>
  <tbody>
    <tr>
      <th>User:</th>
      <td><?php echo $user->getId() ?></td>
    </tr>
    <tr>
      <th>Login name:</th>
      <td><?php echo $user->getUsername() ?></td>
    </tr>
    <tr>
      <th>Password:</th>
      <td><?php echo $user->getPassword() ?></td>
    </tr>
    <tr>
      <th>User type:</th>
      <td><?php echo $user->getUserTypeId() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('authentication/edit?user_id='.$user->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('authentication/index') ?>">List</a>
