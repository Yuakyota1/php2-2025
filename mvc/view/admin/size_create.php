<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Size</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Thêm Size</h2>
                <form method="POST" class="border p-4 rounded shadow-sm bg-light">
                    <div class="mb-3">
                        <label for="nameSize" class="form-label">Tên Size:</label>
                        <input 
                            type="text" 
                            id="nameSize" 
                            name="nameSize" 
                            class="form-control" 
                            placeholder="Nhập tên size" 
                            >
                    </div>
                    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
                    <button type="submit" class="btn btn-primary w-100">Thêm Size</button>
                </form>
                
            </div>
        </div>
    </div>
    <!-- Link JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
