# Acme-Widget-Co-Task

# How to Run:
1. Clone the code from the repository.
2. Set up the local environment with PHP.
3 .Run the PHP script to check the basket calculations.

# Example Basket Scenarios:
B01, G01 => $37.85
R01, R01 => $54.37 (with half-price offer on the second R01)
R01, G01 => $60.85
B01, B01, R01, R01, R01 => $98.27 (with the delivery and offer applied)

# Key Considerations:
1. Product Catalogue: Associative array storing products and their prices.
2. Delivery Charge Rules: Charges change depending on the total amount.
3. Special Offers: A specific logic for applying discounts on multiple items.

