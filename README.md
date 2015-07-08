<h4>COMPARE IMAGES</h4> <h6>PHP code</h6>

This is a repository that can be used to compare two images on the scale 0-100 ( 0 being least similar and 100 being the highest). The images can be of type jpg, png, gif or bmp.

In the file <strong>check_similar.php</strong>, insert your two file links in the function call 
<blockquote>$scale= return_scale( foo,bar );
</blockquote>
<blockquote>
<h6>EXAMPLE</h6> $scale= return_scale( 'http://example_website.com/image1.jpg' , 'http://example_site.com/logo.jpg' );
</blockquote>
where the variable $scale will get the result in 100.


This code uses the algorithm from <a href="http://www.hackerfactor.com/blog/index.php?/archives/432-Looks-Like-It.html" target="_blank">http://www.hackerfactor.com/blog/index.php?/archives/432-Looks-Like-It.html</a>
