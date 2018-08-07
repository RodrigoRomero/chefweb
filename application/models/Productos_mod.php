<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



class productos_mod extends RR_Model {

	public function __construct() {
		parent::__construct();
	}



	public function getProductos(){

		$productos = $this->db->select('p.id, p.nombre, p.bajada, p.precio_regular, p.precio_oferta, p.fecha_baja, p.descripcion, p.agotadas, p.sku, p.min_qty, p.max_qty', FALSE)
						   ->from('productos p')
						   ->where( array('p.status'=>1,  'tipo'=>1))
						   ->get()->result();
		return $productos;
	}


	public function getProductoById($id){

		$productos = $this->db->select('p.id, p.nombre, p.bajada, p.precio_regular, p.precio_oferta, p.fecha_baja, p.descripcion, p.agotadas, p.sku, p.min_qty, p.max_qty', FALSE)
						   ->from('productos p')
						   ->where( array('p.status'=>1,  'tipo'=>1, 'id'=>$id))
						   ->get()->row();
		return $productos;
	}


	public function getMasVendidos($id){

		$query = 'SELECT p.id, p.nombre
				  FROM productos p
				  LEFT JOIN ( SELECT SUM(quantity) mas_vendido, product_id FROM order_productos GROUP BY product_id) op ON op.product_id = p.id
				  WHERE p.id != ?
				  AND p.status = 1
				  ORDER BY op.mas_vendido DESC
				  LIMIT 10';

		$data = $this->db->query($query, [$id])->result();
		shuffle($data);
		return $data;

	}
}
