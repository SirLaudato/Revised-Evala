<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria List</title>
    <link rel="stylesheet" href="../admin-css/modal.css">
    <link rel="stylesheet" href="../admin-css/evaluation.css">
</head>

<body>

<div class="navigator">
    <?php include('../admin/index.php'); ?>
</div>

<div class="parent-evaluation-container">
    <div class="evaluation-add">
        <h2>Evaluation Analysis</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="criteria_name">Criteria Name:</label>
                 <label class="custum-file-upload" for="file">
                    <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                    </div>
                    <div class="text">
                    <span>Click to upload File</span>
                    </div>
                    <input type="file" id="file">
                </label>
            </div>
            <div class="form-group">
                <label for="criteria_name">Prompt:</label>
                <textarea type="textarea" id="" name="criteria_name" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="add_criteria">Analyze</button>
            </div>
        </form>
    </div>

    <div class="evaluation-list">
            <h2>Analyzation with Ai Feedback</h2>
            <form method="POST" action="">
            <div class="form-group">
                <label for="criteria_name">Results:</label>
                <textarea type="textarea" id="criteria_name" name="criteria_name" required></textarea>
            </div>
            </form>
            <div class="form-group">
                <button type="submit" name="add_criteria">Export to PDF</button>
            </div>
    </div>
</div>






    <!-- Edit Criteria Modal -->
    <div id="editModal" class="modal" style="display:none;">

        <span class="close">&times;</span>
        <div class="modal-content">
            
            <form id="editForm" method="POST">
                <input type="hidden" name="criteria_id" id="criteria_id">

                <label for="name">Criteria Name</label>
                <input type="text" id="name" name="criteria_name">
                

                <label for="evaluator_type">Evaluator Type</label>
                <select id="evaluator_type" name="evaluator_type">
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Alumni">Alumni</option>
                </select>
                

                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Locked</option>
                </select>
                

                <button type="submit">Save Changes</button>
            </form>
        </div>
        
    </div>

    <!-- JavaScript for handling modals and form submission -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const closeModal = document.querySelector('.close');
            const editButtons = document.querySelectorAll('.edit-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');

            // Open edit modal and populate fields
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Populate the modal with data
                    const status = button.dataset.status == 'Active' ? '1' : '0';  // Set '1' for Active and '0' for Locked
                    document.getElementById('criteria_id').value = button.dataset.id;
                    document.getElementById('name').value = button.dataset.name;
                    document.getElementById('evaluator_type').value = button.dataset.type;
                    document.getElementById('status').value = status; // Set the correct default status

                    // Open the modal
                    modal.style.display = 'flex';
                });
            });

            // Close edit modal
            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Delete criteria
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (confirm("Are you sure you want to delete this criteria?")) {
                        const criteriaId = button.dataset.id;
                        window.location.href = `?delete_id=${criteriaId}`;
                    }
                });
            });

            // Close modal on outside click
            window.addEventListener('click', event => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>