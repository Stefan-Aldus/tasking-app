{extends file="base.tpl"}
{block name="pageTitle"}Login{/block}
{block name="content"}
    <h2>{$task->getTaskName()}</h2>
    <div class="d-flex flex-column border-bottom border-2 border-striped">
        <h3>Description:</h3>
        <p>{$task->getTaskDescription()}</p>
    </div>
    <div class="d-flex flex-column border-bottom border-2 border-striped">
        <h3>Date: </h3>
        <p class="text-faded">{$task->getTaskDate()}</p>
    </div>
    <div class="d-flex flex-column border-bottom border-2 border-striped">
        <h3>Status: </h3>
        <div>
            <form action="/index.php?action=description" method="post">
                <input type="hidden" name="id" value="{$task->getTaskId()}">
                {if $task->getTaskStatus()=="Completed"}
                    <div class="d-flex justify-content-start align-items-center gap-4">
                        <p class="text-success h-auto align-items-center">Completed</p>
                        <input type="submit" value="Unfinish" class="btn btn-primary h-auto" name="descriptionfinish">
                    </div>
                {else}
                    <div class="d-flex justify-content-start align-items-center gap-4">
                        <p class="text-danger h-auto align-items-center">Not completed</p>
                        <input type="submit" value="Finish" class="btn btn-primary h-auto" name="descriptionfinish">
                    </div>
                {/if}
        </div>
    </div>
{/block}