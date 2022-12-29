<?php
require_once '../../classes/products/products.php';
require_once '../header.php';

$prod = new \products\products();
?>

<div id="products">
    <?php
    if (isset($_GET['created'])) {
        ?>
        <script type="text/javascript">
            function productCreated() {
                $.growl.notice({title: "Producto Creado!", message: ""});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', productCreated);
            } else {
                productCreated();
            }
        </script>
        <?php
    } elseif (isset($_GET['deleted'])) {
        ?>
        <script type="text/javascript">
            function productDeleted() {
                $.growl.notice({title: "Producto Borrado!", message: ""});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', productDeleted);
            } else {
                productDeleted();
            }
        </script>
        <?php
    }

    if (isset($_GET['edit'])) {
        $product = $prod->getProduct($_GET['edit']);
        ?>
        <div id="edit">
            <h1 class="display-6">Editar producto: <?php echo $product['id'] . ' - ' . $product['name'] ?></h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST"  enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control" name="id" type="hidden" value="<?php echo $product['id']; ?>" readonly>
                    <label for="name" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre del producto" value="<?php echo $product['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoria">Categoría: </label>
                    <select class="form-control" id="categoria" name="categoria">
                        <?php
                        $function = new \db\Functions();
                        $categories = $function->get_categories();
                        if (!empty($categories)) {
                            ?>
                            <option value="0">Sin seleccionar</option>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?php echo $category['id']; ?>" <?php
                                if ($category['id'] == $product['id_category']) {
                                    echo " selected='selected'";
                                }
                                ?> >
                                    <?php echo $category['name']; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="0">No existen categorías</option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Referencia: </label>
                    <input type="text" class="form-control" name="ref" id="ref" placeholder="Referencia del producto" value="<?php echo $product['ref']; ?>">
                </div>
                <div class="mb-3">
                    <label for="units" class="form-label">Unidades: </label>
                    <input type="number" class="form-control" name="units" id="units" placeholder="Unidades del producto" value="<?php echo $product['units']; ?>" step="1" min="0">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Precio(€): </label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Precio del producto" value="<?php echo $product['price']; ?>" step="0.01" min="0">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción: </label>
                    <textarea class="form-control" name="description" id="description" rows="3"><?php echo $product['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="imageProduct" class="form-label">Imagen: </label>
                    <input type="file" class="form-control" id="imageProduct" name="imageProduct">
                </div>
                <div class="mb-3">
                    <button type='submit' name='Editar_prod' class='btn save_btn' >Guardar Cambios</button>
                </div>
            </form>
        </div>
    <?php } elseif (isset($_GET['new'])) {
        ?>
        <div id="new">
            <h1 class="display-6">Nuevo Producto</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre del producto">
                </div>
                <div class="mb-3">
                    <label for="categoria">Categoría: </label>
                    <select class="form-control" id="categoria" name="categoria">
                        <?php
                        $function = new \db\Functions();
                        $categories = $function->get_categories();
                        if (!empty($categories)) {
                            ?>
                            <option value="0">Sin seleccionar</option>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo $category['name']; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="0">No existen categorías</option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Referencia: </label>
                    <input type="text" class="form-control" name="ref" id="ref" placeholder="Referencia del producto">
                </div>
                <div class="mb-3">
                    <label for="units" class="form-label">Unidades: </label>
                    <input type="number" class="form-control" name="units" id="units" placeholder="Unidades del producto" step="1" min="0">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Precio(€): </label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Precio del producto" step="0.01" min="0">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción: </label>
                    <textarea class="form-control" name="description" id="description" placeholder="Descripción del producto" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="imageProduct" class="form-label">Imagen: </label>
                    <input type="file" class="form-control" id="imageProduct" name="imageProduct">
                </div>
                <div class="mb-3">
                    <button type='submit' name='Crear_prod' class='btn new_btn'>Crear Producto</button>
                </div>
            </form>
        </div>
        <?php
    } elseif (isset($_GET['delete'])) {
        ?>
        <div id="delete">
            <h1 class="display-6">Borrar producto</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
                <div class="mb-3">
                    <label for="producto">Producto a borrar</label>
                    <select class="form-control" id="producto" name="producto">
                        <?php
                        $products = $prod->getProducts();
                        if (!empty($products)) {
                            ?>
                            <option value="0">Sin seleccionar</option>
                            <?php
                            foreach ($products as $product) {
                                ?>
                                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="0">No existen productos</option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="mb-3">
                    <button type='submit' name='Borrar_prod' class='btn delete_btn'>Borrar producto</button>
                </div>
            </form>
        </div>
        <?php
    } elseif (isset($_GET['show'])) {
        $product = $prod->getProduct($_GET['show']);
        ?>
        <div id="show">
            <h1 class="display-6"><?php echo $product['name']; ?></h1>
            <img src="../../images/products/<?php echo $product['image']; ?>" alt="Imagen producto <?php echo $product['name']; ?>" title="Imagen producto <?php echo $product['name']; ?>"/>
            <div class="row">
                <div class="col-12 col-md-4">
                    <p><span class="bold">Referencia:</span><br><?php echo $product['ref']; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <p><span class="bold">Unidades:</span><br><?php echo $product['units']; ?></p>
                </div>
                <div class="col-12 col-md-4">
                    <p><span class="bold">Precio(€):</span><br><?php echo $product['price']; ?></p>    
                </div>
            </div>
            <p><span class="bold">Descripción:</span><br><?php echo $product['description']; ?></p>
            <a href="products.php?edit=<?php echo $product['id']; ?>" class="edit">
                <button class='btn edit_btn'>Editar producto</button>
            </a>
        </div>
        <?php
    } elseif (isset($_GET['cat'])) {
        $products = $prod->getProductsCategory($_GET['cat']);
        if (!empty($products)) {
            ?>
            <h1 class="display-6">Productos Categoría: <?php echo $prod->getproductCategoryName($_GET['cat']); ?></h1>
            <div id="products-list">
                <?php
                foreach ($products as $product) {
                    ?>
                    <div class="card col-12 col-md-5 col-lg-3">
                        <img class="card-img-top" src="../../images/products/<?php echo $product['image']; ?>" alt="Imagen del producto <?php echo $product['name'] ?>" title="Imagen del producto <?php echo $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name'] ?></h5>
                            <p class="card-text"><span class="bold">Referencia:</span> <?php echo $product['ref']; ?></p>
                            <a href="products.php?show=<?php echo $product['id']; ?>" class="btn btn-primary product">Ver Producto</a>
                        </div>
                        <a href="products.php?edit=<?php echo $product['id']; ?>" class="edit">
                            <img src="../../images/icons/edit.png" alt="Editar" title="Editar"/>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <h1 class="display-6">No existen productos</h1>
            <?php
        }
    } else {
        ?>
        <div id="products-buttons">
            <a href="products.php?new=1">
                <button type="button" class="btn btn-outline-success">Crear Producto</button>
            </a>
            <a href="products.php?delete=1">
                <button type="button" class="btn btn-outline-danger">Borrar Producto</button>
            </a>
        </div>
        <?php
        $products = $prod->getProducts();
        if (!empty($products)) {
            ?>
            <div id="products-list">
                <?php
                foreach ($products as $product) {
                    ?>
                    <div class="card col-12 col-md-5 col-lg-3">
                        <img class="card-img-top" src="../../images/products/<?php echo $product['image']; ?>" alt="Imagen del producto <?php echo $product['name'] ?>" title="Imagen del producto <?php echo $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name'] ?></h5>
                            <p class="card-text"><span class="bold">Referencia:</span> <?php echo $product['ref']; ?></p>
                            <a href="products.php?show=<?php echo $product['id']; ?>" class="btn btn-primary product">Ver Producto</a>
                        </div>
                        <a href="products.php?edit=<?php echo $product['id']; ?>" class="edit">
                            <img src="../../images/icons/edit.png" alt="Editar" title="Editar"/>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <h1 class="display-6">No existen productos</h1>
            <?php
        }
    }
    ?>


</div>

<?php
require_once '../footer.php';
?>