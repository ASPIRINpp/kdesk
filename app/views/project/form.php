<div class="page-header">
    <h1>Create new project</h1>
</div>
<?= $alerts; ?>
<form id="formProject" action="" method="post">
    <div class="form-group">
        <label for="inputTitle">Project title</label>
        <input type="text" name="Project[title]" class="form-control" id="inputTitle" placeholder="Enter title">
    </div>
    <div class="form-group">
        <label for="textDescription">Project description</label>
        <textarea name="Project[description]" class="form-control" id="textDescription" rows="8" placeholder="Enter description"></textarea>
    </div>
    <div class="form-group">
        <label for="inputTags">Tags</label>
        <input type="text" name="Project[tags]" class="form-control" id="inputTags" placeholder="Enter tags">
    </div>
    <div class="form-group">
        <label for="inputCost">Cost</label>
        <div class="input-group">
            <input type="number" min="1" name="Project[cost]" class="form-control" id="inputCost" placeholder="Amount">
            <div class="input-group-addon">.00 руб.</div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
