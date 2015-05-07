<div class="page-header">
    <h1>Create new project</h1>
</div>
<?= $alerts; ?>
<form id="formProject" action="" method="post">
    <div class="form-group">
        <label for="inputTitle">Project title</label>
        <input type="text" name="Project[title]" class="form-control" id="inputTitle" placeholder="Enter title" value="<?= f('helpers:arr:get', 'title', $_POST['Project']); ?>">
    </div>
    <div class="form-group">
        <label for="textDescription">Project description</label>
        <textarea name="Project[description]" class="form-control" id="textDescription" rows="8" placeholder="Enter description"><?= f('helpers:arr:get', 'description', $_POST['Project']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="inputTags">Tags</label>
        <input type="text" name="Project[tags]" class="form-control" id="inputTags" placeholder="Enter tags" value="<?= f('helpers:arr:get', 'tags', $_POST['Project']); ?>">
    </div>
    <div class="form-group">
        <label for="inputCost">Cost</label>
        <div class="input-group">
            <input type="number" min="1" name="Project[cost]" class="form-control" id="inputCost" placeholder="Amount" value="<?= f('helpers:arr:get', 'cost', $_POST['Project']); ?>">
            <div class="input-group-addon">.00 руб.</div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
