<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * @description Validaciones para Cabayada Gen Administrador y Auth Third Party
 */

$config = array(
				 'AuthLogin' => array(
									array(
											'field' => 'user',
											'label' => 'Usuario',
											'rules' => 'trim|required|valid_email'
										 ),
									array(
											'field' => 'password',
											'label' => 'Contraseña',
											'rules' => 'trim|required|md5'
										 ),
									),

				 'Usuarios' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'apellido',
											'label' => 'Apellido Responsable',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'email',
											'label' => 'Email Responsable',
											'rules' => 'trim|required|valid_email'
										 ),
									array(
											'field' => 'valid_password',
											'label' => 'Repetir Passsword',
											'rules' => 'trim|required|md5|min_length[7]'
										 ),
									array(
											'field' => 'password',
											'label' => 'Passsword',
											'rules' => 'trim|required|matches[valid_password]|md5|min_length[7]'
										 ),


									),
				'Atributos' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									),
				'Proyectos' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'descripcion',
											'label' => 'Descripcion',
											'rules' => 'trim|required'
										 ),
									),


				 'Inversores' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'apellido',
											'label' => 'Apellido',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'email',
											'label' => 'Email',
											'rules' => 'trim|required|valid_email'
										 ),
									array(
											'field' => 'password',
											'label' => 'Passsword',
											'rules' => 'trim|required|matches[valid_password]|md5|min_length[7]'
										 ),

									array(
											'field' => 'valid_password',
											'label' => 'Repetir Passsword',
											'rules' => 'trim|required|md5|min_length[7]'
										 ),
									array(
											'field' => 'dni',
											'label' => 'DNI',
											'rules' => 'trim|required'
										 ),
									),
				   'Managers' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'apellido',
											'label' => 'Apellido',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'codigo',
											'label' => 'Código',
											'rules' => 'trim|required'
										 ),
									),
					'PDFS' => array(
									array(
											'field' => 'nombre',
											'label' => 'Nombre',
											'rules' => 'trim|required'
										 ),
									array(
											'field' => 'bajada',
											'label' => 'Bajada',
											'rules' => 'trim|required'
										 ),
									),



			   );
