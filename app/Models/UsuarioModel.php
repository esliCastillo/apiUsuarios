<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre','apellidos','celular','email','fotografia','contrasenia','tipo_usuario','create_at','modifi_at','ultimo_login','estatus'];
}