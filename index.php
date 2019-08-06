<?php
    include_once 'phpQuery.php';

    class cURLparse{

	    public function print_arr($arr){
	    	echo '<pre>'.print_r($arr,true).'</pre>';
	    }

	    public function get_content($url){
	   		$ch=curl_init($url);
			curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			$res=curl_exec($ch);
			curl_close($ch);
			return $res;
	    }

	    public function parser($url){
	    	$fp=fopen('file.txt','w');
	    	$file=$this->get_content($url);
	    	$doc=phpQuery::newDocument($file);
	    		foreach ($doc->find('.products-list .products-list__item') as $article) {
	    			$article=pq($article);
	    			//$article->find('.product-item__name .product-item__name-link')->prepend('Ноутбук: ');
	    			//$article->find('.product-item__name .product-item__name-link')->remove();
	    			$text=$article->find('.product-item__name')->text();
	    	
	    			$data=$article->find('.product-options__item-initial')->text();
	    	
	    			$price=$article->find('.price-box__content-i')->text();

	    			echo $text.'</br>';
	    			echo $data.'</br>';
	    			echo 'Цена: '.$price;
	    			echo '<hr>';
	    	
	    	    fwrite($fp, $text.$data.'Цена: '.$price);
	    		}
	    		fclose($fp);
	    }
	}
    
	$parser = new cURLparse();
	$parser->parser('https://comfy.ua/notebook/');