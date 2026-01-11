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
        
        // 3. Unicidad (excepto al actualizar el mismo registro)
        [['email'], 'unique', 'filter' => function ($query) {
            if (!$this->isNewRecord) {
                $query->andWhere(['not', ['id' => $this->id]]);
            }
        }],
        [['username'], 'unique', 'filter' => function ($query) {
            if (!$this->isNewRecord) {
                $query->andWhere(['not', ['id' => $this->id]]);
            }
        }],
        ['email', 'email'],
        
        // 4. Campos seguros
        [['password_plain', 'password1', 'password2', 'current_password'], 'safe'],
        
        // 5. REGLA: Contraseña actual obligatoria solo cuando se cambia la contraseña
        [['current_password'], 'required', 'when' => function($model) {
            return !empty(trim($model->password_plain));
        }, 'whenClient' => "function(attribute, value) {
            return $('#usuario-password_plain').val().trim() !== '';
        }"],
        
        // 6. Validador para contraseña actual
        [['current_password'], 'validateCurrentPassword', 'when' => function($model) {
            return !empty(trim($model->password_plain));
        }],
        
        [['fecha_registro'], 'safe']
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
    return static::findOne(['username' => trim($username)]);
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
    //return null; 
    // Retornar un valor fijo o basado en el ID para que Yii no detecte cambios
    return md5('auth_key_' . $this->id . '_' . $this->password);

  }
  
  /**
   * {@inheritdoc}
   */
  /*public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  } */
  
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

   /**
   * Validador personalizado para la contraseña actual
   */
    //Validador de contraseña actual corregido
   public function validateCurrentPassword($attribute, $params)
{
    if (!$this->hasErrors() && !empty(trim($this->password_plain))) {
        // Obtener la contraseña actual de la base de datos
        $userActual = self::findOne($this->id);
        if ($userActual && trim($this->current_password) !== trim($userActual->password)) {
            $this->addError($attribute, 'La contraseña actual es incorrecta.');
        }
    }
}

/**
 * CLAVE PARA EVITAR CIERRE DE SESIÓN:
 * Como no usamos auth_key en la DB, debemos retornar siempre true para que
 * Yii no invalide la sesión al actualizar el modelo.
 */
public function validateAuthKey($authKey)
{
    return true; 
}

// NUEVO método para definir escenarios
public function scenarios()
{
    $scenarios = parent::scenarios();
    $scenarios['update'] = ['username', 'nombre', 'email', 'password', 'rol', 'password_plain', 'current_password'];
    return $scenarios;
}


public function afterSave($insert, $changedAttributes)
{
    parent::afterSave($insert, $changedAttributes);
    
    Yii::debug('Usuario::afterSave() ejecutado');
    Yii::debug('Cambios realizados: ' . print_r($changedAttributes, true));
    
    // Verificar en base de datos
    $usuarioDb = self::findOne($this->id);
    Yii::debug('Datos en DB después de guardar: ' . print_r($usuarioDb->attributes, true));
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
}