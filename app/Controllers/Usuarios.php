<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;
use Dompdf\Dompdf;

class Usuarios  extends BaseController{
    use ResponseTrait;
    /**
     * Muestra la informacion de todos los usuarios
     * 
     * @return array
     * @param
     */
    public function index(){
        $model = new UsuarioModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }
    /**
     * Muestra la informacion de el usuario indicado
     * @return array
     * @param number $id el id de el usuario a mostrar
     */
    public function show($id = null){
        
        $model = new UsuarioModel();
        $data = $model->getWhere(['id_usuario' => $id])->getResult();
        if($data){
            return  $this->respond($data, 200);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
    /**
     * Agrega un nuevo usuario
     * @return array
     * @param string $nombre nombre del usuario
     * @param string $apellidos apellidos del usuario
     * @param string $celular numero de celular del usuario
     * @param string $email correo electronico del usuario
     * @param file $fotografia archivo de la foografia del usuario
     * @param string $contrasenia contraseña del usuario para accesar al sistema
     */
    public function create(){
        if($this->request->user_data->tipo_usuario != "administrador"){
            return $this->failNotFound('Access denied ');
        }
        $model = new UsuarioModel();

        $file = $this->request->getFile('fotografia');
        $ext= $file->guessExtension();
        $imageFileName= $this->request->getPost('nombre')."_".$this->request->getPost('celular').".".$ext;
        $file->move('userImages',$imageFileName);
        $pass = hash("sha256", $this->request->getPost('contrasenia'));

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'celular' => $this->request->getPost('celular'),
            'email' => $this->request->getPost('email'),
            'fotografia' => "userImages/".$imageFileName,
            'contrasenia' => $pass
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }
    /**
     * Actualiza el usuario indicado
     * @return array con los datos actualizados si ubo exito
     * @param string $nombre nombre del usuario
     * @param string $apellidos apellidos del usuario
     * @param string $celular numero de celular del usuario
     * @param string $email correo electronico del usuario
     * @param string $contrasenia contraseña del usuario para accesar al sistema 
     * @param string $tipo_usuario tipo de usuairo al que pertenece el usuario
     * @param string $estatus estatus en el que se encuentra el usuario
     */
    public function update($id = null){
        if($this->request->user_data->tipo_usuario == "basico" && $id != $this->request->user_data->id_usuario){
            return $this->failNotFound('Access denied');
        }
        $model = new UsuarioModel();
        
        $input = $this->request->getRawInput();
        $data = ["modifi_at" => date("Y-m-d H:i:s")];
        if(!empty($input['nombre'])){
            $data["nombre"] = $input['nombre'];
        }
        if(!empty($input['apellidos'])){
            $data["apellidos"] = $input['apellidos'];
        }
        if(!empty($input['celular'])){
            $data["celular"] = $input['celular'];
        }
        if(!empty($input['email'])){
            $data["email"] = $input['email'];
        }
        if(!empty($input['contrasenia'])){
            $pass = hash("sha256", $this->request->getPost('contrasenia'));
            $data["contrasenia"] = $pass;
        }
        if(!empty($input['tipo_usuario'])){
            $data["tipo_usuario"] = $input['tipo_usuario'];
        }
        if(!empty($input['estatus'])){
            $data["estatus"] = $input['estatus'];
        }
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }
    /**
     * Actualiza la fotografia del usuario
     * @return array indicando que la operacion fue exitosa
     * @param number $id id del usuario al que se modificara la fotografia
     * @param file $fotografia archivo e la fotografia
     */
    public function updatepicture($id = null){
        if($this->request->user_data->tipo_usuario == "basico" && $id != $this->request->user_data->id_usuario){
            return $this->failNotFound('Access denied');
        }
        $model = new UsuarioModel();
        $data = $model->getWhere(['id_usuario' => $id])->getResult();
        
        if($data){
            $imagename = explode(".",$data[0]->fotografia)[0];
            $name = (explode("/",$imagename));
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
        
        $file = $this->request->getFile('fotografia');
        $ext= $file->guessExtension();
        $imageFileName= end($name).".".$ext;
        
        $file->move('userImages',$imageFileName);
        $data = [
            'fotografia' => "userImages/".$imageFileName
        ];
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }
    /**
     * Elimina de manera logica al usuario
     * @return array inidicando el esado de la operacion
     * @param number $id id del usuario a eliminar
     */
    public function delete($id = null)
    {
        if($this->request->user_data->tipo_usuario != "administrador"){
            return $this->failNotFound('Access denied ');
        }
        $model = new UsuarioModel();
        $data = $model->find($id);
        if($data){
            $data["estatus"] = 0;
            // Insert to Database
            $model->update($id, $data);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }    
    }
    /**
     * Verifica que el usuario exista y la contraseña sea correcta generando un token para tener acceso a los demas metodos
     * @return array con el token generado y el tipo de usuario logeado
     * @param string $celular celular del usuario
     * @param string $contrasenia contraseña del usuario
     */
    public function login(){
        $encrypter = \Config\Services::encrypter();
        $model = new UsuarioModel();
        $usuario = $this->request->getPost('celular');
        $pass = hash("sha256", $this->request->getPost('contrasenia'));
        
        $data = $model->getWhere(['contrasenia' => $pass, "celular" => $usuario])->getResult();
        if($data){
            $dataLogin["ultimo_login"] = date("Y-m-d H:i:s");
            $model->update($data[0]->id_usuario, $dataLogin);
            $token = $data[0]->id_usuario."|".$data[0]->celular."|".$data[0]->nombre."|".$data[0]->tipo_usuario;
            $ciphertext = $encrypter->encrypt($token);

            return $this->respond(["token" => base64_encode($ciphertext), "tipo" => $data[0]->tipo_usuario]);
        }else{
            return $this->failNotFound('No Data Found');
        }
    }
    /**
     * Genera un archivo pdf con la lista de los usuarios dentro del sistema
     * @return array con el path donde se encuentra el pdf generado
     * 
     */
    public function generatepdf(){
        $model = new UsuarioModel();
        $usuarios = $model->findAll();

        //var_dump($data);die();
        $dompdf = new Dompdf();
        foreach($usuarios AS $indexU => $dataU){
            //var_dump($dataU);die();
            $dataUsers[] = [
                'imageSrc'    => $this->imageToBase64(ROOTPATH . '/public/'.$dataU["fotografia"]),
                'nombre'         => $dataU["nombre"],
                'apellido'      => $dataU["apellidos"],
                'celular' => $dataU["celular"],
                'email'        => $dataU["email"],
                'tipo_usuario' => $dataU["tipo_usuario"]
            ];
        }
        $data = ["usuarios" => $dataUsers];
        $html = view('usuarios', $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();

        $fileName = 'usuarios_'.date("Y_m_d_H_i_s").'.pdf';
        $path = "pdf_files/".$fileName;

        file_put_contents($path, $output);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'File generate',
                'path' => $path
            ]
        ];
        return $this->respond($response);
    }
    /**
     * genera la fuente de la imagen para insertarla dentro del pdf
     * @return resource el recurso para agregar la imagen
     * @param string $path el path donde se encuentra la imagen
     */
    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
