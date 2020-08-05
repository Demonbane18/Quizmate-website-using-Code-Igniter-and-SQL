					<ul id="mainmenu">
						<li><?php echo anchor('', 'Home'); ?></li>
						<li><a href="#">Subjects</a>
							<ul>
								<li><?php echo anchor('courses/upcoming', 'Upcoming Quizzes'); ?></li>
							</ul>
						</li>
						<li class="sign-in-btn"><?php
							$mnlogout = anchor('auth/logout', 'Log Out');
							if ($this->session->userdata('fname') != null)
							{
								echo <<<HTML
								<a href="#">{$this->session->userdata('fname')}</a>
								<ul>
									<li>
										
									</li>
									<li>
										{$mnlogout}
									</li>
								</ul>
HTML;
							}
							else
							{
								echo anchor('auth/login', 'Login'); 
							}

						?></li>
					</ul>