<?
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <title></title>
 <link rel="stylesheet" type="text/css" href="blog.css">
 <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
 <script>
function createElements(result) {
	  $('#articles').empty();
  for (var i=0; i<result.length; i++) {
	   $('<div/>', {
		   'class': 'article',
		   value: result[i].id,
		   on: {
			   click: function() {
				   location.href = 'readArticle.php?article=' + $(this).val();
			   }
		   }
	   }).appendTo('#articles')
	   .append($('<div>', {
		   'class': 'articleDate',
		   text: result[i].date
	   }))
	   .append($('<div>', {
		   'class': 'articleTitle',
		   text: result[i].title
	   }))
	   .append($('<div>', {
		   'class': 'articleRate',
		   text: 'Оценка '+result[i].rate
	   }));
	   
  }
}
$(document).ready(function(){
	$.post( "getArticles.php", {sortBy: "rate"}, function(result) {
	  createElements(JSON.parse(result));
	});
    $("[name='sortArticles']").change(function(){
		$.post( "getArticles.php", {sortBy: this.value}, function(result) {
	  createElements(JSON.parse(result));
	    });
    });
});
 </script>
 </head>
 <body>
 <?
 require('header.php');
 ?>
 <h1>Блог</h1>
 <div id="sortArticles">
 Сортировать по: 
 <input type="radio" name="sortArticles" value="rate" id="sortByRate" checked />
 <label for="sortByRate">рейтингу</label>
 <input type="radio" name="sortArticles" value="date"  id="sortByDate" />
 <label for="sortByDate">новизне</label>
 </div>
 <div id="articles">
 </div>
 </body>
 </html>