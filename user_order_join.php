<?php
include 'config.php';

$result = mysqli_query($conn, "
   SELECT 
      users.name AS user_name,
      users.email,
      orders.name AS order_name,
      orders.total_price,
      orders.placed_on
   FROM 
      users
   JOIN 
      orders ON users.id = orders.user_id
") or die('query failed');
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>User Orders (JOIN Example)</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
      }
      h2 {
         text-align: center;
         margin: 30px 0;
      }
      table {
         width: 90%;
         margin: auto;
         border-collapse: collapse;
         background: white;
         box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      th, td {
         padding: 12px 15px;
         text-align: center;
         border-bottom: 1px solid #ddd;
      }
      th {
         background-color: #eee;
         font-weight: bold;
      }
      tr:hover {
         background-color: #f1f1f1;
      }
   </style>
</head>
<body>
   <h2>User Orders (JOIN Example)</h2>
   <table>
      <thead>
         <tr>
            <th>User Name</th>
            <th>Email</th>
            <th>Order Name</th>
            <th>Total Price</th>
            <th>Date</th>
         </tr>
      </thead>
      <tbody>
         <?php while($row = mysqli_fetch_assoc($result)) { ?>
         <tr>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['order_name']) ?></td>
            <td>$<?= htmlspecialchars($row['total_price']) ?></td>
            <td><?= htmlspecialchars($row['placed_on']) ?></td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</body>
</html>
