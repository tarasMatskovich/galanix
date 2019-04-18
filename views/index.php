<?php require_once dirname(__FILE__) . "/layouts/header.php"; ?>
    <div class="container">
        <h1 class="mb-3">Please, import data from file:</h1>
        <form action="/import" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Your file: </label>
                <input type="file" class="form-control" id="file" name="file" placeholder="Import your file">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Import</button>
            </div>
        </form>
    </div>

<?php require_once dirname(__FILE__) . "/layouts/footer.php"; ?>