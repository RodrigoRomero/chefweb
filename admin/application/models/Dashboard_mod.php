<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 *
 *  TODO: LOG
 */
class dashboard_mod extends RR_Model {
	public function __construct() {
		parent::__construct();
	}


	public function getTotal($tipo_ticket){
		$sql = "SELECT SUM(nominar) total
  				FROM order_tickets
  				WHERE order_tickets.`evento_id` = ?
  				AND tipo = ?";

		$total = $this->db->query($sql, [$this->evento_id,$tipo_ticket])->row();

		return $total;
	}

	public function getTotalActive($tipo_ticket){
		$sql = "SELECT SUM(nominar) total
				FROM order_tickets
				LEFT JOIN orders ON orders.id = order_tickets.`order_id`
				WHERE order_tickets.`evento_id` = ?
				AND tipo = ?
				AND orders.`status` >= 0";

		$total = $this->db->query($sql,[$this->evento_id,$tipo_ticket])->row();

		return $total;
	}

	public function getTotalNominados($tipo_ticket){
		$sql = "SELECT COUNT(acreditados.`id`) total
				FROM   acreditados
				LEFT JOIN order_tickets ON acreditados.`order_ticket_id` = order_tickets.`id`
				WHERE acreditados.`evento_id` = ?
				AND order_tickets.`tipo` = ?
				AND acreditados.`status` >= 0";

		$total = $this->db->query($sql,[$this->evento_id,$tipo_ticket])->row();

		return $total;
	}

	public function lastNominados($tipo_ticket,$limit){
		$sql = "SELECT acreditados.`nombre`, acreditados.`apellido`, customers.`empresa`
				FROM acreditados
				LEFT JOIN customers ON customers.`id` = acreditados.`customer_id`
				LEFT JOIN order_tickets ON order_tickets.`id` = acreditados.`order_ticket_id`
				WHERE acreditados.`status` >= 0
				AND acreditados.`evento_id` = ?
				AND order_tickets.`tipo` = ?
				ORDER BY acreditados.`id` DESC
				LIMIT ?";
		$result = $this->db->query($sql, [$this->evento_id,$tipo_ticket,$limit])->result();

		$title = ($tipo_ticket ==2) ? 'Últimas 10 Nominaciones (Almuerzos)' :  'Últimas 10 Nominaciones (Evento)';
		$box_header = $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-user', 'box_icon'=>true), true);
		$box_content = '<ul class="unstyled">';
		foreach($result as $usuario){
			$box_content .= '<li><b>'.$usuario->empresa.'</b> - '.$usuario->nombre.' '.$usuario->apellido.'</li>';
		}
		$box_content .= '</ul>';
		$box = $this->load->view('layout/panels/box', array('box_header'=>$box_header,'box_content'=>$box_content), true);
		return $box;
	}


	public function getTotalByTicket(){
		$sql ="SELECT SUM(order_tickets.`nominar`) total, tickets.`nombre`
			   FROM order_tickets
			   LEFT JOIN tickets ON tickets.`id` = order_tickets.`ticket_id`
			  # LEFT JOIN orders ON orders.`id` = order_tickets.`order_id`
			   WHERE order_tickets.`evento_id` = ?
			   #AND orders.`status` >= 0
			   GROUP BY order_tickets.`ticket_id`";

		$total_tickets = $this->db->query($sql, [$this->evento_id])->result();

		return $total_tickets;
	}

	public function getTotalByMedioPago(){
		$sql ="SELECT COUNT(id) total, gateway
		       FROM orders
		       WHERE STATUS >= 0
		       AND evento_id = ?
		       GROUP BY gateway";
		$total_medio_pago = $this->db->query($sql, [$this->evento_id])->result();
		return $total_medio_pago;
	}

