<?php
/*
Plugin Name: Review Slider
*/

//--------------------------------------------------------------
//---SHORTCODE [reviewslider] "Slider de todas las reviews"-----
//--------------------------------------------------------------

// PENDING OF MODIFICATION TO USE JSON FILE AS REVIEWS SOURCE

function review_slider( $atts ) {
    
    $reviews = file_get_contents('scripts/reviews.php');
    $reviews .= '
    <style>
        .estrella {
            vertical-align: baseline;
            display: inline-block;
            width: 15px;
            height: 14px;
            margin: 0 1px;
            background-size: 15px 14px;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAABkklEQVR4Ac2Wu6oTQRzGf2JlZ+sFBbVRLMQXEJ9B0mgjgiEm+x8QtBC00FR5A5/B0kfQiIKNhcQmRDCSZGfgtOcU4Vw+SCCE3ZO9c37wwTD/y8fMsLNDUUKbSxJN4x0mNW9sDL3jK03y37gajENp2uEKTREiXgbHkaRxc8aOH2tjb3ynCWY9rq9NJW235qib2Hi9aSzFjlfUTTB+bhtrjjqJX3BDRklSrMg3+exEX3YpGH/SjBXL0kNe21v43BsHalKHvLEvD5IIPe57Y1KD6US9OY2/T7kYjM9VmaqXepKRc97xJhjLEoZL9VAv8jJ3PPSORV5T1aiWMvyLuOyNb1lNlauaqu7mQY4VD6r8945zrHhcjWmXe3nPWDVVrLafdiFIKbF+Fec7SvhUfi863JU0TjAfUYZZl9sJph+nLS6wQmPNbefNjTtltvnthuFeHPGIFBRTzsaT6F0Z41+rMxvO2lxjB8rRy1M1qi360ripay92fPjU4jwZUW5svFet73KLvCwiHgfjAQVRbWw84axxDHyajlb+vInhAAAAAElFTkSuQmCC);
            background-repeat: no-repeat;
        }
        
        .item-review-name {
            display: inline-block;
            font-weight: bold;
            font-size: 1.2em;
        }
        .item-review-rating {
            display: inline-block;
        }
        .item-review-text {
            display: block;
            text-align: justify;
            padding-top: 1.1em;
            padding-bottom: 1.1em;
            quotes: "\201C""\201D";
            margin-bottom: 0;
            border: none;
        }
        .item-review-fuente {
            font-size: 1em;
            font-weight: bold;
            margin-bottom: 100px;
        }
        .reviews {
            opacity: 0;
            position: fixed;
        }
        
        .nomuestra{
            opacity:0;
            transition: opacity 1s; 
        }
    
        .muestra {
            opacity: 1;
            transition: opacity 1s;
        }
        @media screen and (max-width: 568px) {
            .item-review-text {
                font-size:1em;
            }
            
        }
    </style>
    <div id="reviews" class="muestra"></div>
    <script>
        //var intervalo = 4000
        window.onload = function() {  
        var frases = document.getElementsByClassName("item-review");
        var index = 0;
        
        
        var alturaMax = 0;
        for (i=0;i<frases.length;i++){
            if (frases[i].clientHeight > alturaMax){
            alturaMax=frases[i].clientHeight;
            }
        }
        document.getElementById("reviews").style.height = alturaMax + "px";
        document.getElementById("reviews").innerHTML = frases[0].innerHTML;
        setInterval(sliderv2,6000);
        
        function sliderv2(){
            index++;
            if (index == frases.length){ 
             index = 0 ;
            }
            document.getElementById("reviews").className = "nomuestra";
            setTimeout(function() { 
                    document.getElementById("reviews").innerHTML = frases[index].innerHTML;
                    document.getElementById("reviews").className = "muestra";
                }, 
                1000);
        }
       }
    </script>
    ';
    
    return $reviews;
}
add_shortcode('reviewslider', 'review_slider');



//----------------------------------------------------------------
//---SHORTCODE [listareviewsV2] "Muestra todas las reviews"-------
//----------------------------------------------------------------
function lista_reviewsV2() {
	
    $reviewsJson = json_decode(file_get_contents('scraping-reviews/reviews.json'), true);
	
    $output = '
    <style>
        .estrella {
            vertical-align: baseline;
            display: inline-block;
            width: 15px;
            height: 14px;
            margin: 0 1px;
            background-size: 15px 14px;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAABkklEQVR4Ac2Wu6oTQRzGf2JlZ+sFBbVRLMQXEJ9B0mgjgiEm+x8QtBC00FR5A5/B0kfQiIKNhcQmRDCSZGfgtOcU4Vw+SCCE3ZO9c37wwTD/y8fMsLNDUUKbSxJN4x0mNW9sDL3jK03y37gajENp2uEKTREiXgbHkaRxc8aOH2tjb3ynCWY9rq9NJW235qib2Hi9aSzFjlfUTTB+bhtrjjqJX3BDRklSrMg3+exEX3YpGH/SjBXL0kNe21v43BsHalKHvLEvD5IIPe57Y1KD6US9OY2/T7kYjM9VmaqXepKRc97xJhjLEoZL9VAv8jJ3PPSORV5T1aiWMvyLuOyNb1lNlauaqu7mQY4VD6r8945zrHhcjWmXe3nPWDVVrLafdiFIKbF+Fec7SvhUfi863JU0TjAfUYZZl9sJph+nLS6wQmPNbefNjTtltvnthuFeHPGIFBRTzsaT6F0Z41+rMxvO2lxjB8rRy1M1qi360ripay92fPjU4jwZUW5svFet73KLvCwiHgfjAQVRbWw84axxDHyajlb+vInhAAAAAElFTkSuQmCC);
            background-repeat: no-repeat;
        }

        .item-review {
            border: 1px solid #8c8989;
            margin-bottom: 50px;
            margin-top: 50px;
            border-radius: 16px;
            margin: 50px 0;
            margin: 50px 0;
            padding: 10px 20px;
        }
        .item-review-name {
            display: inline-block;
            font-weight: bold;
            font-size: 1.2em;
            padding-top: 10px;
        }
        .item-review-rating {
            display: inline-block;
        }
        .item-review-text {
            display: block;
            text-align: justify;
            padding-top: 1.1em;
            padding-bottom: 1.1em;
            quotes: "\201C""\201D";
            margin-bottom: 0;
            border: none;
        }
        .item-review-fuente {
            font-size: 1em;
            font-weight: bold;
            padding-bottom: 10px;
        }
        
        .item-review:last-child {
            display: none;
        }
    </style>
	<div class="reviews">';

