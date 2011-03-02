<table>
  <tbody>
    <tr>
      <th>User:</th>
      <td><?php echo $user->getUserId() ?></td>
    </tr>
    <tr>
      <th>Login name:</th>
      <td><?php echo $user->getLoginName() ?></td>
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

<a href="<?php echo url_for('userManagement/edit?user_id='.$user->getUserId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('userManagement/index') ?>">List</a>
