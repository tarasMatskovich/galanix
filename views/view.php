<?php require_once dirname(__FILE__) . "/layouts/header.php"; ?>
    <div class="container">
        <h1 class="mb-3">Result</h1>

        <div class="users">
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
        </div>
    </div>

<?php require_once dirname(__FILE__) . "/layouts/footer.php"; ?>