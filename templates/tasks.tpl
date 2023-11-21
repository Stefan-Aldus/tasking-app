{extends file="base.tpl"}
{block name="pageTitle"}Tasks{/block}
{block name="content"}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Tasks</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Due Date</th>
                            <th>Completed</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if !empty($tasks)}
                            {foreach $tasks as $task}
                                <form action="/index.php?action=description" method="POST">
                                    <input type="hidden" readonly name="id" value="{$task->getTaskId()}">
                                    <tr>
                                        <td>{$task->getTaskName()}</td>
                                        <td>{$task->getTaskDate()}</td>
                                        <td>{$task->getTaskStatus()}</td>
                                        <td><input class="btn btn-primary w-100" name="description" type="submit" value="See details"</td>
                                </form>
                                <td>
                                    {if $task->getTaskStatus() == 'Not completed'}
                                        <input type="submit" name="finish" value="Finish" class="btn btn-primary w-100">
                                    {else}
                                        <input type="submit" name="finish" value="Unfinish" class="btn btn-primary w-100">
                                    {/if}
                                </td>
                                </tr>
                                </form>
                            {/foreach}
                        {else}
                            <tr>
                                <td colspan="4">No tasks found</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{/block}