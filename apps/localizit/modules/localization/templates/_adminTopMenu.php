<table>
    <tr>
        <td>
            <dl class="dropdown">
                <dt id="one-ddheader" onmouseover="ddMenu('one',1)" onmouseout="ddMenu('one',-1)">User</dt>
                <dd id="one-ddcontent" onmouseover="cancelHide('one')" onmouseout="ddMenu('one',-1)">
                    <ul>
                        <li><a href="#" class="underline">Add</a></li>
                        <li><a href="#" class="underline">Edit</a></li>
                        <li><a href="#">Delete</a></li>
                    </ul>
                </dd>
            </dl>
        </td>
        <td colspan="2">
            Logged in as <?php echo '&lsquo;' . $sf_user->getAttribute('username') . '&rsquo;' ?>
        </td>
        <td class="logout">
            <?php
            echo link_to('Logout', 'authentication/logout');
            ?>

        </td>
    </tr>
</table>
