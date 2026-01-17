

document.addEventListener('DOMContentLoaded', function() {


    const userModal = document.getElementById('userModal');
    const userModalTitle = document.getElementById('userModalTitle');
    const userModalSubmitBtn = document.getElementById('userModalSubmitBtn');
    const userAction = document.getElementById('userAction');
    const userIdField = document.getElementById('userIdField');
    const userNameField = document.getElementById('user_name');
    const userEmailField = document.getElementById('user_email');
    const userPasswordField = document.getElementById('user_password');
    const userIsAdminField = document.getElementById('user_is_admin');
    const openCreateUserModal = document.getElementById('openCreateUserModal');


    function resetUserModalForm() {
        userNameField.value = '';
        userEmailField.value = '';
        userPasswordField.value = '';

        userPasswordField.removeAttribute('required');
        userIsAdminField.checked = false;
    }

    if (openCreateUserModal) {
        openCreateUserModal.addEventListener('click', function() {
            resetUserModalForm();
            userModalTitle.textContent = 'Add New User';
            userModalSubmitBtn.textContent = 'Add User';
            userModalSubmitBtn.style.backgroundColor = '#4CAF50';
            userAction.value = 'create';
            userIdField.value = '';

           userPasswordField.setAttribute('required', 'required');
            userModal.style.display = 'flex';
        });
    }

    document.querySelectorAll('.edit-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            resetUserModalForm();
            

            const userId = this.getAttribute('data-user-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const isAdmin = this.getAttribute('data-is-admin'); // 1 or 0
            

            userNameField.value = name;
            userEmailField.value = email;

            userIsAdminField.checked = (isAdmin === '1'); 
            

            userModalTitle.textContent = 'Edit User (ID: ' + userId + ')';
            userModalSubmitBtn.textContent = 'Save Changes';
            userModalSubmitBtn.style.backgroundColor = '#007bff';
            userAction.value = 'edit';
            userIdField.value = userId;

            userModal.style.display = 'flex';
        });
    });


    if (userModal) {
        userModal.addEventListener('click', function(e) {
            if (e.target === userModal) {
                userModal.style.display = 'none';
            }
        });
    }

});