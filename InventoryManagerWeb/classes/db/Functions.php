<?php

namespace db;

/**
 * Funciones
 */
class Functions {

    /**
     * Crea un usuario
     * 
     * @param array $user_data email y contraseña
     * @return boolean
     * @throws \PDOException
     */
    function anadir_usuario($user_data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'insert into usuarios(email, contrasena) values (?,?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $user_data[0],
                                $user_data[1]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha conseguido añadir el usuario";
        } finally {
            $stmt = null;
        }
    }

    /**
     * Comprueba que exista un usuario
     * 
     * @param string $email email
     * @param string $clave contraseña
     * @return boolean
     */
    function comprobar_usuario($email, $clave) {
        try {
            $pdo = Db::getInstance();
            $sql = "select * from usuarios where email=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($email))) {
                $fila = $stmt->fetch();
                if ($fila) {
                    $id = $fila['id'];
                    $hash = $fila['contrasena'];
                    if (password_verify($clave, $hash)) {
                        return array($id, $email);
                    } else {
                        return false;
                    }
                }
                return false;
            }
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se han conseguido leer los datos del usuario.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Comprueba que exista un email de usuario
     * 
     * @param string $email email
     * @return boolean
     * @throws \PDOException
     */
    function comprobar_email($email) {
        try {
            $pdo = Db::getInstance();
            $sql = 'select email from usuarios where email=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array(
                        $email[0]
                    ))) {
                if ($stmt->rowCount() != 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha conseguido comprobar el email.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene las categorías
     * 
     * @return array
     */
    function get_categories() {
        $categories = [];
        try {
            $pdo = Db::getInstance();
            $sql = "select * from categories";
            $stmt = $pdo->query($sql);
            if ($stmt->execute()) {
                $filas = $stmt->fetchAll();
                foreach ($filas as $fila) {
                    $categories[] = ['id' => $fila['id'], 'name' => $fila['name'], 'description' => $fila['description'], 'image' => $fila['image']];
                }
            }
            return $categories;
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se han obtenido las categorías.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene una categoría
     * 
     * @param string $id id de una categoría
     * @return array
     */
    function get_category($id) {
        try {
            $pdo = Db::getInstance();
            $sql = "select * from categories where id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($id))) {
                $fila = $stmt->fetch();
                if ($fila) {
                    return ['id' => $fila['id'], 'name' => $fila['name'], 'description' => $fila['description'], 'image' => $fila['image']];
                } else {
                    return '';
                }
            } else {
                return '';
            }
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha obtenido la categoría.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene la contraseña de un usuario
     * 
     * @param string $id id de un usuario
     * @return string
     */
    function get_password($id) {
        $password = false;
        try {
            $pdo = Db::getInstance();
            $sql = "select * from usuarios where id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($id))) {
                $fila = $stmt->fetch();
                if ($fila) {
                    $password = $fila['contrasena'];
                }
            }
            return $password;
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha obtenido la contraseña.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Actualiza una categoría
     * 
     * @param array $data nombre, descripción e id de categoría
     * @return boolean
     * @throws \PDOException
     */
    function update_category($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'update categories set name=?,'
                    . 'description=?'
                    . ' where id=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1],
                                $data[2]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha podido actualizar la información de la categoría";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Actualiza la imagen de una categoría
     * 
     * @param array $data imagen e id de categoría
     * @return boolean
     * @throws \PDOException
     */
    function update_category_image($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'update categories set image=?'
                    . ' where id=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha podido actualizar la imagen de la categoría";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Crea una categoría
     * 
     * @param array $data nombre, descripción e imagen de categoría
     * @return boolean
     * @throws \PDOException
     */
    function create_category($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'insert into categories(name,description,image) values (?,?,?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1],
                                $data[2]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha conseguido añadir la categoría";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Elimina una categoría
     * 
     * @param string $id id de una categoría
     * @return boolean
     * @throws \PDOException
     */
    function delete_category($id) {
        try {
            $pdo = Db::getInstance();
            $sql = 'delete from categories where id=?';
            $stmt = $pdo->prepare($sql);
            if (($stmt->execute(array($id)))) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error al borrar una categoría";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Elimina un producto
     * 
     * @param string $id id de un producto
     * @return boolean
     * @throws \PDOException
     */
    function delete_product($id) {
        try {
            $pdo = Db::getInstance();
            $sql = 'delete from products where id_product=?';
            $stmt = $pdo->prepare($sql);
            if (($stmt->execute(array($id)))) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error al borrar un producto";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene los productos
     * 
     * @return array
     */
    function get_products() {
        $products = [];
        try {
            $pdo = Db::getInstance();
            $sql = "select * from products";
            $stmt = $pdo->query($sql);
            if ($stmt->execute()) {
                $filas = $stmt->fetchAll();
                foreach ($filas as $fila) {
                    $products[] = ['id' => $fila['id_product'], 'id_category' => $fila['id_category'], 'name' => $fila['name'],
                        'ref' => $fila['ref'], 'description' => $fila['description'], 'image' => $fila['image'], 'units' => $fila['units'], 'price' => $fila['price']];
                }
            }
            return $products;
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se han obtenido los productos.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene el nombre de la categoría de un producto
     * 
     * @param string $id
     * @return string nombre de una categoría
     */
    function get_product_category_name($id) {
        try {
            $pdo = Db::getInstance();
            $sql = "SELECT c.name FROM categories AS c INNER JOIN products AS p on C.id=p.id_category WHERE c.id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($id))) {
                $fila = $stmt->fetch();
                if ($fila) {
                    return $fila['name'];
                } else {
                    return '';
                }
            } else {
                return '';
            }
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha obtenido el producto.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene un producto
     * 
     * @param string $id id de un producto
     * @return array
     */
    function get_product($id) {
        try {
            $pdo = Db::getInstance();
            $sql = "select * from products where id_product=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($id))) {
                $fila = $stmt->fetch();
                if ($fila) {
                    return ['id' => $fila['id_product'], 'id_category' => $fila['id_category'], 'name' => $fila['name'],
                        'ref' => $fila['ref'], 'description' => $fila['description'], 'image' => $fila['image'],
                        'units' => $fila['units'], 'price' => $fila['price']];
                } else {
                    return '';
                }
            } else {
                return '';
            }
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha obtenido el producto.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Obtiene los productos de una categoría
     * 
     * @param string $id id de una categoría
     * @return array
     */
    function get_products_category($id) {
        $products = [];
        try {
            $pdo = Db::getInstance();
            $sql = "select * from products where id_category=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(array($id))) {
                $filas = $stmt->fetchAll();
                foreach ($filas as $fila) {
                    $products[] = ['id' => $fila['id_product'], 'name' => $fila['name'],
                        'ref' => $fila['ref'], 'description' => $fila['description'], 'image' => $fila['image'], 'units' => $fila['units'], 'price' => $fila['price']];
                }
            }
            return $products;
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se han obtenido los productos.";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Crea un producto
     * 
     * @param array $data nombre, id de una categoría, referencia, descripción, unidades, precio e imagen
     * @return boolean
     * @throws \PDOException
     */
    function create_product($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'insert into products(name,id_category,ref,description,units,price,image) values (?,?,?,?,?,?,?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1],
                                $data[2],
                                $data[3],
                                $data[4],
                                $data[5],
                                $data[6]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha conseguido añadir el producto";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Actualiza un producto
     * 
     * @param array $data nombre, id de una categoría, referencia, descripción, unidades, precio e id de un producto
     * @return boolean
     * @throws \PDOException
     */
    function update_product($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'update products set name=?,'
                    . 'id_category=?,'
                    . 'ref=?,'
                    . 'description=?,'
                    . 'units=?,'
                    . 'price=?'
                    . ' where id_product=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1],
                                $data[2],
                                $data[3],
                                $data[4],
                                $data[5],
                                $data[6]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha podido actualizar la información del producto";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Actualiza una imagen de un producto
     * 
     * @param array $data imagen e id de un producto
     * @return boolean
     * @throws \PDOException
     */
    function update_product_image($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'update products set image=?'
                    . ' where id_product=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1]
                            )
                    )
            ) {
                return true;
            } else {
                throw new \PDOException();
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha podido actualizar la imagen del producto";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    /**
     * Actualiza la contraseña de un usuario
     * 
     * @param array $data contraseña e id de un usuario
     * @return boolean
     */
    function update_password($data) {
        try {
            $pdo = Db::getInstance();
            $sql = 'update usuarios set contrasena=?'
                    . 'where id=?';
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(
                            array(
                                $data[0],
                                $data[1]
                            )
                    )
            ) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "Se ha producido un error, no se ha podido actualizar la password del usuario";
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

}
