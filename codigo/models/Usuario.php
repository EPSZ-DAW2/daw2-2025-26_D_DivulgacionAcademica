<?php

namespace app\models;

use Yii;

class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
  
  // Atributos para almacenar el control de cambio de la posible contraseña.
  public $password1;
  public $password2;
  
  // NUEVO: Necesario para el formulario _form.php (campo "Nueva Contraseña")
  public $password_plain;

  //--->>>
  // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
  //--->>>
  
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    // Coincide con tu tabla MySQL
    return 'usuario';
  }
  
  /**
   * REGLAS DE VALIDACIÓN (Implementación del PENDIENTE)
   */
  public function rules()
  {
      return [
          // Campos obligatorios
          [['username', 'nombre', 'email'], 'required'],

          // Validaciones de tipo y longitud
          [['username', 'nombre', 'email', 'password', 'rol'], 'string', 'max' => 255],
          
          // El email y username deben ser únicos
          [['email'], 'unique'],
          [['username'], 'unique'],
          
          // Formato email
          ['email', 'email'],

          // IMPORTANTE: Permitir que 'password_plain' pase la validación
          [['password_plain', 'password1', 'password2'], 'safe'],
          
          // Otros campos
          [['fecha_registro'], 'safe'],
      ];
  }

  /**
   * ETIQUETAS DE ATRIBUTOS (Implementación del PENDIENTE)
   */
  public function attributeLabels()
  {
      return [
          'id' => 'ID',
          'username' => 'Usuario',
          'nombre' => 'Nombre Completo',
          'email' => 'Correo Electrónico',
          'password' => 'Contraseña',
          'password_plain' => 'Nueva Contraseña',
          'rol' => 'Rol',
      ];
  }
  
  //PENDIENTE: Método "scenarios" (opcional).
  //PENDIENTE: Método "find".
  
  //<<<---
  // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
  //<<<---
  
  //--->>>
  // Métodos necesarios para cumplir con el "IdentityInterface".
  //--->>>
  
  /**
   * {@inheritdoc}
   */
  public static function findIdentity($id)
  {
    return static::findOne($id);
  }
  
  /**
   * {@inheritdoc}
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    return null; 
  }
  
  /**
   * Finds user by username (Necesario para el Login)
   */
  public static function findByUsername($username)
  {
      return static::findOne(['username' => $username]);
  }

  /**
   * {@inheritdoc}
   */
  public function getId()
  {
    return $this->id;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getAuthKey()
  {
    return null; 
  }
  
  /**
   * {@inheritdoc}
   */
  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }
  
  /**
   * Validates password
   * AHORA MISMO: Texto plano (INSEGURO - Solo para desarrollo)
   */
  public function validatePassword($password)
  {
    return $this->password === $password;
  }

  /**
   * Sets password
   * AHORA MISMO: Texto plano (INSEGURO - Solo para desarrollo)
   */
  public function setPassword($password)
  {
      $this->password = $password;
  }
  
  //<<<---
  // Métodos necesarios para cumplir con el "IdentityInterface".
  //<<<---


  //--->>>
  // Implementación de las vistas restringidas de usuario
  //--->>>

    // 1. Definicion de las constantes para los roles
    const ROL_ADMIN = 'admin';
    const ROL_GESTOR = 'gestor';
    const ROL_EMPRESA = 'empresa';
    const ROL_ESTUDIANTE = 'alumno'; // Ajustado a 'alumno' según tu DB

    // 2. Implementacion de los metodos llamados por los controladores

    /**
     * Devuelve true si el usuario puede ver el backend
     */
    public function puedeAccederBackend()
    {
        return $this->rol === self::ROL_ADMIN || $this->rol === self::ROL_GESTOR;
    }

    /**
     * Devuelve true si el usuario puede gestionar usuarios
     */
    public function puedeGestionarUsuarios()
    {
        return $this->rol === self::ROL_ADMIN;
    }
}

/*
==========================================================================
CÓDIGO PARA FUTURO USO (ENCRIPTACIÓN REAL)
Cuando quieras activar la seguridad, comenta las funciones validatePassword 
y setPassword de arriba, y descomenta estas de abajo:

Si esto lo he añadido yo (Juan), es que por ahora segun como tenemos
gestionada la base de datos por ahora lo de hashear la contraseña como que
no luego ya lo implementamos
==========================================================================

  public function validatePassword($password)
  {
      return Yii::$app->security->validatePassword($password, $this->password);
  }

  public function setPassword($password)
  {
      $this->password = Yii::$app->security->generatePasswordHash($password);
  }

==========================================================================
*/
