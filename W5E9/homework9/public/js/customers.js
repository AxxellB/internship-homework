const apiUrl = 'http://localhost:8000/api/customers';

document.addEventListener('DOMContentLoaded', getCustomers);
document.addEventListener('DOMContentLoaded', addEventListeners);

function addEventListeners() {
    const createForm = document.getElementById('customerForm');
    if (createForm) {
        createForm.addEventListener('submit', createCustomer);
    }

    const editForm = document.getElementById('customerEditForm');
    if (editForm) {
        editForm.addEventListener('submit', editCustomer);
    }
}

function getCustomers() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(customers => {
            const customersList = document.getElementById('customersList');
            customersList.innerHTML = '';

            customers.forEach(customer => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${customer.name}</td>
                    <td>${customer.email}</td>
                    <td>${customer.address}</td>
                    <td>${customer.phone}</td>
                    <td>
                        <a class="btn btn-warning" href="/customer_edit/${customer.id}">Edit</a>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteCustomer(${customer.id})">Delete</button>
                    </td>
                `;
                customersList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching customers:', error));
}

function createCustomer(e) {
    e.preventDefault();

    const name = document.getElementById('customer_create_form_name').value;
    const email = document.getElementById('customer_create_form_email').value;
    const address = document.getElementById('customer_create_form_address').value;
    const phone = document.getElementById('customer_create_form_phone').value;

    const customerData = {
        name,
        email,
        address,
        phone
    };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(customerData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('customerForm').reset();
                window.location.href = '/customers_display';
            } else {
                return response.json().then(data => {
                    alert(data.error);
                });
            }
        })
        .catch(error => console.error('Error creating customer:', error));
}

function editCustomer(e) {
    e.preventDefault();

    const urlParts = window.location.pathname.split('/');
    const customerId = urlParts[urlParts.length - 1];

    const name = document.getElementById('customer_edit_form_name').value;
    const email = document.getElementById('customer_edit_form_email').value;
    const address = document.getElementById('customer_edit_form_address').value;
    const phone = document.getElementById('customer_edit_form_phone').value;

    const customerData = {
        name,
        email,
        address,
        phone
    };

    fetch(`${apiUrl}/${customerId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(customerData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('customerEditForm').reset();
                window.location.href = '/customers_display';
            } else {
                return response.json().then(data => {
                    alert(data.error);
                });
            }
        })
        .catch(error => console.error('Error updating customer:', error));
}

function deleteCustomer(id) {
    if (confirm('Are you sure you want to delete this customer?')) {
        fetch(`${apiUrl}/${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    getCustomers();
                } else {
                    return response.json().then(data => {
                        alert(data.error);
                    });
                }
            })
            .catch(error => console.error('Error deleting customer:', error));
    }
}
