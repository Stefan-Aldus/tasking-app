{extends file="base.tpl"}
{block name="pageTitle"}Login{/block}
{block name="content"}
    <h1>Login</h1>
    <form class="w-50" method="post">
        <div class="form-group.required">
            <label class="required-input" for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control"/>
        </div>
        <div class="form-group">
            <label class="required-input" for="password">Password</label>
            <input type="text" id="password" name="password" class="form-control"/>
        </div>
        <div class="form-group d-flex mt-3 w-100">
            <input type="submit" value="Login" name="submit" class="btn btn-primary w-50 rounded-0"/>
            <input type="reset" value="Reset Form" class="btn btn-secondary w-50 rounded-0"/>
        </div>
    </form>
{/block}