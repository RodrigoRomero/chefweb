<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends RR_Controller {

		public function Dashboard(){
				parent::__construct();
				$this->load->model("dashboard_mod", "Dashboard");
				$this->widget_view = array('charts' => array('js'=>array('Chart.min'))
																	 );
				//$this->output->enable_profiler(TRUE);
		}

	public function index(){

		 $data = array (
		 				'total_orders'						   => $this->Dashboard->getTotalOrders(),
						'total_orders_status'	   			   => $this->Dashboard->getOrderByStatus(),
						'total_by_medio_pago'                  => $this->Dashboard->getTotalByMedioPago(),
						//'cupons_stats'                         => $this->Dashboard->cuponsStats(),
						//'total_by_ticket'                      => $this->Dashboard->getTotalByTicket(),
						//'total_registros_tickets'              => $this->Dashboard->getTotal(1),
						//'total_registros_activos_tickets'      => $this->Dashboard->getTotalActive(1),
						//'total_registros_nominados_tickets'    => $this->Dashboard->getTotalNominados(1),
						//'ultimos_nominados_tickets'            => $this->Dashboard->lastNominados(1,10),
						///'total_registros_almuerzos'            => $this->Dashboard->getTotal(2),
						//'total_registros_activos_almuerzos'      => $this->Dashboard->getTotalActive(2),
						//'total_registros_nominados_almuerzos'  => $this->Dashboard->getTotalNominados(2),
						//'ultimos_nominados_almuerzos'          => $this->Dashboard->lastNominados(2,10),

						//'total_nominaciones'				   => $this->Dashboard->nominaciones(),

						//'total_checkins'                      => $this->Dashboard->getTotalActiveCheckins(),
						//'average_checkin'                     => $this->Dashboard->avgCheckIn(),
						//'total_facturacion_pendiente_medio'   => $this->Dashboard->getFacturacionPendienteByMedio(),
						//'total_checkins_by_tipo'              => $this->Dashboard->getTotalCheckInByTipo(),
						//'total_facturacion'                   => $this->Dashboard->getFacturacionTotalStatus(),
						//'smallStats'                          => $this->Dashboard->getSmallStats(),
										);
			 $module =	$this->view('dashboard/index', $data);
			 $this->_show($module);
	}

		public function getInscriptos(){
			$data = $this->Dashboard->getInscriptosChart();
			echo json_encode($data);
		}

		public function getInscriptosPlanesPie(){
			 $data = $this->Dashboard->getInscriptosPlanesPie();
			 echo json_encode($data);
		}

		public function getBarsByTicket(){
			 $data = $this->Dashboard->getBarsByTicket();
			 echo json_encode($data);
		}

		public function getInscriptosPagosPie(){
				$data = $this->Dashboard->getInscriptosPagosPie();
				echo json_encode($data);
		}
		private function _show($module){
				echo $this->show_main($module);
		}
}
