<div class="page-header">
    <h1>Search project <small>open <?= $count_open ?> project</small></h1>
</div>

<form class="form-inline row searchForm" action="/project/search" method="get">
    <div class="form-group col-md-11 col-xs-10">
        <label class="sr-only" for="">Search query</label>
        <input type="text" name="q" class="form-control" id="inputSearchProjects" placeholder="Search query">
    </div>
    <button type="submit" class="btn btn-primary col-md-1 col-xs-2">Search</button>
</form>
<br>

<?php 
    if(!empty($rows)){
        foreach ($rows as $row) {
            echo f('core:view:print', 'elements/_project_thumb', $row, TRUE);
        }
    }
?>

