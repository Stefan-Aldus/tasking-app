{extends file="base.tpl"}
{block name="pageTitle"}Add Task{/block}
{block name="header"}Add Task{/block}
{block name="content"}
    <form class="w-50" method="post">
        <div class="form-group">
            <label class="required-input" for="name">Task name</label>
            <input type="text" id="name" name="name" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="description">Task Description</label>
            <textarea id="description" name="description" class="form-control" rows="10"></textarea>
        </div>
        <div class="form-group">
            <label class="required-input" for="date">Date</label>
            <input type="text" id="date" name="date" class="form-control" placeholder="YYYY-MM-DD"/>
        </div>
        <div class="form-group d-flex mt-3 w-100">
            <input type="submit" value="Register" name="submit" class="btn btn-primary w-50 rounded-0"/>
            <input type="reset" value="Reset Form" class="btn btn-secondary w-50 rounded-0"/>
        </div>
    </form>
{/block}