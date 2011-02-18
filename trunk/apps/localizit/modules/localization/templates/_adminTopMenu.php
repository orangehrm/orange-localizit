<table>
    <tr>
        <td>&nbsp;</td>        
        <td colspan="2">
           Logged in as <?php echo '&lsquo;'.$sf_user->getAttribute('username').'&rsquo;' ?>
        </td>
        <td class="logout">
            <?php
            echo link_to('Logout', 'authentication/logout');
            ?>

        </td>
    </tr>
</table>
