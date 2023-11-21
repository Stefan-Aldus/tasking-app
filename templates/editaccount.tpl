{extends file="base.tpl"}
{block name="pageTitle"}Edit Account{/block}
{block name="content"}
    {if $type == 'username'}
        <p>Current username: {$user->getUsername()}</p>
        <form action="/index.php?action=updateAccount" method="post">
            <input type="hidden" name="type" value="username">
            <input type="text" name="username" placeholder="New username">
            <input type="submit" value="Update" class="btn btn-primary" name="updateUsername">
        </form>
    {elseif $type == 'password'}
        <form action="/index.php?action=updateAccount" method="post">
            <input type="password" name="currentpassword" placeholder="Current password">
            <input type="password" name="password1" placeholder="New password">
            <input type="password" name="password2" placeholder="Confirm new password">
            <input type="submit" value="Update" class="btn btn-primary" name="updatePassword">
        </form>
    {/if}
{/block}