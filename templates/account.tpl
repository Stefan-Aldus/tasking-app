{extends file="base.tpl"}
{block name="pageTitle"}Account{/block}
{block name="content"}
    <h1>{$user->getUsername()}</h1>
    <div>
        {if !empty($User->$query)}
            <div class="alert alert-success" role="alert">
                {$User->$query}
            </div>
        {/if}
        <form method="post" action="/index.php?action=editaccount">
            <h2>Your user data:</h2>
            <div class="d-flex justify-content-between w-25">
                <p>First Name: {$user->getFirstname()}</p>
            </div>
            <div class="d-flex justify-content-between w-25">
                <p>Last Name: {$user->getLastName()}</p>
            </div>
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex justify-content-between w-25">
                    <p>Username: {$user->getUsername()}</p>
                    <button class="border-0 bg-white" type="submit" name="editusername"><i
                                class="fa fa-pen-square fa-2x"></i></button>
                </div>

                <div class="d-flex justify-content-between w-25">
                    <p>Password: [.....]</p>
                    <button class="border-0 bg-white" type="submit" name="editpassword"><i
                                class="fa fa-pen-square fa-2x"></i></button>
                </div>
            </div>
        </form>
    </div>
{/block}