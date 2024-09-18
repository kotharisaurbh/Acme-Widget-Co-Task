<?php

class Basket
{
    private $products = [];
    private $catalogue;
    private $deliveryRules;
    private $offers;

    public function __construct($catalogue, $deliveryRules, $offers)
    {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    // Add product by product code
    public function add($productCode)
    {
        if (isset($this->catalogue[$productCode])) {
            $this->products[] = $productCode;
        }
    }

    // Calculate the total cost including offers and delivery charges
    public function total()
    {
        $subtotal = 0;
        $productCounts = array_count_values($this->products);

        // Calculate the cost of each product and apply any offers
        foreach ($productCounts as $productCode => $count) {
            $price = $this->catalogue[$productCode];
            
            // Apply "Buy one Red Widget, get the second at half price"
            if ($productCode == 'R01' && isset($this->offers['R01'])) {
                $fullPriceCount = intval($count / 2) + $count % 2;
                $halfPriceCount = intval($count / 2);
                $subtotal += $fullPriceCount * $price + $halfPriceCount * ($price / 2);
            } else {
                $subtotal += $count * $price;
            }
        }

        // Apply delivery charges based on the subtotal
        $delivery = $this->getDeliveryCharge($subtotal);

        return number_format($subtotal + $delivery, 2);
    }

    // Get the delivery charge based on the total amount
    private function getDeliveryCharge($subtotal)
    {
        foreach ($this->deliveryRules as $threshold => $charge) {
            if ($subtotal >= $threshold) {
                return $charge;
            }
        }
        return end($this->deliveryRules); // Return the highest charge if below all thresholds
    }
}

// Initialize the catalogue, delivery charges, and offers
$catalogue = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95
];

$deliveryRules = [
    90 => 0,     // Free delivery for orders >= $90
    50 => 2.95,  // $2.95 for orders >= $50
    0 => 4.95    // $4.95 for orders < $50
];

$offers = [
    'R01' => 'buy_one_get_second_half_price'
];

// Example usage
$basket = new Basket($catalogue, $deliveryRules, $offers);

// Add products to the basket
$basket->add('B01');
$basket->add('G01');

// Print the total cost
echo "Total: $" . $basket->total() . "\n";

// Add more products to test other scenarios
$basket->add('R01');
$basket->add('R01');
echo "Total with offers: $" . $basket->total() . "\n";
?>
