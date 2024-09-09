<?php
/*
Plugin Name: Feed Instagram Register
Description: Plugin para registrar usuarios y enviar datos a Airtable.
Version: 1.0
Author: Jesus Jimenez
*/

// Registrar el shortcode para el formulario de registro
function feed_instagram_register_form() {
    ob_start();
    $plugin_url = plugins_url('instagram.png', __FILE__); 

    ?>
    <form id="registration-form" method="post">
        <div class="register-image">
            <img class="img-register" src="<?php echo esc_url($plugin_url); ?>" alt="Instagram Logo">
        </div>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="text" id="phone" name="phone" placeholder="Número de Teléfono (opcional)">
        <input type="text" id="username" name="username" placeholder="Nombre de Usuario" required>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
        <button class="btn-register" type="submit">Sign up</button>
        <div id="registration-message"></div>
    </form>
    <div class="container-login-firts">
        <p>Have an account? <a class="text-register-firts" href="<?php echo esc_url(home_url('/login')); ?>">Log in</a></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('feed_instagram_register', 'feed_instagram_register_form');

// Manejar el registro de usuarios
function feed_instagram_handle_registration() {
    if (isset($_POST['email'], $_POST['phone'], $_POST['username'], $_POST['password'])) {
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        // Verificar si el usuario ya existe por nombre de usuario o email
        if (username_exists($username) || email_exists($email)) {
            wp_send_json_error('El usuario o el email ya están en uso.');
        }

        // Crear el usuario en WordPress
        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            wp_send_json_error($user_id->get_error_message());
        }

        // Guardar el número de teléfono en el perfil del usuario
        if (!empty($phone)) {
            update_user_meta($user_id, 'telefono', $phone);
        }

        // Enviar datos a Airtable
        $airtable_url = 'https://api.airtable.com/v0/appzmB3zBmwWkhnkn/Usuarios';
        $airtable_key = 'patv59bjnbEGUFZG8.cd0546b6e89b9368307894b52c97ef81268d5253071ed72b4d94d955b441b576'; // Tu API Key
        $response = wp_remote_post($airtable_url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $airtable_key,
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'fields' => array(
                    'Nombre' => $username,
                    'Password' => $password, 
                    'Telefono' => $phone,
                    'email' => $email,
                ),
            )),
        ));

        if (is_wp_error($response)) {
            wp_send_json_error('Error al enviar datos a Airtable: ' . $response->get_error_message());
        }

        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);
        if (isset($response_data['error'])) {
            wp_send_json_error('Error en Airtable: ' . $response_data['error']['message']);
        }

        wp_send_json_success('Registro exitoso.');
    } else {
        wp_send_json_error('Datos faltantes.');
    }
}
add_action('wp_ajax_feed_instagram_register', 'feed_instagram_handle_registration');
add_action('wp_ajax_nopriv_feed_instagram_register', 'feed_instagram_handle_registration');

function feed_instagram_register_enqueue_scripts() {

    wp_enqueue_script('feed-instagram-script', plugins_url('/script_register.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style('feed-instagram-register-style', plugins_url('/style_register.css', __FILE__));

    $login_page = get_permalink(get_page_by_title('login'));

    wp_localize_script('feed-instagram-script', 'feedInstagramAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'loginUrl' => $login_page, 
    ));
}
add_action('wp_enqueue_scripts', 'feed_instagram_register_enqueue_scripts');