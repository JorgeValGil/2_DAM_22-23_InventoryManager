<?php

/**
 * Procesamiento de productos y categorías
 *
 * @author Jorge Val Gil
 */
class InventoryManagerCsv {

    /**
     * Sube una imagen
     * 
     * @global type $wpdb base de datos Wordpress
     * @param type $file_url URL de la imagen
     * @param type $name nombre para la imagen
     * @return type id de la imagen
     */
    public static function fetch_media($file_url, $name) {
        $id = false;

        require_once(ABSPATH . 'wp-load.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        global $wpdb;

        $artDir = 'wp-content/uploads/inventorymanager/';

        if (!file_exists(ABSPATH . $artDir)) {
            mkdir(ABSPATH . $artDir);
        }

        $ext = array_pop(explode(".", $file_url));
        $new_filename = 'iv-' . $name . "." . $ext;

        if (@fclose(@fopen($file_url, "r"))) {
            copy($file_url, ABSPATH . $artDir . $new_filename);

            $siteurl = get_option('siteurl');
            $file_info = getimagesize(ABSPATH . $artDir . $new_filename);

            $artdata = array(
                'post_author' => 1,
                'post_date' => current_time('mysql'),
                'post_date_gmt' => current_time('mysql'),
                'post_title' => $new_filename,
                'post_status' => 'inherit',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)), 'post_modified' => current_time('mysql'),
                'post_modified_gmt' => current_time('mysql'),
                'post_parent' => 1,
                'post_type' => 'attachment',
                'guid' => $siteurl . '/' . $artDir . $new_filename,
                'post_mime_type' => $file_info['mime'],
                'post_excerpt' => '',
                'post_content' => ''
            );

            $uploads = wp_upload_dir();
            $save_path = $uploads['basedir'] . '/inventorymanager/' . $new_filename;

            $attach_id = wp_insert_attachment($artdata, $save_path, $name);

            if ($attach_data = wp_generate_attachment_metadata($attach_id, $save_path)) {
                wp_update_attachment_metadata($attach_id, $attach_data);
            }
            $id = $attach_id;
        }

        return $id;
    }

    /**
     * Procesa las categorías
     * 
     * @param string $categories_tempname nombre del fichero de categorías
     * @return int cantidad de categorías procesadas
     */
    public static function categories($categories_tempname) {
        $processed = 0;
        //Se abre el fichero
        if (($handle = fopen($categories_tempname, 'r')) !== FALSE) {
            $row = 0;
            //Se lee el fichero
            while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                //Se comprueba que no se está procesando la primera línea
                if ($row > 0) {
                    $name = $data[0];
                    $description = $data[1];
                    $image = $data[2];

                    //Se sube la imagen
                    $thumb_id = InventoryManagerCsv::fetch_media($image, 'cat-' . $row);

                    //Se crea la categoría
                    $cat = wp_insert_term($name, 'product_cat', array(
                        'description' => $description
                    ));

                    //Se vincula la categoría con la imagen
                    if (!is_wp_error($cat)) {
                        $cat_id = isset($cat['term_id']) ? $cat['term_id'] : 0;
                        update_term_meta($cat_id, 'thumbnail_id', absint($thumb_id));
                    }
                    $processed++;
                }
                $row++;
            }
            fclose($handle);
        }
        //Se devuelve la cantidad de categorías procesadas
        return $processed;
    }

    /**
     * Procesa los productos
     * 
     * @param type $products_tempname nombre del fichero de productos
     * @return int cantidad de productos procesados
     */
    public static function products($products_tempname) {
        $processed = 0;
        //Se abre el fichero
        if (($handle = fopen($products_tempname, 'r')) !== FALSE) {
            $row = 0;
            //Se lee el fichero
            while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                //Se comprueba que no se está procesando la primera línea
                if ($row > 0) {
                    $category_name = $data[0];
                    $ref = $data[1];
                    $name = $data[2];
                    $description = $data[3];
                    $units = $data[4];
                    $price = $data[5];
                    $image = $data[6];

                    //Se sube la imagen
                    $thumb_id = InventoryManagerCsv::fetch_media($image, 'prod-' . $row . '-' . $ref);

                    $post_data = array(
                        'post_author' => 1,
                        'post_content' => $description,
                        'post_status' => "publish",
                        'post_title' => $name,
                        'post_parent' => "",
                        'post_type' => "product",
                    );

                    //Se crea el producto
                    $post = wp_insert_post($post_data, $wp_error);

                    //Se vincula el producto con la categoría
                    wp_set_object_terms($post, $category_name, 'product_cat');
                    wp_set_object_terms($post, 'simple', 'product_type');

                    //Se vincula el producto con la imagen
                    set_post_thumbnail($post, $thumb_id);

                    update_post_meta($post, '_visibility', 'visible');
                    update_post_meta($post, '_sku', $ref);
                    update_post_meta($post, '_price', $price);
                    update_post_meta($post, '_stock', $units);
                    if ($units == "0") {
                        update_post_meta($post, '_stock_status', 'outofstock');
                    } else {
                        update_post_meta($post, '_stock_status', 'instock');
                    }
                    $processed++;
                }
                $row++;
            }
            fclose($handle);
        }
        //Se devuelve la cantidad de productos procesados
        return $processed;
    }

}
