<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Data</title>


    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet">
     
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
     
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
 
     
</head>
<body>

    <h1>List of Records</h1>
    
    
    <a href = "<?= base_url() ?>/Crud/savedata">add data </a>

    <?php if (!empty($records) && is_array($records)): ?>
        <table border="1" id="example" class="col-md-8">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= esc($record['id']) ?></td>
                        <td><?= esc($record['name']) ?></td>
                        <td><?= esc($record['email']) ?></td>
                        <td><?= esc($record['city']) ?></td>
                        <td>
                            <a href="<?= base_url('crud/edit/' . $record['id']) ?>">Edit</a>
                            <a href="<?= base_url('crud/delete/' . $record['id']) ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            <!-- You can add a delete link here if needed -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
 <script>
       $(document).ready(function() {
    $('#example').DataTable({
        'ajax': {
            'url': "<?= base_url() ?>/Crud/showdata",
            'type': 'GET',
            'dataSrc': 'aaData'  // This tells DataTables to look inside the 'aaData' for rows
        },
        'columns': [
            { 'data': 'id' },    // Maps to 'id' field in your JSON
            { 'data': 'name' },  // Maps to 'name' field
            { 'data': 'email' }, // Maps to 'email' field
            { 'data': 'city' },  // Maps to 'city' field
            {
                'data': 'id',   // Maps to 'id' for the edit/delete actions
                'render': function (data, type, row, meta) {
                    return '<a href="update-client.php?clid=' + data + '"><button class="btn btn-primary btn-xs">Edit</button></a>';
                }
            }
        ],
        'processing': true,
        'serverSide': false,   // Disable server-side processing for now
    });
});

    </script>
</body>
</html>
