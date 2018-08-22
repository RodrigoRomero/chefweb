<?php

$testimonios = [
				['texto'=> 'Las burguers de garbanzos estan increíbles.', 'autor' => 'IA'],
				['texto'=> 'Muy buenas las hamburguesas de lentejas!.', 'autor' => 'Geo'],
				['texto'=> 'Las hamburguesas riquísimas !', 'autor' => 'Marcia'],
				['texto'=> 'Muy buenas las hamburguesas. Probamos las de lentejas y las de garbanzos ya', 'autor' => 'Rodri']
];
?>


<div class="fslider testimonial" data-animation="fade" data-arrows="false">
	<div class="flexslider"  itemscope itemtype="http://schema.org/UserComments">
		<div class="slider-wrap">
			<?php foreach($testimonios as $testimonio) { ?>
			<div class="slide">
				<div class="testi-content">
					<p itemprop="commentText"><?php echo $testimonio['texto'] ?></p>
					<div class="testi-meta" itemprop="creator">
						<?php echo $testimonio['autor'] ?>
					</div>
				</div>
			</div>

			<?php } ?>
		</div>
	</div>
</div>