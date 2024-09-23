# W6E12

W6E12 consists of creating a frontend that would communicate
with the backend we built in W5E9. Now this looks like a fully
functioning web app and supports all the functionalities listed below.

# W5E9

W5E9 consists of building a simple API for an ecommerce platform

### Usage

Here are the options which our API supports:

`CategoryController`

POST | /api/categories
Creates a new category.

GET | /api/categories
Returns a list of all categories.

GET | /api/categories/{id}
Returns a specific category by ID.

PUT | /api/categories/{id}
Updates an existing category by ID.

DELETE | /api/categories/{id}
Deletes a category by ID.

`ProductController`

POST | /api/products
Requires name, price, quantity, and category fields. Creates a new product. On success, returns the created product and
a success message. If validation fails or the category is not found, returns an error message.

GET | /api/products/filterCategory?category={name}
Filters products by category. Requires the category parameter. On success, returns a list of products in the specified
category. If no products or category are found, returns an error message.

GET | /api/products/filterPrice?priceAbove={value}&priceBelow={value}
Filters products by price range. Requires priceAbove and priceBelow parameters. On success, returns a list of products
within the specified price range. If no products are found, returns an error message.

GET | /api/products
Returns a list of all products. If no products are found, returns an error message.

GET | /api/products/{id}
Returns the product with the specified ID. If the product is not found, returns an error message.

PUT | /api/products/{id}
Updates the product with the specified ID. Requires name, price, quantity, and optional description fields. On success,
returns the updated product. If validation fails or the product is not found, returns an error message.

DELETE | /api/products/{id}
Deletes the product with the specified ID. On success, returns a success message. If the product is not found, returns
an error message.

`CustomerController`

POST | /api/customers
Requires name, email, address, and optional phone fields. Creates a new customer. On success, returns the created
customer and a success message. If validation fails or the email already exists, returns an error message.

GET | /api/customers
Returns a list of all customers. If no customers are found, returns an error message.

GET | /api/customers/{id}
Returns the customer with the specified ID. If the customer is not found, returns an error message.

PUT | /api/customers/{id}
Updates the customer with the specified ID. Requires name, email, address, and optional phone fields. On success,
returns the updated customer. If validation fails or the customer is not found, returns an error message.

DELETE | /api/customers/{id}
Deletes the customer with the specified ID. On success, returns a success message. If the customer is not found, returns
an error message.

`OrderController`

POST | /api/orders
Requires order_date, total, status, and customer_id fields. Creates a new order. On success, returns the created order
and a success message. If validation fails or the customer is not found, returns an error message.

GET | /api/orders/filterTotal
Requires totalAbove and totalBelow query parameters. Returns orders with total values within the specified range. If no
orders are found, returns an error message.

GET | /api/orders/filterStatus
Requires orderStatus query parameter. Returns orders with the specified status. If no orders are found, returns an error
message.

GET | /api/orders
Returns a list of all orders. If no orders are found, returns an error message.

GET | /api/orders/{id}
Returns the order with the specified ID. If the order is not found, returns an error message.

PUT | /api/orders/{id}
Updates the order with the specified ID. Requires order_date, total, status, and customer_id fields. On success, returns
the updated order. If validation fails or the order is not found, returns an error message.

DELETE | /api/orders/{id}
Deletes the order with the specified ID. On success, returns a success message. If the order is not found, returns an
error message.