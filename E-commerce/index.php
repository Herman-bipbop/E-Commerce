<?php
// index.php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Traitement de l'ajout au panier
if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if ($quantity > 0) {
        addToCart($productId, $quantity);
        header('Location: index.php?added=1');
        exit;
    }
}

$products = getProducts();
include 'includes/header.php';
?>

<h2>Nos produits</h2>

<?php if (isset($_GET['added'])): ?>
    <div class="success-message">
        <p>Le produit a été ajouté à votre panier!</p>
    </div>
<?php endif; ?>

<div class="products-grid">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <div class="product-image">
            <?php if (!empty($product['image'])): ?>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php else: ?>
            <div class="no-image">Pas d'image</div>
            <?php endif; ?>
        </div>
        <div class="product-info">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="price"><?php echo number_format($product['price'], 2, ',', ' '); ?> €</p>
            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
            
            <form action="index.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="quantity">
                    <label for="quantity-<?php echo $product['id']; ?>">Quantité:</label>
                    <input type="number" id="quantity-<?php echo $product['id']; ?>" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-primary">Ajouter au panier</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php if (empty($products)): ?>
    <p>Aucun produit disponible pour le moment.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>