	public function getInscriptosPlanesPie(){
		$evento = $this->db->get_where('eventos',array('status'=>1, 'id'=>$this->evento_id))->row();
		$header = array(array('Tipo','Value'));

		if(count($evento)>0){
			$sql = "SELECT t.`nombre`, ot.`totals`, t.`id`
					FROM tickets t
					LEFT JOIN (SELECT COUNT(id) totals, ticket_id FROM order_tickets  GROUP BY ticket_id) ot ON ot.`ticket_id` = t.`id`
					WHERE t.`evento_id` = ?  AND t.`id` = ot.`ticket_id`";

			$acreditados = $this->db->query($sql,[$this->evento_id])->result();
			$values = array();
			foreach($acreditados as $acreditado){
				$values[] = array($acreditado->nombre, (int)$acreditado->totals);
			}
		$success      = true;
		$responseType = 'function';
		$function     = 'intiPiePlanes';
		$messages     = array_merge($header,$values);
		$data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
		return $data;
		} else {
			return false;
		}
	}

	public function getTotalOrders(){
		$sql = "SELECT COUNT(id) total
  				FROM orders
  				WHERE orders.`evento_id` = ?";
		$total = $this->db->query($sql, [$this->evento_id])->row();

		return $total;
	}

	public function getOrderByStatus(){
		$sql ="SELECT COUNT(orders.`id`) total,
				CASE orders.`status`
					WHEN 1 THEN 'Activas'
					WHEN 2 THEN 'Archivadas'
					WHEN -1 THEN 'Canceladas'
				END estado
				FROM orders
				WHERE orders.`evento_id` = ?
				GROUP BY orders.`status`";

		$total = $this->db->query($sql, [$this->evento_id])->result();
		return $total;
	}


	public function cuponsStats(){

		$sql = "SELECT CONCAT(d.quantity,'/',d.available) quantity_used, d.code nombre
				FROM cupons d
				WHERE d.evento_id= ?
				ORDER BY d.available DESC";

		$result = $this->db->query($sql,[$this->evento_id])->result();
		return $result;
	}



	//SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%Y/%m/%d') fa FROM acreditados GROUP BY DATE_FORMAT(fa, '%Y/%m/%d')
	public function getSmallStats(){
	   // $recaudado    = $this->getSmall('recaudado');
	   /* $suscriptores = $this->getSmall('suscriptores');
		$smallStats = $recaudado.$suscriptores;
		return $smallStats;*/
	}



	public function getTotalActiveCheckins(){
		$sql = "SELECT COUNT(id) total FROM acreditados WHERE status = 1 AND acreditado = 1 AND evento_id = ?";
		$total = $this->db->query($sql,[$this->evento_id])->row();
		return $total;
	}

	public function getTotalLunch(){
		/*$sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 1  AND evento_id = $this->evento_id and lunch = 1";
		$total = $this->db->query($sql)->row();
		return $total;*/
	}

	private function getSmall($tipo){
	   /*
		switch($tipo){
			case 'recaudado':
				$this->db->where_in('pago_status',array(1,2));
				$this->db->select_sum('transaction_amount','value');
				$query = $this->db->get('pagos')->row();
				$icon  = 'icon-money';
				$color = 'blue';
				$title = $tipo;
				$value = $query->value;
				$this->db->flush_cache();
			break;
			case 'suscriptores':
				$this->db->where('number.status',1);
				$this->db->from('acreditados number');
				$value = $this->db->count_all()->row();
				echo $value;
				$this->db->flush_cache();
				$icon  = 'icon-user';
				$color = 'blue';
				$title = $tipo;
				lq();
			break;
		}
		return $this->view('layout/panels/smallstats',array('value'=>$value, 'icon'=>$icon, 'color'=>$color, 'title'=>$title));
		*/
	}

