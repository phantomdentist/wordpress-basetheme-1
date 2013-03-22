<div id="login">
    <form name="loginform" id="loginform" action="/wp-login.php" method="post">
        <ul class="float-left">
            <li><label>Username:</label><input type="text" name="log" id="log" value="" size="20" tabindex="1" /></li>
            <li><label>Password:</label><input type="password" name="pwd" id="pwd" value="" size="20" tabindex="2" /></li>
        </ul>
            
        <input type="submit" name="submit" id="submit" value="Login" tabindex="3" />
        <input type="hidden" name="redirect_to" value="<?php echo curPageURL(); ?>" />
    </form>
</div>