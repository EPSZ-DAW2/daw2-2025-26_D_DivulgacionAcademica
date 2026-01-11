<?php

namespace app\models;

use Yii;

class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
  
  // Atributos para almacenar el control de cambio de la posible contraseña.
  public $password1;
  public $password2;
  
  // Para la nueva contraseña (opcional)
  public $password_plain;

  // Para confirmar cambios (obligatorio al editar)
  public $current_password;

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
   * REGLAS DE VALIDACIÓN (CRUCIAL PARA QUE SE GUARDEN LOS DATOS)
   */
  public function rules()
  {
      return [
          // 1. Campos obligatorios básicos
          [['username', 'nombre', 'email'], 'required'],

          // 2. Tipos de datos
          [['username', 'nombre', 'email', 'password', 'rol'], 'string', 'max' => 255],
          
          // 3. Unicidad
          [['email'], 'unique'],
          [['username'], 'unique'],
          ['email', 'email'],

          // 4. Campos seguros (permitir que el form los envíe)
          [['password_plain', 'password1', 'password2'], 'safe'],

          // 5. REGLA: Contraseña actual obligatoria solo al actualizar (update)
          [['current_password'], 'required', 'on' => 'update'],
          [['current_password'], 'validateCurrentPassword'],
          
          [['fecha_registro'], 'safe'],
      ];
  }

  /**
  * ETIQUETAS DE ATRIBUTOS
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
    const ROL_ESTUDIANTE = 'alumno';

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

   /**
   * Validador personalizado para la contraseña actual
   */
   public function validateCurrentPassword($attribute, $params)
   {
       if (!$this->hasErrors()) {
           // Verificación en texto plano (como pediste)
           if ($this->password !== $this->current_password) {
               $this->addError($attribute, 'La contraseña actual es incorrecta.');
           }
       }
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