foreach ($reviewsJson as $review) {
	
	    
	    $out = '<div class="item-review" data-review-id="' . $review['id'] . '" data-review-source="' . $review['source'] . '">';
	    $out .= '<div class="item-review-name">' . $review['name'] . ' - </div>';
	    $out .= '<div class="item-review-rating">'; 
	    for ($i = 1; $i <= $review['rating']; $i++){    
	        $out .= '<span class="estrella"></span>';
	    }
	    $out .= '</div>';
	    $out .= '<blockquote class="item-review-text">' . $review['content'] . '</blockquote>';
	    $out .= '</div>';

	   
	    $output .= $out;
	}
	$output .= '</div>';

    return $output;
}
add_shortcode('listareviewsV2', 'lista_reviewsV2');


//--------------------------------------------------------------
//---SHORTCODE [onereviewV3] "Muestra una review random"----------
//--------------------------------------------------------------
function una_reviewV3() {

   $reviewsJson = json_decode(file_get_contents('scraping-reviews/reviews.json'), true);
	
    $output = '<style>
        .estrella {
            vertical-align: baseline;
            display: inline-block;
            width: 15px;
            height: 14px;
            margin: 0 1px;
            background-size: 15px 14px;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAABkklEQVR4Ac2Wu6oTQRzGf2JlZ+sFBbVRLMQXEJ9B0mgjgiEm+x8QtBC00FR5A5/B0kfQiIKNhcQmRDCSZGfgtOcU4Vw+SCCE3ZO9c37wwTD/y8fMsLNDUUKbSxJN4x0mNW9sDL3jK03y37gajENp2uEKTREiXgbHkaRxc8aOH2tjb3ynCWY9rq9NJW235qib2Hi9aSzFjlfUTTB+bhtrjjqJX3BDRklSrMg3+exEX3YpGH/SjBXL0kNe21v43BsHalKHvLEvD5IIPe57Y1KD6US9OY2/T7kYjM9VmaqXepKRc97xJhjLEoZL9VAv8jJ3PPSORV5T1aiWMvyLuOyNb1lNlauaqu7mQY4VD6r8945zrHhcjWmXe3nPWDVVrLafdiFIKbF+Fec7SvhUfi863JU0TjAfUYZZl9sJph+nLS6wQmPNbefNjTtltvnthuFeHPGIFBRTzsaT6F0Z41+rMxvO2lxjB8rRy1M1qi360ripay92fPjU4jwZUW5svFet73KLvCwiHgfjAQVRbWw84axxDHyajlb+vInhAAAAAElFTkSuQmCC);
            background-repeat: no-repeat;
        }
        
        .item-review-name {
            display: inline-block;
            font-weight: bold;
            font-size: 1.2em;
            padding-top: 10px;
        }
        .item-review-rating {
            display: inline-block;
        }
        .item-review-text {
            padding-left: 50px;
            display: block;
            text-align: justify;
            padding-top: 1.1em;
            padding-bottom: 1.1em;
            margin-bottom: 0;
            border: none;
        }
        .item-review-fuente {
            font-size: 1em;
            font-weight: bold;
            padding-bottom: 10px;
        }
        @media screen and (max-width: 570px) {
	        .item-review-text {
		        padding-left:0;
	        }
        }</style><div id="onereview">';
        

	
	$review = $reviewsJson[mt_rand(0, count($reviewsJson)-1)]; 

	$out = '<div class="item-review" data-review-id="' . $review['id'] . '" data-review-source="' . $review['source'] . '">';
	$out .= '<div class="item-review-name">' . $review['name'] . ' - </div>';
	$out .= '<div class="item-review-rating">'; 
	for ($i = 1; $i <= $review['rating']; $i++){    
	    $out .= '<span class="estrella"></span>';
	}
	$out .= '</div>';
	$out .= '<blockquote class="item-review-text">' . $review['content'] . '</blockquote>';
	$out .= '</div>';
	
	$output .= $out . '</div>';

    return $output;
}

add_shortcode('onereviewV3', 'una_reviewV3');


