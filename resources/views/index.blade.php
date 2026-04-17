<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Management</title>
    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
    <style>
        .container { margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        .table-responsive { margin-top: 20px; }
        .action-buttons { white-space: nowrap; }
        .modal-header { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Management System</h1>
        <hr>

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#employees" aria-controls="employees" role="tab" data-toggle="tab">Employees</a></li>
            <li role="presentation"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Employees Tab -->
            <div role="tabpanel" class="tab-pane active" id="employees">
                <div style="margin-top: 20px;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#employeeModal" onclick="resetForm()">
                        <span class="glyphicon glyphicon-plus"></span> Add New Employee
                    </button>
                </div>
                <div class="table-responsive" style="margin-top: 15px;">
                    <table id="employeesTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kota</th>
                                <th>Pekerjaan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Tab -->
            <div role="tabpanel" class="tab-pane" id="summary">
                <div style="margin-top: 20px;">
                    <div class="table-responsive">
                        <table id="summaryTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="employeeModalLabel">Add Employee</h4>
                </div>
                <div class="modal-body">
                    <form id="employeeForm">
                        <input type="hidden" id="employeeId" value="">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="kota">Kota:</label>
                            <input type="text" class="form-control" id="kota" placeholder="Enter city" required>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan:</label>
                            <select class="form-control" id="pekerjaan" required>
                                <option value="">-- Select Job --</option>
                                <option value="Programmer">Programmer</option>
                                <option value="System Analyst">System Analyst</option>
                                <option value="UI/UX Designer">UI/UX Designer</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEmployee()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap 3 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>

    <script>
        const API_URL = '/api/employees';

        // Initialize DataTable for employees
        let employeesDataTable = $('#employeesTable').DataTable({
            serverSide: false,
            paging: true,
            searching: true,
            ordering: true,
            columnDefs: [
                { targets: 4, orderable: false }
            ]
        });

        // Initialize DataTable for summary
        let summaryDataTable = $('#summaryTable').DataTable({
            serverSide: false,
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });

        // Load employees on page load
        $(document).ready(function() {
            loadEmployees();
            loadSummary();
            
            // Reload summary when switching to summary tab
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                if ($(e.target).attr('href') === '#summary') {
                    loadSummary();
                }
            });
        });

        // Load all employees
        function loadEmployees() {
            $.ajax({
                url: API_URL,
                method: 'GET',
                success: function(data) {
                    employeesDataTable.clear();
                    $.each(data, function(index, employee) {
                        employeesDataTable.row.add([
                            employee.id,
                            employee.nama,
                            employee.kota,
                            employee.pekerjaan,
                            `<div class="action-buttons">
                                <button class="btn btn-sm btn-warning" onclick="editEmployee(${employee.id})">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${employee.id})">
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </button>
                            </div>`
                        ]);
                    });
                    employeesDataTable.draw();
                },
                error: function() {
                    alert('Error loading employees');
                }
            });
        }

        // Load summary
        function loadSummary() {
            $.ajax({
                url: API_URL + '/summary',
                method: 'GET',
                success: function(data) {
                    summaryDataTable.clear();
                    $.each(data, function(index, item) {
                        summaryDataTable.row.add([
                            item.label,
                            item.jumlah
                        ]);
                    });
                    summaryDataTable.draw();
                },
                error: function() {
                    alert('Error loading summary');
                }
            });
        }

        // Reset form
        function resetForm() {
            $('#employeeForm')[0].reset();
            $('#employeeId').val('');
            $('#employeeModalLabel').text('Add Employee');
        }

        // Save employee (create or update)
        function saveEmployee() {
            const employeeId = $('#employeeId').val();
            const data = {
                nama: $('#nama').val(),
                kota: $('#kota').val(),
                pekerjaan: $('#pekerjaan').val()
            };

            if (!data.nama || !data.kota || !data.pekerjaan) {
                alert('Please fill all fields');
                return;
            }

            const url = employeeId ? `${API_URL}/${employeeId}` : API_URL;
            const method = employeeId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function() {
                    $('#employeeModal').modal('hide');
                    loadEmployees();
                    alert(employeeId ? 'Employee updated successfully' : 'Employee created successfully');
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }

        // Edit employee
        function editEmployee(id) {
            $.ajax({
                url: `${API_URL}/${id}`,
                method: 'GET',
                success: function(employee) {
                    $('#employeeId').val(employee.id);
                    $('#nama').val(employee.nama);
                    $('#kota').val(employee.kota);
                    $('#pekerjaan').val(employee.pekerjaan);
                    $('#employeeModalLabel').text('Edit Employee');
                    $('#employeeModal').modal('show');
                },
                error: function() {
                    alert('Error loading employee');
                }
            });
        }

        // Delete employee
        function deleteEmployee(id) {
            if (confirm('Are you sure you want to delete this employee?')) {
                $.ajax({
                    url: `${API_URL}/${id}`,
                    method: 'DELETE',
                    success: function() {
                        loadEmployees();
                        alert('Employee deleted successfully');
                    },
                    error: function() {
                        alert('Error deleting employee');
                    }
                });
            }
        }
    </script>
</body>
</html>
