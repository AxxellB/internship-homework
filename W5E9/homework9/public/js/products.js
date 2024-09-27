const apiUrl = 'http://localhost:8000/api/products';

document.addEventListener('DOMContentLoaded', getProducts);
document.addEventListener('DOMContentLoaded', addEventListeners);

function addEventListeners() {
    const createForm = document.getElementById('productForm');
    if (createForm) {
        createForm.addEventListener('submit', createProduct);
    }

    const editForm = document.getElementById('productEditForm');
    if (editForm) {
        editForm.addEventListener('submit', editProduct);
    }
}

function getProducts() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(products => {
            const productsList = document.getElementById('productsList');
            productsList.innerHTML = '';

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${product.description}</td>
                    <td>${product.quantity}</td>
                    <td>${product.price}</td>
                    <td>${product.category.name}</td>
                    <td>
                        <a class="btn btn-warning" href="/product_edit/${product.id}">Edit</a>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                    </td>
                `;
                productsList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching products:', error));
}


function createProduct(e) {
    e.preventDefault();

    const name = document.getElementById('product_create_form_name').value;
    const price = document.getElementById('product_create_form_price').value;
    const quantity = document.getElementById('product_create_form_quantity').value;
    const description = document.getElementById('product_create_form_description').value;
    const category = document.getElementById('product_create_form_category').value;

    const productData = {
        name,
        price,
        quantity,
        description,
        category
    };
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('productForm').reset();
                window.location.href = '/products_display';
            } else {
                return response.json().then(data => {
                    alert(data.error);
                });
            }
        })
        .catch(error => console.error('Error creating product:', error));
}


function editProduct(e) {
    e.preventDefault();

    const urlParts = window.location.pathname.split('/');
    const productId = urlParts[urlParts.length - 1];

    const name = document.getElementById('product_edit_form_name').value;
    const price = document.getElementById('product_edit_form_price').value;
    const quantity = document.getElementById('product_edit_form_quantity').value;
    const description = document.getElementById('product_edit_form_description').value;
    const category = document.getElementById('product_edit_form_category').value;

    const productData = {
        name,
        price,
        quantity,
        description,
        category
    };

    fetch(`${apiUrl}/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('productEditForm').reset();
                window.location.href = '/products_display';
            } else {
                return response.json().then(data => {
                    alert(data.message);
                });
            }
        })
        .catch(error => console.error('Error updating product:', error));
}


function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch(`${apiUrl}/${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    getProducts();
                } else {
                    return response.json().then(data => {
                        alert(data.error);
                    });
                }
            })
            .catch(error => console.error('Error deleting product:', error));
    }
}
