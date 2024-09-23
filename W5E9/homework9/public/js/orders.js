const apiUrl = 'http://localhost:8000/api/orders';

document.addEventListener('DOMContentLoaded', getOrders);
document.addEventListener('DOMContentLoaded', addEventListeners);

function addEventListeners() {
    const createForm = document.getElementById('orderForm');
    if (createForm) {
        createForm.addEventListener('submit', createOrder);
    }

    const editForm = document.getElementById('orderEditForm');
    if (editForm) {
        editForm.addEventListener('submit', editOrder);
    }
}

function getOrders() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(orders => {
            const ordersList = document.getElementById('ordersList');
            ordersList.innerHTML = '';

            orders.forEach(order => {
                console.log(order)
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.orderDate.split("T")[0]}</td>
                    <td>${order.total}</td>
                    <td>${order.status}</td>
                    <td>${order.customer.name}</td>
                    <td>
                        <a class="btn btn-warning" href="/order_edit/${order.id}">Edit</a>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteOrder(${order.id})">Delete</button>
                    </td>
                `;
                ordersList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching orders:', error));
}

function createOrder(e) {
    e.preventDefault();

    const orderDate = document.getElementById('order_create_form_order_date').value;
    const total = document.getElementById('order_create_form_total').value;
    const status = document.getElementById('order_create_form_status').value;
    const customer = document.getElementById('order_create_form_customer').value;

    const orderData = {
        order_date: orderDate,
        total,
        status,
        customer
    };
    console.log(orderData)
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('orderForm').reset();
                window.location.href = '/orders_display';
            } else {
                return response.json().then(data => {
                    alert(data.error);
                });
            }
        })
        .catch(error => console.error('Error creating order:', error));
}

function editOrder(e) {
    e.preventDefault();

    const urlParts = window.location.pathname.split('/');
    const orderId = urlParts[urlParts.length - 1];

    const orderDate = document.getElementById('order_edit_form_order_date').value;
    const total = document.getElementById('order_edit_form_total').value;
    const status = document.getElementById('order_edit_form_status').value;
    const customer = document.getElementById('order_edit_form_customer').value;

    const orderData = {
        order_date: orderDate,
        total,
        status,
        customer
    };
    console.log(orderData)

    fetch(`${apiUrl}/${orderId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('orderEditForm').reset();
                window.location.href = '/orders_display';
            } else {
                return response.json().then(data => {
                    alert(data.error);
                });
            }
        })
        .catch(error => console.error('Error updating order:', error));
}

function deleteOrder(id) {
    if (confirm('Are you sure you want to delete this order?')) {
        fetch(`${apiUrl}/${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    getOrders();
                } else {
                    return response.json().then(data => {
                        alert(data.error);
                    });
                }
            })
            .catch(error => console.error('Error deleting order:', error));
    }
}
