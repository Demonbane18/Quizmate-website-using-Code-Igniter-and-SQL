	<!-- content begin -->
	<div id="content">
		<div class="container">
			<div class="row fix">
				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>OOP</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Object-Oriented Programming</a></h4>
							<span class="author">Gelo Atienza</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>BChem</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Basic Chemistry</a></h4>
							<span class="author">Kendrick Tan</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>Admath</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Advanced Mathematics</a></h4>
							<span class="author">William Rabena</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>EngMan</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Engineering Management</a></h4>
							<span class="author">John Smith</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			

				<div class="col-md-8">
					<h3>Latest Quiz</h3> 
					<div class="row fix">
						<?php 
							foreach ($coursesList as $courseItem) {
								$desc = strip_tags($courseItem['description']);
								echo <<<HTML
						<div class="span2 course-item-small center">
							<div class="inner">
								<div class="hover">
									<span>{$desc}</span>
								</div>
								<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
								<div class="info">
									<h5><a href="#">{$courseItem['name']}</a></h5>
									<span class="author">{$courseItem['shortname']}</span>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
HTML;
							}

						?>

					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- content close -->

