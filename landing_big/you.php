
<!DOCTYPE html>
<html>
  <body>
  <div class="youtube-container">
	                    <iframe src="https://www.youtube.com/embed/kg0i5SXeEc4?autoplay=1&loop=1&color=white&controls=0&modestbranding=1&playsinline=1&rel=0&enablejsapi=1&playlist=kg0i5SXeEc4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>

<style>
  body {
	font-family: sans-serif;
}

.youtube-container {
	overflow: hidden;
	width: 100%;
	/* Keep it the right aspect-ratio */
	aspect-ratio: 16/9;
	/* No clicking/hover effects */
	pointer-events: none;
	
  
}
.youtube-container iframe {
		/* Extend it beyond the viewport... */
		width: 300%;
		height: 100%;
		/* ...and bring it back again */
		margin-left: -100%;
	}
</style>

  </body>
</html>