	public function getInscriptosChart() {
		$evento = $this->db->get_where('eventos',array('status'=>1))->row();

		if(count($evento)>0){
			//	$sql = "SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%d-%m-%Y') fa FROM acreditados WHERE status >= 0  AND evento_id =? GROUP BY DATE_FORMAT(fa, '%d-%m-%Y') ORDER BY acreditados.fa ASC";
		//	$nominados = $this->db->query($sql, [$this->evento_id])->result();

			$sql = "SELECT SUM(ot.nominar) total_by_date, DATE_FORMAT(o.fa, '%d-%m-%Y') fa FROM orders o LEFT JOIN order_tickets ot ON ot.order_id = o.id WHERE o.evento_id = ? AND ot.tipo = 1  GROUP BY DATE_FORMAT(o.fa, '%d-%m-%Y') ORDER BY o.fa ASC";
			$nominados = $this->db->query($sql, [$this->evento_id])->result();


			$fechainicio = date('Y-m-d',strtotime($evento->fa." - 1 day"));
			$fechafin    = date('Y-m-d',strtotime($evento->fecha_baja));
			//$arrayFechas = $this->devuelveArrayFechasEntreOtrasDos($fechainicio,$fechafin);

			$values = array();
			if(count($nominados)>0){
				foreach($nominados as $registro){
						$registros = ($registro->total_by_date) ? $registro->total_by_date : 0;
						$values[] = array($registro->fa, (int)$registros);
				}
			} else {
				$values[] = array(date('Y-m-d'),0);
			}

			//ep($values);
		$success      = true;
		$responseType = 'function';
		$function     = 'initChart';
		$messages     = $values;
		$data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
		return $data;
		} else {
			$success      = false;
			$data = array('success' => $success);
			return $data;
		}
	}

	public function nominaciones(){
		$sql = "SELECT SUM(nominar) nominaciones FROM order_tickets LEFT JOIN tickets ON (tickets.id = order_tickets.`ticket_id`) WHERE order_tickets.evento_id = ? AND tickets.`tipo` = ?";
		$total_nominar = $this->db->query($sql,[$this->evento_id,1])->row();

		$sql = "SELECT COUNT(acreditados.id) acreditados FROM acreditados LEFT JOIN order_tickets ON acreditados.`order_ticket_id` = order_tickets.id LEFT JOIN tickets ON tickets.`id` = order_tickets.ticket_id WHERE acreditados.evento_id = ? AND tickets.`tipo` = ?";
		$total_nominados = $this->db->query($sql,[$this->evento_id,1])->row();

		return ["Inscriptos"=>$total_nominar->nominaciones, "Nominados"=>$total_nominados->acreditados, "Pendientes"=>($total_nominar->nominaciones-$total_nominados->acreditados)];
	}


	 public function devuelveArrayFechasEntreOtrasDos($fechaInicio, $fechafin){
		/*$arrayFechas=array();
		$fechaMostrar = $fechaInicio;
			while(strtotime($fechaMostrar) <= strtotime($fechafin)) {
				$fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
				$arrayFechas[]=$fechaMostrar;
			}
			return $arrayFechas;*/
	}

	public function getTotalCheckInByTipo(){

		$sql = "SELECT SUM(acreditados.acreditado) totals, tickets.nombre
				FROM acreditados
				LEFT JOIN order_tickets ON order_tickets.id = acreditados.order_ticket_id
				LEFT JOIN tickets ON tickets.id = order_tickets.ticket_id
				WHERE acreditados.evento_id = ?
				AND acreditados.acreditado = 1
				GROUP BY tickets.id
				ORDER BY SUM(acreditados.acreditado)  DESC";
		$totals = $this->db->query($sql,[$this->evento_id])->result();

		return array('totales' =>$totals);
	}

	public function avgCheckIn(){
		$sql = "SELECT AVG(acreditado) total FROM acreditados WHERE evento_id = ?";
		$total = $this->db->query($sql, [$this->evento_id])->row();
		return $total;
	}








