<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascritp:void(0)">
								<i class="icon-wrench"></i>
							</a>
							<ul class="dropdown-menu configuration">
								<li class="dropdown-menu-title">
 									<span>Configuración General</span>
								</li>
                            	<li>
                                    <a href="<?php echo base_url('module/load/m/usuario/a/listado')?>">
										<span class="icon green"><i class="icon-user"></i></span>
										<span class="message">Usuarios</span>
                                    </a>
                                </li>
                                <!--
								<li>
                                    <a href="<?php echo base_url('module/load/m/configuracion/a/listado')?>">
										<span class="icon green"><i class="icon-cog"></i></span>
										<span class="message">Configuraciones</span>

                                    </a>
                                </li>
                                -->
							</ul>
						</li>

						<li class="hidden-phone">
							<a class="btn" href="<?php echo base_url('auth/logout')?>">
								<i class="icon-off"></i>
							</a>
						</li>
						<!-- start: User Dropdown -->
						<li>
							<a class="btn account dropdown-toggle"  href="javascript:void(0)">

								<div class="user">
									<span class="hello">Bienvenido!</span>
									<span class="name"><?php echo get_session("admin_nombre", false).' '.get_session("admin_apellido", false) ?></span>
								</div>
							</a>

						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
