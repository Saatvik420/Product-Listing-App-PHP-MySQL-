<?php
$host = 'sql200.infinityfree.com';
$db = 'if0_36992025_saatvik';
$user = 'if0_36992025';
$pass = 'tRSKWjOSM5faNHu';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$filter_conditions = [];
if (isset($_GET['price_min']) && isset($_GET['price_max'])) {
    $filter_conditions[] = "price BETWEEN " . (float)$_GET['price_min'] . " AND " . (float)$_GET['price_max'];
}
if (isset($_GET['category'])) {
    $filter_conditions[] = "category = '" . $conn->real_escape_string($_GET['category']) . "'";
}
if (isset($_GET['sale_status'])) {
    $filter_conditions[] = "sale_status = '" . $conn->real_escape_string($_GET['sale_status']) . "'";
}
if (isset($_GET['platform'])) {
    $filter_conditions[] = "platform = '" . $conn->real_escape_string($_GET['platform']) . "'";
}

$where_clause = !empty($filter_conditions) ? "WHERE " . implode(' AND ', $filter_conditions) : "";

$sql = "SELECT * FROM products $where_clause LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(*) AS total FROM products $where_clause";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        .filters, .products, .pagination {
            margin: 20px;
        }
        .filters div, .products div {
            margin-bottom: 10px;
        }
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            display: inline-block;
            width: 200px;
            margin: 10px;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <form method="GET" class="filters">
        <div>
            <label for="price_min">Min Price:</label>
            <input type="number" id="price_min" name="price_min" step="0.01">
        </div>
        <div>
            <label for="price_max">Max Price:</label>
            <input type="number" id="price_max" name="price_max" step="0.01">
        </div>
        <div>
            <label for="category">Category:</label>
            <input type="text" id="category" name="category">
        </div>
        <div>
            <label for="sale_status">Sale Status:</label>
            <select id="sale_status" name="sale_status">
                <option value="">--Select--</option>
                <option value="on_sale">On Sale</option>
                <option value="not_on_sale">Not on Sale</option>
            </select>
        </div>
        <div>
            <label for="platform">Platform:</label>
            <input type="text" id="platform" name="platform">
        </div>
        <button type="submit">Filter</button>
    </form>

    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p>Price: $<?php echo $row['price']; ?></p>
                <p>Category: <?php echo $row['category']; ?></p>
                <p>Sale Status: <?php echo $row['sale_status']; ?></p>
                <p>Platform: <?php echo $row['platform']; ?></p>
                <p>Stock: <?php echo $row['stock']; ?></p>
                <button <?php echo $row['stock'] == 0 ? 'disabled' : ''; ?>><?php echo $row['stock'] == 0 ? 'Out of stock' : 'Add to cart'; ?></button>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&price_min=<?php echo $_GET['price_min'] ?? ''; ?>&price_max=<?php echo $_GET['price_max'] ?? ''; ?>&category=<?php echo $_GET['category'] ?? ''; ?>&sale_status=<?php echo $_GET['sale_status'] ?? ''; ?>&platform=<?php echo $_GET['platform'] ?? ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
