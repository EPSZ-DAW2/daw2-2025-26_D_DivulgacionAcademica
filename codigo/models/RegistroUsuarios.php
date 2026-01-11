<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistroUsuarios es el modelo detrás del formulario de registro.
 */
class RegistroUsuarios extends Model
{
    public $username;
    public $email;
    public $password;
    public $nombre;
    public $rol;

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            // Todos estos campos son obligatorios
            [['username', 'email', 'password', 'nombre', 'rol'], 'required', 'message' => 'Este campo es obligatorio.'],
            
            // Validaciones para el nombre de usuario
            ['username', 'trim'], // Elimina espacios en blanco al inicio y final
            ['username', 'unique', 'targetClass' => '\app\models\Usuario', 'message' => 'Este nombre de usuario ya está en uso.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            // Validaciones para el email
            ['email', 'trim'],
            ['email', 'email', 'message' => 'El formato del correo no es válido.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\Usuario', 'message' => 'Esta dirección de correo ya está registrada.'],

            // Validaciones para la contraseña
            ['password', 'string', 'min' => 4, 'message' => 'La contraseña debe tener al menos 4 caracteres.'],
            
            // Validaciones de longitud para nombre y apellidos
            [['nombre'], 'string', 'max' => 255],

            //Validacion para el rol
            [['rol'], 'string'],
        ];
    }

    /**
     * Registra al usuario en la base de datos.
     *
     * @return bool si la creación de la cuenta fue exitosa.
     */
    public function signup()
    {
        // Si la validación falla (ej. usuario repetido), no continuamos
        if (!$this->validate()) {
            return false;
        }

        $user = new Usuario();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->nombre = $this->nombre;
        $user->rol = $this->rol;
        
        // Guardamos la contraseña en texto plano (según tu configuración actual)
        // NOTA: Si en el futuro hay que encriptar, debemos usar: Yii::$app->security->generatePasswordHash($this->password);
        $user->password = $this->password; 
        
        // Esto es por si queremos porner un rol por defecto.
//        $user->rol = 'alumno'; 

        // Guardamos el modelo Usuario en la base de datos
        return $user->save();
    }

}
