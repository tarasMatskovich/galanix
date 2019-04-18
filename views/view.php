<?php require_once dirname(__FILE__) . "/layouts/header.php"; ?>
    <div class="container">
        <h1 class="mb-3">Result</h1>

        <div class="filters border mb-3 rounded-lg p-3">
            <form class="form" method="GET">
                <div class="row">
                    <div class="col">
                        <p class="mb-2">Filters</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $_GET['name']?>">
                    </div>
                    <div class="col-4">
                        <input type="text" name="age" placeholder="Age" class="form-control" value="<?php echo $_GET['age']?>">
                    </div>
                    <div class="col-4">
                        <input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo $_GET['email']?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="text" name="phone" placeholder="Phone" class="form-control" value="<?php echo $_GET['phone']?>">
                    </div>
                    <div class="col-4">
                        <select name="gender" class="form-control">
                            <option value="">Not selected</option>
                            <option value="male" <?php if($_GET['gender'] === 'male') echo 'selected';?>>Male</option>
                            <option value="female" <?php if($_GET['gender'] === 'female') echo 'selected';?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Apply</button>
                        <a href="/view" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="users">
            <?php if (!empty($users)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">UID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user):?>
                            <tr>
                                <td>
                                    <?php echo $user->id;?>
                                </td>
                                <td>
                                    <?php echo $user->name;?>
                                </td>
                                <td>
                                    <?php echo $user->age;?>
                                </td>
                                <td>
                                    <?php echo $user->email;?>
                                </td>
                                <td>
                                    <?php echo $user->phone;?>
                                </td>
                                <td>
                                    <?php echo $user->gender;?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Database does not have any record</p>
            <?php endif; ?>
        </div>

        <div class="buttons mt-3">
            <a href="#" class="btn btn-success">Export to CSV</a>
        </div>
    </div>

<?php require_once dirname(__FILE__) . "/layouts/footer.php"; ?>