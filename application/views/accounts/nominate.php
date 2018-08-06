<div class="container clearfix">

					<div class="row clearfix">

						<div class="col-sm-3 clearfix">

							<div class="list-group">
								<a href="<?php echo base_url('account/summary')?>" class="list-group-item clearfix">Mis Eventos <i class="icon-calendar pull-right"></i></a>
								<a href="<?php echo base_url('account/profile')?>" class="list-group-item clearfix">Mis datos <i class="icon-user pull-right"></i></a>
								<a href="<?php echo base_url('auth/logout')?>" class="list-group-item clearfix">Logout <i class="icon-line2-logout pull-right"></i></a>
							</div>

						</div>

						<div class="line visible-xs-block"></div>

						<div class="col-sm-9">

							<div class="row clearfix">

								<div class="col-md-12">
								<?php foreach($tickets as $ticket) { ?>
									<div class="panel panel-default">
						<!-- Default panel contents -->
							<div class="panel-heading">

								<div class="fancy-title title-bottom-border">
										<h6><?php echo $ticket->nombre ?><span> (<?php echo $ticket->nominar ?>)</span></h6>
									</div>
							</div>
							<div class="panel-body">
								<p>Desde este panel podrá nominar las entradas adquiridas.</p>
							</div>

							<!-- Table -->
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Email</th>
										<th>Editar</th>
										<th>Invitar</th>
									</tr>
								</thead>
								<tbody>

								<?php
								$nominar = $ticket->nominar;

								while( $nominar > 0) {
									$this->load->view('accounts/nominar_item', ['item'=>$ticket, 'row'=>$nominar]);
									$nominar--;
								}
								?>



								</tbody>
							</table>
						</div>


								<?php } ?>

								</div>

							</div>

						</div>




					</div>

				</div>

