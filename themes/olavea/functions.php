<?php //Insert your custom functions here

function oa_languages_list(){
	if (function_exists('icl_get_languages')) {
	    $languages = icl_get_languages('skip_missing=0&orderby=code');
	    if(!empty($languages)){
	        echo '<div id="language-list"><ul>';
	        foreach($languages as $l){
	            echo '<li>';
	            if($l['country_flag_url']){
	                if(!$l['active']) echo '<a href="'.$l['url'].'">';
	                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
	                if(!$l['active']) echo '</a>';
	            }
	            if(!$l['active']) echo '<a href="'.$l['url'].'">';
	            echo icl_disp_language($l['native_name'], $l['translated_name']);
	            if(!$l['active']) echo '</a>';
	            echo '</li>';
	        }
	        echo '</ul></div>';
	    }
    }
}

?>