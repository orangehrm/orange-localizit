<div class="formHeading float-left">
    Orange-Localizit
</div>
<div class="float-right">
    <div class="top_menu">
        Welcome <font style="font-weight: bold"><?php echo $sf_user->getAttribute('username'); ?></font>
    </div>

    <div class="top_menu logout">
        <?php echo link_to('Logout', 'authentication/logout'); ?>
    </div>
</div>

<div class="clear"></div>
<table>
    <tr>
        <td>
            <ul class="sf-menu">
                <li class="current">
                    <a href="#">Users</a>
                    <ul>
                        <li>
                            <a href="#">Add</a>
                        </li>                        
                        <li>
                            <a href="#">Edit</a>
                        </li>
                        <li>
                            <a href="#">Delete</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Language Text</a>
                </li>
            </ul>
        </td>
    </tr>
</table>