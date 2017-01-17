<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="bg-primary">
                        <th>#</th>
                        <th>User id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>User Name</th>
			<th>Post Code</th>
			<th>Country</th>
			<th>State</th>
			<th>City</th>
			<th>Post Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($userrecord); $i++) { ?>
                    <tr>
                        <td><?php echo ($i+1); ?></td>
                        <td><?php echo $userrecord[$i]->id; ?></td>
                        <td><?php echo $userrecord[$i]->first_name; ?></td>
                        <td><?php echo $userrecord[$i]->last_name; ?></td>
                        <td><?php echo $userrecord[$i]->email; ?></td>
			<td><?php echo $userrecord[$i]->username; ?></td>
			<td><?php echo $userrecord[$i]->role_id; ?></td>
                        <td><?php echo $userrecord[$i]->country; ?></td>
                        <td><?php echo $userrecord[$i]->state; ?></td>
                        <td><?php echo $userrecord[$i]->city; ?></td>
			<td><?php echo $userrecord[$i]->postcode; ?></td>
                        <td><a href="<?php echo base_url() . "/user/delete/" . $userrecord[$i]->id; ?>">Delete</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
