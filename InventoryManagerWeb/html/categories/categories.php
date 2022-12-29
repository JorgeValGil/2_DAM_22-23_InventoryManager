<?php
require_once '../../classes/categories/categories.php';
require_once '../header.php';

$cat = new \categories\categories();
?>

<div id="categories">
    <?php
    if (isset($_GET['created'])) {
        ?>
        <script type="text/javascript">
            function categoryCreated() {
                $.growl.notice({title: "Categoría Creada!", message: ""});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', categoryCreated);
            } else {
                categoryCreated();
            }
        </script>
        <?php
    } elseif (isset($_GET['deleted'])) {
        ?>
        <script type="text/javascript">
            function categoryDeleted() {
                $.growl.notice({title: "Categoría Borrada!", message: ""});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', categoryDeleted);
            } else {
                categoryDeleted();
            }
        </script>
        <?php
    }

    if (isset($_GET['edit'])) {
        $category = $cat->getCategory($_GET['edit']);
        ?>
        <div id="edit">
            <h1 class="display-6">Editar categoría: <?php echo $category['id'] . ' - ' . $category['name'] ?></h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST"  enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control" name="id" type="hidden" value="<?php echo $category['id']; ?>" readonly>
                    <label for="name" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre de la categoría" value="<?php echo $category['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción: </label>
                    <textarea class="form-control" name="description" id="description" rows="3"><?php echo $category['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="imageCategory" class="form-label">Imagen: </label>
                    <input type="file" class="form-control" id="imageCategory" name="imageCategory">
                </div>
                <div class="mb-3">
                    <button type='submit' name='Editar_cat' class='btn save_btn' >Guardar Cambios</button>
                </div>
            </form>
        </div>
    <?php } elseif (isset($_GET['new'])) {
        ?>
        <div id="new">
            <h1 class="display-6">Nueva categoría</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre de la categoría">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción: </label>
                    <textarea class="form-control" name="description" id="description" placeholder="Descripción de la categoría" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="imageCategory" class="form-label">Imagen: </label>
                    <input type="file" class="form-control" id="imageCategory" name="imageCategory">
                </div>
                <div class="mb-3">
                    <button type='submit' name='Crear_cat' class='btn new_btn'>Crear Categoría</button>
                </div>
            </form>
        </div>
        <?php
    } elseif (isset($_GET['delete'])) {
        ?>
        <div id="delete">
            <h1 class="display-6">Borrar categoría</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
                <div class="mb-3">
                    <label for="categoria">Categoría a borrar</label>
                    <select class="form-control" id="categoria" name="categoria">
                        <?php
                        $categories = $cat->getCategories();
                        if (!empty($categories)) {
                            ?>
                            <option value="0">Sin seleccionar</option>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="0">No existen las categorías</option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="mb-3">
                    <button type='submit' name='Borrar_cat' class='btn delete_btn'>Borrar categoría</button>
                </div>
            </form>
        </div>
        <?php
    } else {
        ?>
        <div id="categories-buttons">
            <a href="categories.php?new=1">
                <button type="button" class="btn btn-outline-success">Crear Categoría</button>
            </a>
            <a href="categories.php?delete=1">
                <button type="button" class="btn btn-outline-danger">Borrar Categoría</button>
            </a>
        </div>
        <?php
        $categories = $cat->getCategories();
        if (!empty($categories)) {
            ?>
            <div id="categories-list">
                <?php
                foreach ($categories as $category) {
                    ?>
                    <div class="card col-12 col-md-5 col-lg-3">
                        <img class="card-img-top" src="../../images/categories/<?php echo $category['image']; ?>" alt="Imagen de la categoría <?php echo $category['name'] ?>" title="Imagen de la categoría <?php echo $category['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $category['name'] ?></h5>
                            <p class="card-text"><?php echo $category['description']; ?></p>
                            <a href="../products/products.php?cat=<?php echo $category['id']; ?>" class="btn btn-primary products">Ver Productos</a>
                        </div>
                        <a href="categories.php?edit=<?php echo $category['id']; ?>" class="edit"><img src="../../images/icons/edit.png" alt="Editar" title="Editar"/></a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <h1 class="display-6">No existen categorías</h1>
            <?php
        }
    }
    ?>


</div>

<?php
require_once '../footer.php';
?>