	public function getBarsByTicket(){
		$sql ="SELECT ot.evento_id, COUNT(ot.id) total, t.nombre, t.background
			   FROM order_tickets ot
			   LEFT JOIN tickets t ON t.id = ot.ticket_id
			   WHERE ot.evento_id = ?
			   AND t.tipo != ?
			   GROUP BY ot.ticket_id, ot.evento_id";
		$total_tickets = $this->db->query($sql, [$this->evento_id,2])->result();

		$values = array();
		foreach($total_tickets as $tkt){
			$values[] = array(ucwords($tkt->nombre), (int)$tkt->total, '#'.$tkt->background);
		}
		$success      = true;
		$responseType = 'function';
		$function     = 'initBarTickets';

		$data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$values, 'value'=>$function);
		return $data;
	}

	public function getFacturacionTotal(){
		$sql ="SELECT SUM(o.total_discounted_price) total FROM orders o INNER JOIN pagos p ON p.order_id = o.id WHERE o.status >=0  AND o.evento_id = ?";

		$total_facturacion = $this->db->query($sql, [$this->evento_id])->row();
		return $total_facturacion;
	}

	public function getFacturacionTotalStatus(){
		$total_facturacion = $this->getFacturacionTotal();

		$sql = "SELECT SUM(o.total_discounted_price) total FROM orders o INNER JOIN pagos p ON p.order_id = o.id WHERE o.status >=0 AND p.pago_status = 2  AND o.evento_id = ?";
		$total_facturacion_pendiente = $this->db->query($sql, [$this->evento_id])->row();

		$sql = "SELECT SUM(o.total_discounted_price) total FROM orders o INNER JOIN pagos p ON p.order_id = o.id WHERE o.status >=0 AND p.pago_status = 1  AND o.evento_id = ?";
		$total_facturacion_aprobada = $this->db->query($sql, [$this->evento_id])->row();

		$sql = "SELECT SUM(o.total_discounted_price) total FROM orders o INNER JOIN pagos p ON p.order_id = o.id WHERE o.status >=0 AND p.pago_status = -1  AND o.evento_id = ?";
		$total_facturacion_rechazada = $this->db->query($sql, [$this->evento_id])->row();

		return array('total'=> ($total_facturacion->total) ? $total_facturacion->total : 0,
					 'facturacion_pendiente'=> ($total_facturacion_pendiente->total) ? $total_facturacion_pendiente->total : 0,
					 'facturacion_aprobada'=> ($total_facturacion_aprobada->total) ? $total_facturacion_aprobada->total : 0,
					 'facturacion_rechazada'=>($total_facturacion_rechazada->total) ? $total_facturacion_rechazada->total : 0);
	}

	public function getFacturacionPendienteByMedio(){
		$sql ="SELECT SUM(o.total_discounted_price) total, o.gateway
			   FROM orders o
			   INNER JOIN pagos p ON p.order_id = o.id
			   WHERE o.status >= 1
			   AND p.pago_status = 2
			   AND o.evento_id = ?  GROUP BY o.gateway";
		$total_facturacion_pendiente_medio = $this->db->query($sql, [$this->evento_id])->result();
		return $total_facturacion_pendiente_medio;
	}




	public function getInscriptosPagosPie(){
		$this->db->from('orders');
		$this->db->where('status >=',0);
		$total = $this->db->count_all_results();

		$sql = "SELECT COUNT(id) total_pagantes FROM orders WHERE STATUS >= 0 AND total_discounted_price > 0  AND evento_id = ?";

		$pagantes_q = $this->db->query($sql,[$this->evento_id])->row();

		$pagantes = (int) $pagantes_q->total_pagantes;
		$no_pagantes = (int)($total-$pagantes_q->total_pagantes);
		$header = array(array('Tipo','Value'));
		$pagos = array(array('Pagantes',$pagantes),
					   array('No Pagantes',$no_pagantes)
							  );
		$pagos = array_merge($header,$pagos);
		$success      = true;
		$responseType = 'function';
		$function     = 'intiPiePagos';
		$messages     = $pagos;
		$data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
		return $data;
	}
}
