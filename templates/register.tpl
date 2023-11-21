{extends file="base.tpl"}
{block name="pageTitle"}Register{/block}
{block name="content"}
    <h1>Register</h1>
    <form class="w-50" method="post">
        <div class="form-group">
            <label class="required-input" for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" class="form-control"/>
            <label class="required-input" for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" class="form-control"/>
            <p class="form-text text-muted">We will never share your personal details with anyone.</p>
        </div>
        <div class="form-group">
            <label class="required-input" for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control"/>
        </div>
        <div class="form-group">
            <label class="required-input" for="password1">Password</label>
            <input type="text" id="password1" name="password1" class="form-control"/>
            <label class="required-input" for="password2">Repeat Password</label>
            <input type="text" id="password2" name="password2" class="form-control"/>
            <p class="form-text text-muted">Passwords must match and be at least 6 characters long.</p>
        </div>
        <div class="form-group d-flex mt-3 w-100">
            <input type="submit" value="Register" name="submit" class="btn btn-primary w-50 rounded-0"/>
            <input type="reset" value="Reset Form" class="btn btn-secondary w-50 rounded-0"/>
        </div>
    </form>
{/block}