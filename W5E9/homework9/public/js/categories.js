const apiUrl = 'http://localhost:8000/api/categories';

document.addEventListener('DOMContentLoaded', getCategories);
document.addEventListener('DOMContentLoaded', addEventListeners);

function addEventListeners() {
    const createForm = document.getElementById('categoryForm');
    if (createForm) {
        createForm.addEventListener('submit', createCategory);
    }

    const editForm = document.getElementById('categoryEditForm');
    if (editForm) {
        editForm.addEventListener('submit', editCategory);
    }
}

function getCategories() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(categories => {
            const categoryList = document.getElementById('categoryList');
            categoryList.innerHTML = '';

            categories.forEach(category => {
                const row = document.createElement('tr'); // Create a new row
                row.innerHTML = `
                    <td>${category.name}</td>
                    <td>${category.description}</td>
                    <td>
                        <a class="btn btn-warning" href="/category_edit/${category.id}">Edit</a>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteCategory(${category.id})">Delete</button>
                    </td>
                `;
                categoryList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
}


function createCategory(e) {
    e.preventDefault();

    const name = document.getElementById('category_form_name').value;
    const description = document.getElementById('category_form_description').value;
    console.log(name);
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({name, description})
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('categoryForm').reset();
                window.location.href = '/categories_display';
            } else {
                return response.json().then(data => {
                    alert(data.message);
                });
            }
        })
        .catch(error => console.error('Error creating category:', error));
}

function editCategory(e) {
    e.preventDefault();

    const urlParts = window.location.pathname.split('/');
    const categoryId = urlParts[urlParts.length - 1];

    const name = document.getElementById('category_edit_form_name').value;
    const description = document.getElementById('category_edit_form_description').value;
    console.log(description)
    fetch(`${apiUrl}/${categoryId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({name, description})
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('categoryEditForm').reset();
                window.location.href = '/categories_display';
            } else {
                return response.json().then(data => {
                    alert(data.message);
                });
            }
        }).catch(error => console.error('Error creating category:', error));
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        fetch(`${apiUrl}/${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    getCategories();
                } else {
                    return response.json().then(data => {
                        alert(data.message);
                    });
                }
            })
            .catch(error => console.error('Error deleting category:', error));
    }
}
